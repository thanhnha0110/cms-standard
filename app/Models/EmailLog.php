<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'email_logs';
    protected $fillable = [
        'user_id',
        'template_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}