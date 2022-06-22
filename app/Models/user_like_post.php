<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_like_post extends Model
{
    use HasFactory;
    protected $table = "users_like_posts";
    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'created_at',
        'updated_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }


}
