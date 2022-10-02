<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = ['title', 'description'];

  public function group()
  {
    return $this->belongsTo(Group::class);
  }

  public function article()
  {
    return $this->hasMany(Article::class);
  }

  public function getRouteKeyName()
  {
    return 'title';
  }
}
