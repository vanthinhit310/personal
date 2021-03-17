<?php

namespace Platform\Reminder\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\Reminder\Http\Requests\ReminderRequest;
use Platform\Reminder\Repositories\Interfaces\ReminderInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\Reminder\Tables\ReminderTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\Reminder\Forms\ReminderForm;
use Platform\Base\Forms\FormBuilder;

class ReminderController extends BaseController
{
    /**
     * @var ReminderInterface
     */
    protected $reminderRepository;

    /**
     * @param ReminderInterface $reminderRepository
     */
    public function __construct(ReminderInterface $reminderRepository)
    {
        $this->reminderRepository = $reminderRepository;
    }

    /**
     * @param ReminderTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(ReminderTable $table)
    {
        page_title()->setTitle(trans('plugins/reminder::reminder.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/reminder::reminder.create'));

        return $formBuilder->create(ReminderForm::class)->renderForm();
    }

    /**
     * @param ReminderRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ReminderRequest $request, BaseHttpResponse $response)
    {
        $reminder = $this->reminderRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(REMINDER_MODULE_SCREEN_NAME, $request, $reminder));

        return $response
            ->setPreviousUrl(route('reminder.index'))
            ->setNextUrl(route('reminder.edit', $reminder->id))
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
        $reminder = $this->reminderRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $reminder));

        page_title()->setTitle(trans('plugins/reminder::reminder.edit') . ' "' . $reminder->name . '"');

        return $formBuilder->create(ReminderForm::class, ['model' => $reminder])->renderForm();
    }

    /**
     * @param int $id
     * @param ReminderRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ReminderRequest $request, BaseHttpResponse $response)
    {
        $reminder = $this->reminderRepository->findOrFail($id);

        $reminder->fill($request->input());

        $this->reminderRepository->createOrUpdate($reminder);

        event(new UpdatedContentEvent(REMINDER_MODULE_SCREEN_NAME, $request, $reminder));

        return $response
            ->setPreviousUrl(route('reminder.index'))
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
            $reminder = $this->reminderRepository->findOrFail($id);

            $this->reminderRepository->delete($reminder);

            event(new DeletedContentEvent(REMINDER_MODULE_SCREEN_NAME, $request, $reminder));

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
            $reminder = $this->reminderRepository->findOrFail($id);
            $this->reminderRepository->delete($reminder);
            event(new DeletedContentEvent(REMINDER_MODULE_SCREEN_NAME, $request, $reminder));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
