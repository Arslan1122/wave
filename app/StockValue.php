<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockValue extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'stock_attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(StockAttribute::class, 'stock_attribute_id');
    }
}
