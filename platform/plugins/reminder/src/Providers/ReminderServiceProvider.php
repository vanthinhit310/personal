<?php

namespace Platform\Reminder\Providers;

use Platform\Reminder\Models\Reminder;
use Illuminate\Support\ServiceProvider;
use Platform\Reminder\Repositories\Caches\ReminderCacheDecorator;
use Platform\Reminder\Repositories\Eloquent\ReminderRepository;
use Platform\Reminder\Repositories\Interfaces\ReminderInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class ReminderServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(ReminderInterface::class, function () {
            return new ReminderCacheDecorator(new ReminderRepository(new Reminder));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/reminder')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Reminder::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-reminder',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/reminder::reminder.name',
                'icon'        => 'fa fa-list',
                'url'         => route('reminder.index'),
                'permissions' => ['reminder.index'],
            ]);
        });
    }
}
