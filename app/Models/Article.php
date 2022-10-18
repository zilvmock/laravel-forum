<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
  use HasFactory, Sluggable;

  protected $fillable = ['title', 'slug', 'content', 'tags', 'content_updated_at', 'user_id', 'category_id'];

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
    return $this->hasMany(Comment::class, 'article_id', 'id');
  }

//  public function getRouteKeyName()
//  {
//    return 'title';
//  }

  public function isLiked($id): bool
  {
    if (ArticleLikes::all()->where('user_id', '==', auth()->user()->id)
      ->where('article_id', '==', $id)->first()) {
      return true;
    } else {
      return false;
    }
  }

  public function getLikes($id): int
  {
    return count(ArticleLikes::all()->where('article_id', '==', $id));
  }

  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }
}
