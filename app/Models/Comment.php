<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['content', 'up_votes', 'edited_at', 'article_id'];

  public function article()
  {
    return $this->belongsTo(Article::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function isLiked($id): bool
  {
    if (CommentLikes::all()->where('user_id', '==', auth()->user()->id)
      ->where('comment_id', '==', $id)->first()) {
      return true;
    } else {
      return false;
    }
  }
}
