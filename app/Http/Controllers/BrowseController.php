<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrowseController extends Controller
{
  // Return posts views
  // **********************
  public function showBrowseView()
  {
    $categories = Category::all();
    $groups = Group::all();

    $groupNames = $groups->unique('group_name');
    $groupIds = $categories->unique('group_id');
    $empty = collect();
    foreach ($groupIds as $id) {
      $empty->push($id['group_id']);
    }

    return view('forum/browse', [
      'categories' => $categories,
      'groupNames' => $groupNames,
      'empty' => $empty
    ]);
  }
  // **********************
}
