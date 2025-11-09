<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisment extends Model
{
    // table name intentionally matches request
    protected $table = 'Advertisment';
    protected $primaryKey = 'id_advert';

    protected $fillable = [
        'link_url',
    ];
}
