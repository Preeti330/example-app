<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymenttransction extends Model
{
    use HasFactory;
    public $table='payment_transction';
    public $primarykey='id';

}
