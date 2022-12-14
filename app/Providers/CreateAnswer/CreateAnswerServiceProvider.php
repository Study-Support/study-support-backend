<?php

namespace App\Providers\CreateAnswer;

use App\Services\CreateAnswer\CreateAnswerService;
use App\Services\CreateAnswer\CreateAnswerServiceInterface;
use Illuminate\Support\ServiceProvider;

class CreateAnswerServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(CreateAnswerServiceInterface::class, CreateAnswerService::class);
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
