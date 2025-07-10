<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // For authenticated user check
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; // Although not directly used for creation here, good to have

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function showCheckoutForm()
    {
        $cartItems = Session::get('cart', []);

        // Redirect if cart is empty
        if (empty($cartItems)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

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
                // Remove item from session if product no longer exists
                Session::forget('cart.'.$productId);
            }
        }

        // If user is logged in, pre-fill some fields
        $user = Auth::user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    /**
     * Process the checkout, create an order, and clear the cart.
     */
    public function processCheckout(Request $request)
    {
        $cartItems = Session::get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty. Cannot process an empty order.');
        }

        // 1. Validate the form data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_zip_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            // Add any other validation rules as needed (e.g., payment details)
        ]);

        $totalAmount = 0;
        $orderProducts = []; // To store products for order items

        foreach ($cartItems as $productId => $details) {
            $product = Product::find($productId);
            if ($product) {
                $itemPrice = $product->price;
                $itemQuantity = $details['quantity'];
                $totalAmount += ($itemPrice * $itemQuantity);
                $orderProducts[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name, // Store name in case product is deleted
                    'quantity' => $itemQuantity,
                    'price' => $itemPrice, // Price at the time of order
                ];
            } else {
                // If a product in cart no longer exists, remove it and notify
                Session::forget('cart.'.$productId);
                return redirect()->route('cart.view')->with('error', 'One or more products in your cart are no longer available. Please review your cart.');
            }
        }

        // 2. Create the Order
        $order = Order::create([
            'user_id' => Auth::id(), // Will be null if not logged in
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_zip_code' => $request->shipping_zip_code,
            'shipping_country' => $request->shipping_country,
            'total_amount' => $totalAmount,
            'status' => 'pending', // Initial status
        ]);

        // 3. Create Order Items
        foreach ($orderProducts as $itemData) {
            $order->items()->create($itemData); // Use the relationship to create order items
        }

        // 4. Clear the shopping cart from the session
        Session::forget('cart');

        // 5. Redirect to an order confirmation page (we'll create this later)
        // For now, redirect to products index with a success message
        return redirect()->route('products.index')->with('success', 'Your order (#' . $order->id . ') has been placed successfully!');
    }
}