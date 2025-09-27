<?php

namespace Modules\SubscriptionModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuySubscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subscription_id', 'amount', 'purchase_date', 'status', 'transaction_id', 'payment_method'];

    protected static function newFactory()
    {
        return \Modules\SubscriptionModule\Database\factories\BuySubscriptionFactory::new();
    }
}
