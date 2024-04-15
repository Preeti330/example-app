<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordershipping extends Model
{
    use HasFactory;
    public $table='order_shipping';
    public $primarykey='id';
}
