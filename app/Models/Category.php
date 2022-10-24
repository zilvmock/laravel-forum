<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory, Sluggable;

  protected $fillable = ['title', 'slug', 'description', 'group_id'];

  protected $with = ['group'];

  public function group()
  {
    return $this->belongsTo(Group::class);
  }

  public function article()
  {
    return $this->hasMany(Article::class);
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
