<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class GuestCartController extends Controller
{
    public function index(Request $request)
    {
        $itemsInCart = $request->session()->get('itemsInCart');
        $products = [];
        $totalPrice = 0;
        if ($itemsInCart) {
            $productsInCart = Product::whereIn('id', array_column($itemsInCart, 'product_id'))->get();

            $products = array_map(function ($itemInCart) use ($productsInCart) {
                $result = array_search((int) $itemInCart['product_id'], array_column($productsInCart->toArray(), 'id'));
                $itemInCart['quantity'] = (int) $itemInCart['quantity'];
                $itemInCart['name'] = $productsInCart[$result]->name;
                $itemInCart['price'] = $productsInCart[$result]->price;
                $itemInCart['filename'] = $productsInCart[$result]->imageFirst->filename;
                return $itemInCart;
            }, $itemsInCart);

            foreach ($products as $product) {
                $totalPrice += $product['quantity'] * $product['price'];
            }
        }
        return view('user.cart', compact('products', 'totalPrice'));
    }


    public function add(Request $request)
    {
        $newItems = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ];

        $itemsInCart = [$newItems];

        if ($request->session()->has('itemsInCart')) {
            $itemsInCart = $request->session()->get('itemsInCart');
            $result = array_search($newItems['product_id'], array_column($itemsInCart, 'product_id'));
            if ($result !== false) {
                $itemsInCart[$result]['quantity'] += $newItems['quantity'];
            } else {
                array_push($itemsInCart, $newItems);
            }
        }
        $request->session()->put('itemsInCart', $itemsInCart);


        return redirect()->route('user.guest.cart.index', compact('request'));
    }

    public function delete(Request $request, $id)
    {
        $itemsInCart = $request->session()->get('itemsInCart');

        $result = array_search($id, array_column($itemsInCart, 'product_id'));
        unset($itemsInCart[$result]);
        $request->session()->put('itemsInCart', $itemsInCart);

        return redirect()->route('user.guest.cart.index', compact('request'));
    }

    public function checkout(Request $request)
    {
        $itemsInCart = $request->session()->get('itemsInCart');
        $userId = Auth::id();
        foreach ($itemsInCart as $item) {
            $itemInCart = Cart::where('product_id', $item['product_id'])
                ->where('user_id', $userId)->first();
            if ($itemInCart) {
                $itemInCart->quantity += $item['quantity'];
                $itemInCart->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity']
                ]);
            }
        }
        // $itemInCart = Cart::where('product_id', $request->product_id)
        //     ->where('user_id', Auth::id())->first();


        return redirect()->route('user.cart.index');
    }
}
