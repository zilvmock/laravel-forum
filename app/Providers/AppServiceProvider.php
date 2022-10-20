<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    View::composer(
      'layouts.app', 'App\Http\ViewComposers\BladeTitleViewComposer'
    );
    View::composer(
      'layouts.guest', 'App\Http\ViewComposers\BladeTitleViewComposer'
    );
  }
}
