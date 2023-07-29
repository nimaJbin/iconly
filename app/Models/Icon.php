<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [
        'title',
        'url',
        'file_name',
        'status',
    ];
}
