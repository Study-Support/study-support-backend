<?php

namespace App\Providers\RegisterMentor;

use App\Services\RegisterMentorService\RegisterMentorService;
use App\Services\RegisterMentorService\RegisterMentorServiceInterface;
use Illuminate\Support\ServiceProvider;

class RegisterMentorServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(RegisterMentorServiceInterface::class, RegisterMentorService::class);
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
