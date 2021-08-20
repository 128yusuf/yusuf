<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public static function getOrderNumber() {
        return Carbon::now()->format("Y").sprintf("%03d",Order::max('id') ?? 1);
    }
}
