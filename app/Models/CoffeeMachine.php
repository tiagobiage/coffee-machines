<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoffeeMachine extends Model
{
    use SoftDeletes;
    public function scopeCoffees($query)
    {
        return $query
            ->join('coffee_machines_coffees as cmc', 'coffee_machines.id', '=', 'cmc.coffee_machine_id')
            ->join('coffees as c', 'c.id', '=', 'cmc.coffee_id')
            ->whereNull('cmc.deleted_at');
    }
}
