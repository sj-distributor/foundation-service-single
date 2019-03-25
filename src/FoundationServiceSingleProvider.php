<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 2018/7/16
 * Time: 22:08
 */

namespace Wiltechsteam\FoundationServiceSingle;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Wiltechsteam\FoundationServiceSingle\Commands\FoundationSingleCommand;
use Wiltechsteam\FoundationServiceSingle\Commands\FoundationServiceGetConfigCommand;
use Wiltechsteam\FoundationServiceSingle\Commands\FoundationServiceMakeCommand;

class FoundationServiceSingleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->eventBoot(); //事件监听绑定
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/foundation.php', 'foundation');

        $this->app->singleton('foundation:work',FoundationSingleCommand::class);

        $this->commands(['foundation:work']);

        $this->app->singleton('foundation:make', function() {
            return new FoundationServiceMakeCommand();
        });
        $this->commands([
            'foundation:make'
        ]);

        $this->app->singleton('foundation:config', function() {
            return new FoundationServiceGetConfigCommand();
        });
        $this->commands([
            'foundation:config'
        ]);

        $this->bindEvents();
    }


    private function bindEvents()
    {
        foreach (config('foundation.events') as $key => $className)
        {
            $this->app->bind($key,$className);
        }
    }


    /**
     * 批量绑定事件监听
     */
    public function eventBoot()
    {
        foreach (config('foundation.listens') as $event => $listeners)
        {
            foreach ($listeners as $listener)
            {
                Event::listen($event, $listener);
            }
        }
    }
}