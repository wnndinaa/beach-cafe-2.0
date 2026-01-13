<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'category', 'quantity', 'unit_price', 'unit', 'date'];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'date' => 'date',
    ];
}

