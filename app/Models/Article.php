<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'content', 'tags', 'up_votes', 'edited_at', 'user_id'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function comment()
  {
    return $this->hasMany(Comment::class);
  }

  public function getRouteKeyName()
  {
    return 'title';
  }

  public function isLiked($id): bool
  {
    if (ArticleLikes::all()->where('user_id', '==', auth()->user()->id)
      ->where('article_id', '==', $id)->first()) {
      return true;
    } else {
      return false;
    }
  }
}
