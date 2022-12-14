<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\Stock;
use App\Models\User;
use App\Models\Maker;
use App\Models\ItemReview;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'maker_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    // protected $with = ['reviews'];

    // protected $appends = ['avg_rating'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }

    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2', 'id');
    }

    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3', 'id');
    }

    public function imageFourth()
    {
        return $this->belongsTo(Image::class, 'image4', 'id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function reviews()
    {
        return $this->hasMany(ItemReview::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
            ->withPivot(['id', 'quantity']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')
            ->withPivot(['id', 'quantity']);
    }

    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }

    public function scopeAvailableItems($query)
    {
        $stocks = DB::table('t_stocks')
            ->select('product_id', DB::raw('sum(quantity) as quantity'))
            ->groupBy('product_id')
            ->having('quantity', '>', 1);

        $avgScores = DB::table('item_reviews')
            ->select('product_id', DB::raw('round(avg(score), 1) as avg_score'))
            ->groupBy(('product_id'));

        return $query->joinSub($stocks, 'stock', function ($join) {
            $join->on('products.id', '=', 'stock.product_id');
        })
            ->joinSub($avgScores, 'avg_score', function ($join) {
                $join->on('products.id', '=', 'avg_score.product_id');
            })
            ->join('shops', 'products.shop_id', '=', 'shops.id')
            ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
            ->join('images as image1', 'products.image1', '=', 'image1.id')
            ->join('makers', 'products.maker_id', '=', 'makers.id')
            ->where('shops.is_selling', true)
            ->where('products.is_selling', true)
            ->select('products.id as id', 'products.name as name', 'products.price', 'products.sort_order as sort_order', 'products.information', 'secondary_categories.name as category', 'image1.filename as filename', 'avg_score.avg_score as avg_score', 'makers.name as maker');
    }

    public function scopeSortOrder($query, $sortOrder)
    {
        if ($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['recommend']) {
            return $query->orderBy('sort_order', 'asc');
        }

        if ($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['higherPrice']) {
            return $query->orderBy('price', 'desc');
        }
        if ($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['lowerPrice']) {
            return $query->orderBy('price', 'asc');
        }
        if ($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['later']) {
            return $query->orderBy('products.created_at', 'desc');
        }
        if ($sortOrder === null || $sortOrder === \Constant::SORT_ORDER['older']) {
            return $query->orderBy('products.created_at', 'asc');
        }
    }

    public function scopeSelectCategory($query, $categoryId)
    {
        if ($categoryId !== '0') {
            return $query->where('secondary_category_id', $categoryId);
        } else {
            return;
        }
    }

    public function scopeSearchKeyword($query, $keyword)
    {
        if (!is_null($keyword)) {
            // ??????????????????????????????
            $spaceConvert = mb_convert_kana($keyword, 's');
            // ??????????????????????????????????????????
            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($keywords as $word) {
                $query->where('products.name', 'like', '%' . $word . '%');
            }
        } else {
            return;
        }
    }
}
