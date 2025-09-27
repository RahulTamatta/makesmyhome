<?php

namespace Modules\SubscriptionModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ServiceManagement\Entities\Service;


class Pin extends Model
{
    use HasFactory;

    protected $fillable = ['pin','user_id','subscription_id','status'];


}
