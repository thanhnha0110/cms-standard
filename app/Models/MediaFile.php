<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $table = 'media_files';
    protected $fillable = [
        'name',
        'alt',
        'mine_type',
        'size',
        'url',
        'option',
    ];
}