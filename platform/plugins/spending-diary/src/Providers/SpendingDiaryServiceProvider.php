<?php

namespace Platform\SpendingDiary\Providers;

use Platform\SpendingDiary\Models\SpendingDiary;
use Illuminate\Support\ServiceProvider;
use Platform\SpendingDiary\Repositories\Caches\SpendingDiaryCacheDecorator;
use Platform\SpendingDiary\Repositories\Eloquent\SpendingDiaryRepository;
use Platform\SpendingDiary\Repositories\Interfaces\SpendingDiaryInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class SpendingDiaryServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SpendingDiaryInterface::class, function () {
            return new SpendingDiaryCacheDecorator(new SpendingDiaryRepository(new SpendingDiary));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/spending-diary')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([SpendingDiary::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-spending-diary',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/spending-diary::spending-diary.name',
                'icon'        => 'fa fa-list',
                'url'         => route('spending-diary.index'),
                'permissions' => ['spending-diary.index'],
            ]);
        });
    }
}
