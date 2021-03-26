<?php

namespace Platform\Notification\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\Notification\Http\Requests\NotificationRequest;
use Platform\Notification\Repositories\Interfaces\NotificationInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\Notification\Tables\NotificationTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\Notification\Forms\NotificationForm;
use Platform\Base\Forms\FormBuilder;

class NotificationController extends BaseController
{
    /**
     * @var NotificationInterface
     */
    protected $notificationRepository;

    /**
     * @param NotificationInterface $notificationRepository
     */
    public function __construct(NotificationInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param NotificationTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(NotificationTable $table)
    {
        page_title()->setTitle(trans('plugins/notification::notification.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/notification::notification.create'));

        return $formBuilder->create(NotificationForm::class)->renderForm();
    }

    /**
     * @param NotificationRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(NotificationRequest $request, BaseHttpResponse $response)
    {
        $notification = $this->notificationRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(NOTIFICATION_MODULE_SCREEN_NAME, $request, $notification));

        return $response
            ->setPreviousUrl(route('notification.index'))
            ->setNextUrl(route('notification.edit', $notification->id))
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
        $notification = $this->notificationRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $notification));

        page_title()->setTitle(trans('plugins/notification::notification.edit') . ' "' . $notification->name . '"');

        return $formBuilder->create(NotificationForm::class, ['model' => $notification])->renderForm();
    }

    /**
     * @param int $id
     * @param NotificationRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, NotificationRequest $request, BaseHttpResponse $response)
    {
        $notification = $this->notificationRepository->findOrFail($id);

        $notification->fill($request->input());

        $this->notificationRepository->createOrUpdate($notification);

        event(new UpdatedContentEvent(NOTIFICATION_MODULE_SCREEN_NAME, $request, $notification));

        return $response
            ->setPreviousUrl(route('notification.index'))
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
            $notification = $this->notificationRepository->findOrFail($id);

            $this->notificationRepository->delete($notification);

            event(new DeletedContentEvent(NOTIFICATION_MODULE_SCREEN_NAME, $request, $notification));

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
            $notification = $this->notificationRepository->findOrFail($id);
            $this->notificationRepository->delete($notification);
            event(new DeletedContentEvent(NOTIFICATION_MODULE_SCREEN_NAME, $request, $notification));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
