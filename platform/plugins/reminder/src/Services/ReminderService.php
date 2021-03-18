<?php

namespace Platform\Reminder\Services;

use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Platform\Reminder\Models\Reminder;
use Platform\Reminder\Repositories\Interfaces\ReminderInterface;
use Throwable;

class ReminderService
{
    protected $request;
    protected $model;
    protected $response;
    protected $repository;

    /**
     * TodoListService constructor.
     * @param Request $request
     * @param ResponseHandle $response
     * @param Reminder $model
     * @param ReminderInterface $repository
     */
    public function __construct(Request $request, ResponseHandle $response, Reminder $model, ReminderInterface $repository)
    {
        $this->request = $request;
        $this->model = $model;
        $this->response = $response;
        $this->repository = $repository;
    }

    public function getList(array $filter = [])
    {
        $query = $this->model;
        return $query::with('author')->get();
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();
            $object = $this->model->create($data);
            DB::commit();
            return $object;
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function get($id)
    {
        try {
            $object = $this->repository->findById($id, ['author']);
            if (isset($object) && !blank($object)) {
                return $object;
            }
            return $this->response->notfoundResponse();
        } catch (Throwable $exception) {
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function update($id, $data)
    {

        try {
            DB::beginTransaction();
            $object = $this->repository->findById($id);
            if (isset($object) && !blank($object)) {
                $object->update($data);
                DB::commit();
                return $object;
            }
            DB::rollBack();
            return $this->response->notfoundResponse();
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $object = $this->repository->findById($id);
            if (isset($object) && !blank($object)) {
                $object->delete();
                DB::commit();
                return true;
            }
            DB::rollBack();
            return $this->response->notfoundResponse();
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function bulkDelete(array $ids = [])
    {
        try {
            DB::beginTransaction();
            if (is_array($ids) && !blank($ids)) {
                $this->model->whereIn('id', $ids)->delete();
                DB::commit();
                return true;
            }
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }
}
