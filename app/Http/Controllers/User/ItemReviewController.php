<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ItemReview;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // QueryBuilder
use Illuminate\Support\Facades\Log;
use Throwable;


class ItemReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:users');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findOrFail(Auth::id());
        // itemの情報を取得する
        $item = Product::findOrFail($id);

        // itemのレビューを取得する
        $reviews = ItemReview::where('item_id', $item->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $rating = round(DB::table('item_reviews')
            ->where('item_id', $item->id)
            ->avg('rating'), 1);

        // dd($rating);

        return view('user.items.reviews.index', compact('user', 'item', 'reviews', 'rating'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::findOrFail(Auth::id());
        $item = Product::findOrFail($id);

        $rating = round(DB::table('item_reviews')
            ->where('item_id', $item->id)
            ->avg('rating'), 1);

        return view('user.items.reviews.create', compact('user', 'item', 'rating'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // dd($request);
        try {
            DB::transaction(function () use ($request, $id) {
                ItemReview::create([
                    'item_id' => $id,
                    'user_id' => Auth::id(),
                    'rating' => $request->score,
                    'comment' => $request->comment,
                ]);
            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('user.items.reviews.index', ['item' => $id])
            ->with([
                'message' => 'レビューを登録しました',
                'status' => 'info'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($item_id, $review_id)
    {
        $item = Product::findOrFail($item_id);
        $review = ItemReview::findOrFail($review_id);

        $rating = round(DB::table('item_reviews')
            ->where('item_id', $item->id)
            ->avg('rating'), 1);

        return view('user.items.reviews.edit', compact(
            'item',
            'review',
            'rating'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item_id, $review_id)
    {
        $review = ItemReview::findOrFail($review_id);

        try {
            DB::transaction(function () use ($request, $review) {
                $review->rating = $request->rating;
                $review->comment = $request->comment;
                $review->save();
            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('user.items.reviews.index', ['item' => $item_id])
            ->with([
                'message' => 'レビュー情報を更新しました',
                'status' => 'info'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($item_id, $review_id)
    {
        ItemReview::findOrFail($review_id)->delete();

        return redirect()
            ->route('user.items.reviews.index', ['item' => $item_id])
            ->with([
                'message' => 'レビューを削除しました',
                'status' => 'alert'
            ]);
    }
}
