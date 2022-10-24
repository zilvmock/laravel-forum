<?php

namespace App\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    Blade::withoutDoubleEncoding();

    /**
     * Paginate a standard Laravel Collection.
     *
     * @param int $perPage
     * @param int $total
     * @param int $page
     * @param string $pageName
     * @return array
     */
    Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
      $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

      return new LengthAwarePaginator(
        $this->forPage($page, $perPage),
        $total ?: $this->count(),
        $perPage,
        $page,
        [
          'path' => LengthAwarePaginator::resolveCurrentPath(),
          'pageName' => $pageName,
        ]
      );
    });
  }
}
