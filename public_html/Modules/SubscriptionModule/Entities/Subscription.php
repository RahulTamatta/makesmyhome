<?php

namespace Modules\SubscriptionModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ServiceManagement\Entities\Service;


class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price','image', 'status', 'duration', 'start_date', 'end_date'];

    protected static function newFactory()
    {
        return \Modules\SubscriptionModule\Database\factories\SubscriptionFactory::new();
    }
    public function services()
{
    return $this->belongsToMany(Service::class);
}
}
