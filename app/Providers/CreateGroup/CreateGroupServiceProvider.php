<?php

namespace App\Providers\CreateGroup;

use App\Services\CreateGroup\CreateGroupService;
use App\Services\CreateGroup\CreateGroupServiceInterface;
use Illuminate\Support\ServiceProvider;

class CreateGroupServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(CreateGroupServiceInterface::class, CreateGroupService::class);
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
