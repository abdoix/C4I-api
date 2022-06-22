<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "post";
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'photo',
        'created_at',
        'updated_at',
        'location',
        'likesnumber',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }



}
