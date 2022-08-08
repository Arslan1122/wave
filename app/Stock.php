<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['ticker', 'idcp', 'url','name'];

    public function values()
    {
        return $this->hasMany(StockValue::class);
    }
}
