<?php

namespace Platform\SpendingDiary\Http\Controllers;

use Platform\Base\Events\BeforeEditContentEvent;
use Platform\SpendingDiary\Http\Requests\SpendingDiaryRequest;
use Platform\SpendingDiary\Repositories\Interfaces\SpendingDiaryInterface;
use Platform\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Platform\SpendingDiary\Tables\SpendingDiaryTable;
use Platform\Base\Events\CreatedContentEvent;
use Platform\Base\Events\DeletedContentEvent;
use Platform\Base\Events\UpdatedContentEvent;
use Platform\Base\Http\Responses\BaseHttpResponse;
use Platform\SpendingDiary\Forms\SpendingDiaryForm;
use Platform\Base\Forms\FormBuilder;

class SpendingDiaryController extends BaseController
{
    /**
     * @var SpendingDiaryInterface
     */
    protected $spendingDiaryRepository;

    /**
     * @param SpendingDiaryInterface $spendingDiaryRepository
     */
    public function __construct(SpendingDiaryInterface $spendingDiaryRepository)
    {
        $this->spendingDiaryRepository = $spendingDiaryRepository;
    }

    /**
     * @param SpendingDiaryTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(SpendingDiaryTable $table)
    {
        page_title()->setTitle(trans('plugins/spending-diary::spending-diary.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/spending-diary::spending-diary.create'));

        return $formBuilder->create(SpendingDiaryForm::class)->renderForm();
    }

    /**
     * @param SpendingDiaryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(SpendingDiaryRequest $request, BaseHttpResponse $response)
    {
        $spendingDiary = $this->spendingDiaryRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SPENDING_DIARY_MODULE_SCREEN_NAME, $request, $spendingDiary));

        return $response
            ->setPreviousUrl(route('spending-diary.index'))
            ->setNextUrl(route('spending-diary.edit', $spendingDiary->id))
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
        $spendingDiary = $this->spendingDiaryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $spendingDiary));

        page_title()->setTitle(trans('plugins/spending-diary::spending-diary.edit') . ' "' . $spendingDiary->name . '"');

        return $formBuilder->create(SpendingDiaryForm::class, ['model' => $spendingDiary])->renderForm();
    }

    /**
     * @param int $id
     * @param SpendingDiaryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, SpendingDiaryRequest $request, BaseHttpResponse $response)
    {
        $spendingDiary = $this->spendingDiaryRepository->findOrFail($id);

        $spendingDiary->fill($request->input());

        $this->spendingDiaryRepository->createOrUpdate($spendingDiary);

        event(new UpdatedContentEvent(SPENDING_DIARY_MODULE_SCREEN_NAME, $request, $spendingDiary));

        return $response
            ->setPreviousUrl(route('spending-diary.index'))
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
            $spendingDiary = $this->spendingDiaryRepository->findOrFail($id);

            $this->spendingDiaryRepository->delete($spendingDiary);

            event(new DeletedContentEvent(SPENDING_DIARY_MODULE_SCREEN_NAME, $request, $spendingDiary));

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
            $spendingDiary = $this->spendingDiaryRepository->findOrFail($id);
            $this->spendingDiaryRepository->delete($spendingDiary);
            event(new DeletedContentEvent(SPENDING_DIARY_MODULE_SCREEN_NAME, $request, $spendingDiary));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
