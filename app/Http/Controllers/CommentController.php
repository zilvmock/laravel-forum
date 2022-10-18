<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
  // View
  // **********************
  public function editComment(Request $request, $commentId, $articleId)
  {
    if ($request->user()->id != auth()->id()) {
      abort(403, 'Unauthorized action');
    } else {
      $validator = Validator::make($request->all(), [
        'edit_comment' => ['required', 'max:255'],
      ], [
        'required' => 'The :attribute field can not be blank!',
      ]);

      if ($validator->passes()) {
        $timeNow = Carbon::now();
        Comment::all()->firstWhere('id', '==', $commentId)
          ->update([
            'content' => $request->edit_comment,
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
    $validator = Validator::make($request->all(), [
      'comment' => ['required', 'max:255'],
    ], [
      'required' => 'The :attribute field can not be blank!',
    ]);

    if ($validator->passes()) {
      $timeNow = Carbon::now();
      Comment::insert([
        'content' => $request->comment,
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

  public function deleteComment($commentId)
  {
    Comment::all()->firstWhere('id', '==', $commentId)->delete();
    return redirect()->back()->with('message', 'Comment deleted!');
  }
  // **********************
}
