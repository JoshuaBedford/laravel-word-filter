<?php

namespace JoshuaBedford\LaravelWordFilter;

use JoshuaBedford\LaravelWordFilter\WordFilter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class WordFilterServiceProvider extends ServiceProvider
{

    /**
     * Register routes, translations, views and publishers.
     *
     * @return void
     */
    public function boot(Filesystem $filesystem)
    {

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
          realpath(__DIR__.'/../config/word.php') => config_path('word.php'),
        ], 'config');

        app('validator')->extend('username_word_filter', function ($attribute, $value, $parameters) {
            return app('wordFilter')->noProhibitedWords($value);
        }, "This username is not allowed.");
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/word.php'), 'word');

        $this->app->singleton('wordFilter', function () {

            // Instantiate a word filter class.
            return new WordFilter(config('word'));
        });
    }

}
