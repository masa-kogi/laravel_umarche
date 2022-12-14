<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Stock;
use App\Models\ItemReview;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('item');
            if (!is_null($id)) {
                $itemId = Product::availableItems()->where('products.id', $id)->exists();
                if (!$itemId) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // dd($request);
        // Mail::to('test@example.com')
        //     ->send(new TestMail());

        // SendThanksMail::dispatch();

        $categories = PrimaryCategory::with("secondary")->get();

        $products = Product::availableItems()
            // ->getAverageRatingAttribute()
            ->selectCategory($request->category ?? '0')
            ->searchKeyword($request->keyword)
            ->sortOrder($request->sort)->paginate($request->pagination ?? '20');

        // dd($products);
        return view('user.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');
        $avgScore = round(DB::table('item_reviews')
            ->where('product_id', $product->id)
            ->avg('score'), 1);

        if ($quantity > 9) {
            $quantity = 9;
        }

        $reviews = ItemReview::where('product_id', $product->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $reviewCounts = ItemReview::where('product_id', $product->id)->count();

        return view('user.show', compact('product', 'quantity', 'avgScore', 'reviews', 'reviewCounts'));
    }
}
