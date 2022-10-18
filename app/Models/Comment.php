<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $fillable = ['content', 'article_id', 'user_id', 'content_updated_at'];

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

  public function getLikes($id): int
  {
    return count(CommentLikes::all()->where('comment_id', '==', $id));
  }
}
