<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class BladeTitleViewComposer
{
  public function compose(View $view)
  {
    // App
      // Profile
      if (request()->is('dashboard/*')) {
        $BladeTitle = ucwords(str_replace('-', ' ', request()->segment(2)));
      }
      // Browse
      if (request()->is('forum/browse')) {
        $BladeTitle = ucwords('Browse Forum');
      }
      if (request()->is('forum/browse/*')) {
        $BladeTitle = ucwords('Browse Forum Categories');
      }
      if (request()->is('forum/browse/*/*')) {
        $BladeTitle = ucwords(str_replace('%', ' ', request()->segment(4)));
      }
      // Manage
      if (request()->is('forum/manage/*')) {
        $BladeTitle = ucwords(str_replace('-', ' ', request()->segment(3)));
      }
    // Guest
      // Landing Page
      if (request()->is('/')) {
        $BladeTitle = ucwords('Interstartas');
      }
      // Forum Login
      if (request()->is('login')) {
        $BladeTitle = ucwords('Login');
      }
      // Forum Register
      if (request()->is('register')) {
        $BladeTitle = ucwords('Register');
      }

    if (isset($BladeTitle)) {
      $view->with('BladeTitle', $BladeTitle);
    }
  }
}
