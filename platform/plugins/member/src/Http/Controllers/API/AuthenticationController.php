<?php

namespace Platform\Member\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Google\Client;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\Member\Http\Requests\LoginRequest;
use Platform\Member\Http\Requests\RegisterRequest;
use Platform\Member\Notifications\API\ConfirmEmailNotification;
use Platform\Member\Repositories\Interfaces\MemberInterface;
use Platform\ACL\Traits\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RvMedia;

class AuthenticationController extends Controller
{
    use RegistersUsers;

    /**
     * @var MemberInterface
     */
    protected $memberRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param MemberInterface $memberRepository
     */
    public function __construct(MemberInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Register
     *
     * @bodyParam first_name string required The name of the user.
     * @bodyParam last_name string required The name of the user.
     * @bodyParam email string required The email of the user.
     * @bodyParam phone string required The phone of the user.
     * @bodyParam password string  required The password of user to create.
     * @bodyParam password_confirmation string  required The password confirmation.
     *
     * @response {
     * "error": false,
     * "data": null,
     * "message": "Registered successfully! We sent an email to you to verify your account!"
     * }
     * @response  422 {
     * "message": "The given data was invalid.",
     * "errors": {
     *     "first_name": [
     *         "The first name field is required."
     *     ],
     *     "last_name": [
     *         "The last name field is required."
     *     ],
     *     "email": [
     *         "The email field is required."
     *     ],
     *     "password": [
     *         "The password field is required."
     *     ]
     *   }
     * }
     *
     * @group     Authentication
     *
     * @param RegisterRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function register(RegisterRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);

        $member = $this->memberRepository->create($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'password',
        ]));

        $token = Hash::make(Str::random(32));

        $member->email_verify_token = $token;
        $member->save();

        $member->notify(new ConfirmEmailNotification($token));

        return $response
            ->setMessage(__('Registered successfully! We sent an email to you to verify your account!'));
    }

    /**
     * Login
     *
     * @bodyParam login string required The email/phone of the user.
     * @bodyParam password string required The password of user to create.
     *
     * @response {
     * "error": false,
     * "data": {
     *    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0xxx"
     * },
     * "message": null
     * }
     *
     * @group     Authentication
     *
     * @param LoginRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function login(LoginRequest $request, BaseHttpResponse $response)
    {
        if (auth('member')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            $token = auth('member')->user()->createToken('Laravel Password Grant Client')->accessToken;

            return $response
                ->setData(compact('token'));
        }

        return $response
            ->setError()
            ->setCode(422)
            ->setMessage(__('Email or password is not correct!'));
    }

    public function loginWithGoogle(Request $request, BaseHttpResponse $response)
    {
        try {
            $email = $request->input('email');

            if ($email) {
                $member = $this->memberRepository->getFirstBy(['email' => $email]);
                if ($member) {
                    if (auth('member')->loginUsingId($member->id, true)) {
                        $token = auth('member')->user()->createToken('Laravel Password Grant Client')->accessToken;
                        return $response
                            ->setData(compact('token'));
                    } else {
                        return $response
                            ->setError()
                            ->setMessage('Login failed!')
                            ->setCode(422);
                    }
                } else {
                    if ($request->input('avatar')) {
                        $avatar = RvMedia::uploadFromUrl($request->input('avatar'), 0, 'accounts', 'image/png');
                        if (!$avatar['error']) {
                            $avatarId = $avatar['data']->id;
                        }
                    }
                    $member = $this->memberRepository->create([
                        'first_name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name'),
                        'email' => $request->input('email'),
                        'password' => bcrypt(123456),
                        'avatar_id' => $avatarId ?? null
                    ]);

                    $token = Hash::make(Str::random(32));

                    $member->email_verify_token = $token;
                    $member->save();

                    $member->notify(new ConfirmEmailNotification($token));

                    if (auth('member')->loginUsingId($member->id, true)) {
                        $token = auth('member')->user()->createToken('Laravel Password Grant Client')->accessToken;
                        return $response
                            ->setData(compact('token'));
                    }
                }
            }
        } catch (Throwable $exception) {
            Log::error(sprintf('Have an error in action %s with message %s', sprintf('%s@%s', __CLASS__, __FUNCTION__), $exception->getMessage()));
            return $response
                ->setError()
                ->setCode(500)
                ->setMessage(__('Oop! Have Error'));
        }
    }

    /**
     * Logout
     *
     * @group Authentication
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function logout(Request $request, BaseHttpResponse $response)
    {
        $request->user()->token()->revoke();

        return $response
            ->setMessage(__('You have been successfully logged out!'));
    }

}
