<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Bindings of models
     *
     * @var array
     */
    public $models = [
        'Account',
        'UserInfo',
        'Notification',
        'Question',
        'Answer'
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Abstract repositories bind concrete one.
        foreach ($this->models as $model) {
            $this->app->bind(
                "App\Repositories\Contracts\\{$model}Repository",
                "App\Repositories\Eloquents\Eloquent{$model}Repository"
            );
        }
        $this->app->bind(
            \App\Repositories\Base\Contracts\BaseRepository::class,
            \App\Repositories\Base\Eloquents\EloquentBaseRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
