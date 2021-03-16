<?php

namespace Platform\TodoList\Providers;

use Platform\TodoList\Models\TodoList;
use Illuminate\Support\ServiceProvider;
use Platform\TodoList\Repositories\Caches\TodoListCacheDecorator;
use Platform\TodoList\Repositories\Eloquent\TodoListRepository;
use Platform\TodoList\Repositories\Interfaces\TodoListInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class TodoListServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(TodoListInterface::class, function () {
            return new TodoListCacheDecorator(new TodoListRepository(new TodoList));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/todo-list')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web','api']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([TodoList::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-todo-list',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/todo-list::todo-list.name',
                'icon'        => 'fa fa-list',
                'url'         => route('todo-list.index'),
                'permissions' => ['todo-list.index'],
            ]);
        });
    }
}
