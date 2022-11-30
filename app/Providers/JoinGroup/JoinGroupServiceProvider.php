<?php

namespace App\Providers\JoinGroup;

use App\Services\JoinGroup\JoinGroupService;
use App\Services\JoinGroup\JoinGroupServiceInterface;
use Illuminate\Support\ServiceProvider;

class JoinGroupServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(JoinGroupServiceInterface::class, JoinGroupService::class);
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
  }
}
