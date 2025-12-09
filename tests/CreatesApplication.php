<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Force config overrides to avoid Redis dependency
        $app['config']->set('session.driver', 'file');
        $app['config']->set('cache.default', 'file');
        $app['config']->set('queue.default', 'sync');
        $app['config']->set('database.redis.client', 'predis'); // Prevent Phpredis usage

        return $app;
    }
}
