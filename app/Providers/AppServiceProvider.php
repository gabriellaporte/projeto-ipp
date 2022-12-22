<?php

namespace App\Providers;

use App\Channels\DatabaseChannel;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Paginator::useBootstrap();
    Carbon::setLocale(config('app.locale'));
    setlocale(LC_TIME, config('app.locale'));
    $this->app->instance(IlluminateDatabaseChannel::class, new DatabaseChannel());
  }
}
