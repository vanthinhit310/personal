<?php

namespace Platform\TodoList\Services;

use App\Events\TodoCreated;
use App\Handle\ResponseHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Platform\TodoList\Models\TodoList;
use Platform\TodoList\Repositories\Interfaces\TodoListInterface;
use Throwable;
use Illuminate\Support\Str;

class TodoListService
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
    public function __construct(Request $request, ResponseHandle $response, TodoList $model, TodoListInterface $repository)
    {
        $this->request = $request;
        $this->model = $model;
        $this->response = $response;
        $this->repository = $repository;
    }

    public function getList(array $filter = [])
    {
        $query = $this->model;
        $query = $query
            ->whereOwner($this->request->user()->id)
            ->with('author')
            ->orWhereHas('members', function ($q) {
                $q->where('members.id', $this->request->user()->id);
            });
        return $query->get();
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();
            $object = $this->model->create($data);

            if (isset($data['members'])) {
                $object->members()->attach($data['members']);
            }
            DB::commit();
            $object = $object->refresh();

            $notifier = collect([$object->members])->collapse()->push($this->request->user());
            $notifier->each(function ($item) use ($object) {
                if ($item->id != $this->request->user()->id) {
                    broadcast(new TodoCreated($this->request->user(), $object, $item, 'created'));
                }
            });

            return $object;
        } catch (Throwable $exception) {
            DB::rollBack();
            $this->response->internalServerResponse($exception, __CLASS__, __FUNCTION__);
        }
    }

    public function get($id)
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
    }

    public function update($id, $data)
    {

        try {
            DB::beginTransaction();
            $object = $this->repository->findById($id);

            if (isset($object) && !blank($object)) {
                $object->update($data);
                if (isset($data['members'])) {
                    $object->members()->sync($data['members']);
                }
                DB::commit();
                $notifier = collect([$object->members])->collapse()->push($this->request->user())->push($object->author);
                $notifier->each(function ($item) use ($object) {
                    if ($item->id != $this->request->user()->id) {
                        broadcast(new TodoCreated($this->request->user(), $object, $item, 'updated'))->toOthers();
                    }
                });
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
            $object = $this->repository->findById($id, ['members']);
            $members = $object->members;
            if (isset($object) && !blank($object)) {

                $notifier = collect([$members])->collapse()->push($this->request->user());
                $notifier->each(function ($item) use ($object) {
                    if ($item->id != $this->request->user()->id) {
                        event(new TodoCreated($this->request->user(), $object, $item, 'destroyed'));
                    }
                });

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
