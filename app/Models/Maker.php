<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Maker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
