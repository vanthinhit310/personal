<?php

namespace Platform\Reminder\Http\Controllers\API;

use App\Handle\Constant;
use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\Reminder\Http\Requests\ReminderRequest;
use Platform\Reminder\Http\Resources\ReminderResource;
use Platform\Reminder\Services\ReminderService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ReminderController extends Controller
{
    protected $request;
    protected $response;
    protected $service;
    protected $baseHttpResponse;

    /**
     * TodoListController constructor.
     * @param $request
     * @param $response
     * @param $service
     * @param $baseHttpResponse
     */
    public function __construct(Request $request, BaseHttpResponse $baseHttpResponse, ResponseHandle $response, ReminderService $service)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
        $this->baseHttpResponse = $baseHttpResponse;
    }

    public function index(array $filter = [])
    {

        try {
            $results = $this->service->getList($filter);
            return $this->baseHttpResponse
                ->setData(['resources' => ReminderResource::collection($results)])
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function store(ReminderRequest $request)
    {
        try {
            $params = $request->all();
            $params = array_merge($params, ['member_id' => $request->user()->id]);
            $result = $this->service->create($params);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setData(['resource' => new ReminderResource($result)])
                ->setMessage(Constant::CREATE_SUCCESS_MESSAGE)
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function edit($id)
    {
        try {
            $result = $this->service->get($id);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setData(['resource' => new ReminderResource($result)])
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function update($id, ReminderRequest $request)
    {
        try {
            $params = $request->all();
            $params = array_merge($params, ['member_id' => $request->user()->id]);
            $result = $this->service->update($id, $params);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setData(['resource' => new ReminderResource($result)])
                ->setMessage(Constant::UPDATE_SUCCESS_MESSAGE)
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->service->destroy($id);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setMessage(Constant::DESTROY_SUCCESS_MESSAGE)
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function bulkDelete()
    {
        $ids = $this->request->get('ids', []);
        try {
            $result = $this->service->bulkDelete($ids);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setMessage(Constant::DESTROY_SUCCESS_MESSAGE)
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }
}
