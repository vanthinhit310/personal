<?php

namespace Platform\Notification\Providers;

use Platform\Notification\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Platform\Notification\Repositories\Caches\NotificationCacheDecorator;
use Platform\Notification\Repositories\Eloquent\NotificationRepository;
use Platform\Notification\Repositories\Interfaces\NotificationInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class NotificationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(NotificationInterface::class, function () {
            return new NotificationCacheDecorator(new NotificationRepository(new Notification));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/notification')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Notification::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-notification',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/notification::notification.name',
                'icon'        => 'fa fa-list',
                'url'         => route('notification.index'),
                'permissions' => ['notification.index'],
            ]);
        });
    }
}
