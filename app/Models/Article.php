<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
  use HasFactory, Sluggable;

  protected $fillable = ['title', 'slug', 'content', 'tags', 'content_updated_at', 'user_id', 'category_id'];

  protected $with = ['user', 'category'];

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

  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }
}
