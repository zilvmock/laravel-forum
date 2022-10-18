<?php

namespace App\Http\Livewire;

use App\Models\ArticleLikes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LikeArticle extends Component
{
  public $article;
  public $likes;

  public function mount($article)
  {
    $this->article = $article;
    $this->likes = $this->refreshLikes();
  }

  private function refreshLikes()
  {
    return count(ArticleLikes::all()->where('article_id', '==', $this->article->id));
  }

  public function render()
  {
    return view('livewire.like-article');
  }

  public function updateLikes($id)
  {
    $user = auth()->user();
    $userLike = ArticleLikes::all()->where('user_id', '==', $user->id)
      ->where('article_id', '==', $id)->first();
    if ($userLike == null) {
      // Insert with first available ID
      ArticleLikes::insert([
        'user_id' => $user->id,
        'article_id' => $id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);
    } else {
      $userLike->delete();
    }
    $this->likes = $this->refreshLikes();
  }
}
