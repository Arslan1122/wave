<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAttribute extends Model
{
    use HasFactory;

    protected $fillable  = ['name', 'performance_month'];
}
