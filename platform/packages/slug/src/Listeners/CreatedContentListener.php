<?php

namespace Platform\Slug\Listeners;

use Platform\Base\Events\CreatedContentEvent;
use Platform\Slug\Repositories\Interfaces\SlugInterface;
use Platform\Slug\Services\SlugService;
use Exception;
use Illuminate\Support\Str;
use SlugHelper;

class CreatedContentListener
{

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * CreatedContentListener constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @param SlugService $slugService
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data))) {
            try {
                $slug = $event->request->input('slug');

                if (!$slug) {
                    $slug = $event->request->input('name');
                }

                if (!$slug && $event->data->name) {
                    $slug = Str::slug($event->data->name);
                }

                if (!$slug) {
                    $slug = time();
                }

                $slugService = new SlugService($this->slugRepository);

                $this->slugRepository->createOrUpdate([
                    'key'            => $slugService->create($slug, $event->data->slug_id, get_class($event->data)),
                    'reference_type' => get_class($event->data),
                    'reference_id'   => $event->data->id,
                    'prefix'         => SlugHelper::getPrefix(get_class($event->data)),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
