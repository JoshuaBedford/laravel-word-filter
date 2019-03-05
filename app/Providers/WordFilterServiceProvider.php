<?php

namespace JoshuaBedford\LaravelWordFilter\Providers;

use JoshuaBedford\LaravelWordFilter\WordFilter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

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
    public function boot(Filesystem $filesystem)
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



    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_word_list_tables.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_word_list_tables.php")
            ->first();
    }
}
