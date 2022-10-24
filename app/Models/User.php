<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = ['first_name', 'last_name', 'avatar', 'username', 'password', 'email', 'bio', 'role'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'username_changed_at' => 'datetime',
  ];

  public function article()
  {
    return $this->hasMany(Article::class);
  }

  public function comment()
  {
    return $this->hasMany(Comment::class);
  }

  public function getRoleName(User $user): string
  {
    if ($user->role == 1) {
      $role = 'Admin';
    } else {
      $role = 'Member';
    }
    return $role;
  }

  public function scopeWhereUser($query, $userId)
  {
    return $query->where('user_id', '=', $userId);
  }
}
