<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productName',
        'description',
        'cost',
        'saleValue',
        'inStock',
        'markup'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'productId');
    }
}
