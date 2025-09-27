<?php

namespace Modules\SubscriptionModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionService extends Model
{
    use HasFactory;
protected $fillable = ['subscription_id', 'service_id'];
    
    protected static function newFactory()
    {
        return \Modules\SubscriptionModule\Database\factories\SubscriptionServiceFactory::new();
    }
}
