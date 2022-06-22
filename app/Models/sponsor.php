<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sponsor extends Model
{
    use HasFactory;
    protected $table = "sponsors";

    protected $fillable = [
        'id',
        'Brand',
        'Start_Date',
        'Finish_Date',
        'created_at',
        'updated_at',
    ];
}
