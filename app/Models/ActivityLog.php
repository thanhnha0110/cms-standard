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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reference()
    {
        return $this->morphTo();
    }
    
    public function generateAction()
    {
        $nameReference = $this->getReferenceName();
        $createdAt = '<small>' . $this->created_at->diffForHumans() . '</small>';
        $causedBy = '<strong>' . $this->causedBy->getFullName() . '</strong>';
        return "{$causedBy} {$this->action} {$this->module} \"{$nameReference}\" . {$createdAt} ({$this->ip_address})";
    }

    private function getReferenceName(): string
    {
        $default = 'ID: ' . $this->reference_id;
        if (isset($this->reference)) {
            return $this->reference->name ?? $this->reference->getFullName() ?? $this->reference->title ?? $default;
        }
        return $default;
    } 
}