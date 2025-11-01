<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvartUrl extends Model
{
    protected $table = 'advarts_url';

    protected $fillable = [
        'title',
        'image_url',
        'target_url',
        'active',
    ];
}
