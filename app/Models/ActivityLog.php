<?php

namespace App\Models;

use Botble\Ecommerce\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id',
        'module',
        'action',
        'user_agent',
        'ip_address',
        'reference_type',
        'reference_id',
    ];

    public function causedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }
}