<?php

namespace JoshuaBedford\LaravelWordFilter\Providers;

use JoshuaBedford\LaravelWordFilter\WordFilter;
use Illuminate\Support\ServiceProvider;

class WordFilterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/word.php'), 'word');

        $this->app->singleton('wordFilter', function () {

            // Instantiate a word filter class.
            return new WordFilter(config('word'));
        });
    }

    /**
     * Register routes, translations, views and publishers.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
          realpath(__DIR__.'/../../config/word.php') => config_path('word.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_word_list_tables.php.stub' => $this->getMigrationFileName($filesystem),
        ], 'migrations');

        app('validator')->extend('word', function ($attribute, $value, $parameters, $validator) {
            return app('wordFilter')->noProhibitedWords($value);
        });
    }
}
