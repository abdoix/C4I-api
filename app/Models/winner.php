<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class winner extends Model
{
    use HasFactory;
    protected $table = "winners";

    protected $fillable = [
        'id',
        'Date_Win',
        'user_id',
        'sponsor_id',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sponsor(){
        return $this->hasOne(sponsor::class);
    }


}
