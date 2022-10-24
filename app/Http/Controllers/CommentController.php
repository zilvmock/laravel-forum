<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
  // View
  // **********************
  public function editComment(Request $request, $commentId)
  {
    $fields = [
      'comment' => strip_tags(clean($request->edit_comment)),
    ];

    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $validator = Validator::make($fields, [
        'comment' => ['required', 'max:2048'],
      ], [
        'required' => 'The :attribute field can not be blank!',
      ]);

      if ($validator->passes()) {
        $timeNow = Carbon::now();
        Comment::all()->firstWhere('id', '==', $commentId)
          ->update([
            'content' => $fields['comment'],
            'content_updated_at' => $timeNow,
          ]);
        return back()->with('message', 'Comment has been posted!');
      } else {
        return back()->withErrors($validator)->with('checked', $commentId);
      }
    }
  }
  // **********************
  // Store
  // **********************
  public function storeComment(Request $request, $articleId)
  {
    $fields = [
      'comment' => strip_tags(clean($request->comment)),
    ];

    $validator = Validator::make($fields, [
      'comment' => ['required', 'max:2048'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Comment::insert([
        'content' => $fields['comment'],
        'created_at' => $timeNow,
        'updated_at' => $timeNow,
        'user_id' => auth()->user()->id,
        'article_id' => $articleId,
      ]);
      return back()->with('message', 'Comment has been posted!');
    } else {
      return back()->withErrors($validator);
    }
  }

  public function deleteComment(Request $request, $commentId)
  {
    if ($request->user()->role != 1) {
      abort(403, 'Unauthorized action');
    }
    Comment::all()->firstWhere('id', '=', $commentId)->delete();
    return redirect()->back()->with('message', 'Comment deleted!');
  }
  // **********************
}
