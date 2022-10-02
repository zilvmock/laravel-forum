<?php

namespace App\Http\Livewire;

use App\Models\CommentLikes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LikeComment extends Component
{
  public $comment;
  public $likes;

  public function mount($comment)
  {
    $this->comment = $comment;
    $this->likes = $this->refreshLikes();
  }

  private function refreshLikes()
  {
    return count(CommentLikes::all()->where('comment_id', '==', $this->comment->id));
  }

  public function render()
  {
    return view('livewire.like-comment');
  }

  public function updateLikes($id)
  {
    $user = auth()->user();
    $userLike = CommentLikes::all()->where('user_id', '==', $user->id)
      ->where('comment_id', '==', $id)->first();
    if ($userLike == null) {
      $idToUse = CommentLikes::all()->last()->id + 1;
      if (CommentLikes::all()->firstWhere('id', '==', $idToUse) == null) {
        // Insert with first available ID
        DB::table('comment_likes')->insert([
          'id' => CommentLikes::all()->last()->id + 1,
          'user_id' => $user->id,
          'comment_id' => $id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      } else {
        // Insert with whatever ID
        DB::table('comment_likes')->insert([
          'user_id' => $user->id,
          'comment_id' => $id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }
    } else {
      $userLike->delete();
    }

    $this->likes = $this->refreshLikes();
  }
}
