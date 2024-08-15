<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'clientId',
        'productId',
        'totalValue',
        'quantity'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

}
