<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
    public function coffeeMachine()
    {
        return $this->belongsTo('App\Models\CoffeeMachine');
    }
    public function coffee()
    {
        return $this->belongsTo('App\Models\Coffee');
    }

    public function scopeRanking($query)
    {
        return $query
            ->selectRaw('c.name as coffee, SUM(orders.rating)/COUNT(orders.rating) as ratingAverage')
            ->join('coffees as c', 'c.id', '=', 'orders.coffee_id')
            ->where('orders.rating', '>', 0)
            ->groupBy('orders.coffee_id')
            ->orderBy('ratingAverage', 'DESC');
    }
}
