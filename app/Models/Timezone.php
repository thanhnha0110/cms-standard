<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = 'timezones';
    protected $fillable = [
        'zone',
        'gmt',
        'name',
    ];
}