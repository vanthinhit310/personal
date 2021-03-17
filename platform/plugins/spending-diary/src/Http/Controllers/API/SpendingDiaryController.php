<?php

namespace Platform\SpendingDiary\Http\Controllers\API;

use App\Handle\Constant;
use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\SpendingDiary\Http\Requests\SpendingDiaryRequest;
use Platform\SpendingDiary\Http\Resources\DiaryResource;
use Platform\SpendingDiary\Services\DiaryService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SpendingDiaryController extends Controller
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
    public function __construct(Request $request, BaseHttpResponse $baseHttpResponse, ResponseHandle $response, DiaryService $service)
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
                ->setData(['resources' => DiaryResource::collection($results)])
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function store(SpendingDiaryRequest $request)
    {
        try {
            $params = $request->all();
            $params = array_merge($params, ['member_id' => $request->user()->id]);
            $result = $this->service->create($params);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setData(['resource' => new DiaryResource($result)])
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
                ->setData(['resource' => new DiaryResource($result)])
                ->setCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            return $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function update($id, SpendingDiaryRequest $request)
    {
        try {
            $params = $request->all();
            $params = array_merge($params, ['owner' => $request->user()->id]);
            $result = $this->service->update($id, $params);
            if ($result instanceof $this->baseHttpResponse) {
                return $result;
            }
            return $this->baseHttpResponse
                ->setData(['resource' => new DiaryResource($result)])
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
