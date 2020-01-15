<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoffeeMachineCoffee extends Model
{
    use SoftDeletes;
    protected $table = 'coffee_machines_coffees';
}
