<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image_path',
        'status',
        'category',
    ];

    public function feedbacks(): HasMany {
        return $this->hasMany(Feedback::class);
    }

    // public function orders(): HasMany {
    //     return $this->hasMany(Order::class);
    // }
}