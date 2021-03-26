<?php

namespace Platform\Notification\Services;

use App\Events\TodoCreated;
use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Platform\Notification\Models\Notification;
use Platform\Notification\Repositories\Interfaces\NotificationInterface;
use Platform\TodoList\Models\TodoList;
use Platform\TodoList\Repositories\Interfaces\TodoListInterface;
use Throwable;

class NotificationService
{
    protected $request;
    protected $model;
    protected $response;
    protected $repository;

    /**
     * TodoListService constructor.
     * @param Request $request
     * @param ResponseHandle $response
     * @param TodoList $model
     * @param TodoListInterface $repository
     */
    public function __construct(Request $request, ResponseHandle $response, Notification $model, NotificationInterface $repository)
    {
        $this->request = $request;
        $this->model = $model;
        $this->response = $response;
        $this->repository = $repository;
    }

    public function getList(array $filter = [])
    {
        $query = $this->model;
        return $query::orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /* public function create($data)
    {
        try {
            DB::beginTransaction();
            $object = $this->model->create($data);

            if (isset($data['members'])) {
                $object->members()->attach($data['members']);
            }

            DB::commit();
            $object = $object->refresh();
            broadcast(new TodoCreated($this->request->user(), $object));
            return $object;
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    } */

    /* public function get($id)
    {
        try {
            $object = $this->repository->findById($id, ['author', 'members']);
            if (isset($object) && !blank($object)) {
                return $object;
            }
            return $this->response->notfoundResponse();
        } catch (Throwable $exception) {
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    } */

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

    public function readAll()
    {
        try {
            DB::beginTransaction();
            $this->model->where('status', 'Unread')->update(['status' => 'Read']);
            DB::commit();
            return true;
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
