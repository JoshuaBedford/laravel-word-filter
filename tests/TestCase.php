<?php

namespace JoshuaBedford\LaravelWordFilter\Tests;

use \Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        $app->register(\JoshuaBedford\LaravelWordFilter\Providers\WordFilterServiceProvider::class);

        return $app;
    }
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // $this->loadLaravelMigrations(['--database' => 'laravel_word_filter_test']);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('database.default', 'laravel_word_filter_test');
    }
}
