<?php

namespace App\Providers\RegisterMentor;

use App\Services\RegisterMentor\RegisterMentorServiceInterface;
use App\Services\RegisterMentor\RegisterMentorService;
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
