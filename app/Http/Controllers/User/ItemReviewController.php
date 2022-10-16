<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ItemReview;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // QueryBuilder
use Illuminate\Support\Facades\Log;
use Throwable;


class ItemReviewController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:users')->except('index');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $qualifiedReviewer = false;
        $item = Product::findOrFail($id);

        if (Auth::id()) {
            $user = User::find(Auth::id());
            $qualifiedReviewer = $this->isQualifiedReviewer($user, $item);
        }

        $reviews = ItemReview::where('product_id', $item->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $avgScore = round(DB::table('item_reviews')
            ->where('product_id', $item->id)
            ->avg('score'), 1);

        return view('user.items.reviews.index', compact('item', 'qualifiedReviewer', 'reviews', 'avgScore'));
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
        if (!$this->isQualifiedReviewer($user, $item)) {
            abort(404);
        }
        // dd($qualifiedReviewers);
        // if ($this->isUnqualifiedReviewer($user, $item)) {
        //     abort(404);
        // }

        $avgScore = round(DB::table('item_reviews')
            ->where('product_id', $item->id)
            ->avg('score'), 1);

        return view('user.items.reviews.create', compact('user', 'item', 'avgScore'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        try {
            DB::transaction(function () use ($request, $id) {
                ItemReview::create([
                    'product_id' => $id,
                    'user_id' => Auth::id(),
                    'score' => round($request->score, 1),
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


    public function edit($item_id, $review_id)
    {
        $user = User::findOrFail(Auth::id());
        $item = Product::findOrFail($item_id);

        if ($this->QualifiedReviewer($user, $item)) {
            abort(404);
        }

        $review = ItemReview::findOrFail($review_id);

        $avgScore = round(DB::table('item_reviews')
            ->where('product_id', $item->id)
            ->avg('score'), 1);

        return view('user.items.reviews.edit', compact(
            'item',
            'review',
            'avgScore'
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
                $review->score = $request->score;
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

    private function isQualifiedReviewer($user, $item)
    {
        $qualifiedReviewers = $item->orders()->pluck('user_id')->toArray();
        return in_array($user->id, $qualifiedReviewers);
    }
}
