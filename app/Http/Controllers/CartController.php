<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     */
    public function view()
    {
        $cartItems = Session::get('cart', []);
        $cart = [];
        $total = 0;

        foreach ($cartItems as $productId => $details) {
            $product = Product::find($productId);

            if ($product) {
                $itemTotal = $product->price * $details['quantity'];
                $total += $itemTotal;
                $cart[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'total_price' => $itemTotal,
                ];
            } else {
                // Optionally remove item if product no longer exists
                Session::forget('cart.'.$productId);
            }
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', $product->name.' added to cart!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            return $this->remove($product);
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            Session::put('cart', $cart);
            return redirect()->route('cart.view')->with('success', $product->name.' quantity updated.');
        }

        return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
            return redirect()->route('cart.view')->with('success', $product->name.' removed from cart.');
        }
        return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.view')->with('success', 'Cart cleared successfully.');
    }
}