<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;


class ItemReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'score',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Product::class);
    }
}
