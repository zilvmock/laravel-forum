<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLikes;
use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentLikes;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
  // Return posts views
  // **********************
  public function showBrowseView()
  {
    $comments = Comment::all();
    $articles = Article::all();
    $categories = Category::all();
    $groups = Group::all();

    // Grouping
    $groupNames = $groups->unique('group_name');
    $groupIds = $categories->unique('group_id');
    $empty = collect();
    foreach ($groupIds as $id) {
      $empty->push($id['group_id']);
    }

    return view('forum/browse', [
      'articles' => $articles,
      'comments' => $comments,
      'categories' => $categories,
      'groupNames' => $groupNames,
      'empty' => $empty
    ]);
  }

  public function showCategoryView(Category $category)
  {
    $articles = Article::all()->where('category_id', '==', $category->id);
    $comments = Comment::all();

    return view('forum.browse-category', [
      'category' => $category,
      'articles' => $articles,
      'comments' => $comments,
    ]);
  }

  public function showArticleView(Request $request)
  {
    $articleId = $request->id;
    $article = Article::all()->firstWhere('id', '==', $articleId);
    $articleLikes = count(ArticleLikes::all()->where('article_id', '==', $articleId));
    $authorData = [
      'avatar' => $article->user->avatar,
      'username' => $article->user->username,
      'role' => $this->getRole($article->user),
      'rep' => $this->getReputation($article->user),
      'posts' => $this->getNumOfPosts($article->user),
      'likes' => $articleLikes,
    ];
    $articleComments = Comment::all()->where('article_id', '==', $articleId);
    if (count($articleComments) == 0) {
      $commentData = emptyArray();
    } else {
      $articleComments = $articleComments->sortBy('created_at');
      $commentData = array();
      foreach ($articleComments as $comment) {
        $commentData[] = [
          'comment' => [
            'avatar' => $comment->user->avatar,
            'username' => $comment->user->username,
            'role' => $this->getRole($comment->user),
            'rep' => $this->getReputation($comment->user),
            'posts' => $this->getNumOfPosts($comment->user),
            'comment' => $comment,
            'content' => $comment->content,
            'likes' => count(CommentLikes::all()->where('comment_id', '==', $comment->id))
          ]
        ];
      }
    }

    return view('forum.view_article', [
      'article' => $article,
      'authorData' => $authorData,
      'commentsData' => $commentData,
    ]);
  }

  private function getRole(User $user)
  {
    if ($user->role == 0) {
      $role = 'Member';
    } elseif ($user->role == 1) {
      $role = 'Admin';
    } elseif ($user->role == 2) {
      $role = 'Super Admin';
    }
    return $role;
  }

  private function getReputation(User $user)
  {
    $allUserArticles = Article::all()->where('user_id', '==', $user->id);
    $allUserComments = Comment::all()->where('user_id', '==', $user->id);
    $rep = 0;
    foreach ($allUserArticles as $userArticle) {
      $rep += count(ArticleLikes::all()->where('article_id', '==', $userArticle->id));
    }
    foreach ($allUserComments as $userComment) {
      $rep += count(CommentLikes::all()->where('comment_id', '==', $userComment->id));
    }

    return $rep;
  }

  private function getNumOfPosts(User $user)
  {
    $allUserArticlesCount = count(Article::all()->where('user_id', '==', $user->id));
    $allUserCommentsCount = count(Comment::all()->where('user_id', '==', $user->id));
    return ($allUserArticlesCount + $allUserCommentsCount);
  }
  // **********************
}
