<?php

namespace Platform\TodoList\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\TodoList\Http\Requests\TodoListRequest;
use Platform\TodoList\Repositories\Interfaces\TodoListInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\TodoList\Tables\TodoListTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\TodoList\Forms\TodoListForm;
use Platform\Base\Forms\FormBuilder;

class TodoListController extends BaseController
{
    /**
     * @var TodoListInterface
     */
    protected $todoListRepository;

    /**
     * @param TodoListInterface $todoListRepository
     */
    public function __construct(TodoListInterface $todoListRepository)
    {
        $this->todoListRepository = $todoListRepository;
    }

    /**
     * @param TodoListTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(TodoListTable $table)
    {
        page_title()->setTitle(trans('plugins/todo-list::todo-list.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/todo-list::todo-list.create'));

        return $formBuilder->create(TodoListForm::class)->renderForm();
    }

    /**
     * @param TodoListRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(TodoListRequest $request, BaseHttpResponse $response)
    {
        $todoList = $this->todoListRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(TODO_LIST_MODULE_SCREEN_NAME, $request, $todoList));

        return $response
            ->setPreviousUrl(route('todo-list.index'))
            ->setNextUrl(route('todo-list.edit', $todoList->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $todoList = $this->todoListRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $todoList));

        page_title()->setTitle(trans('plugins/todo-list::todo-list.edit') . ' "' . $todoList->name . '"');

        return $formBuilder->create(TodoListForm::class, ['model' => $todoList])->renderForm();
    }

    /**
     * @param int $id
     * @param TodoListRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, TodoListRequest $request, BaseHttpResponse $response)
    {
        $todoList = $this->todoListRepository->findOrFail($id);

        $todoList->fill($request->input());

        $this->todoListRepository->createOrUpdate($todoList);

        event(new UpdatedContentEvent(TODO_LIST_MODULE_SCREEN_NAME, $request, $todoList));

        return $response
            ->setPreviousUrl(route('todo-list.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $todoList = $this->todoListRepository->findOrFail($id);

            $this->todoListRepository->delete($todoList);

            event(new DeletedContentEvent(TODO_LIST_MODULE_SCREEN_NAME, $request, $todoList));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $todoList = $this->todoListRepository->findOrFail($id);
            $this->todoListRepository->delete($todoList);
            event(new DeletedContentEvent(TODO_LIST_MODULE_SCREEN_NAME, $request, $todoList));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
