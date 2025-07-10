<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; background-color: #f4f4f4;}
        .container { max-width: 900px; margin: 30px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h1 { text-align: center; color: #333; margin-bottom: 25px; }
        .section-title { margin-top: 30px; margin-bottom: 15px; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #444; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        .form-group input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            margin-top: 20px;
        }
        .form-group input[type="submit"]:hover { background-color: #218838; }
        .order-summary { border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background-color: #fdfdfd; margin-top: 20px; }
        .order-summary h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .order-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee; }
        .order-item:last-child { border-bottom: none; }
        .order-total { font-size: 1.3em; font-weight: bold; text-align: right; padding-top: 15px; color: #e44d26; }
        .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .empty-cart-message { text-align: center; margin-top: 50px; font-size: 1.2em; color: #555; }
        .back-to-cart { display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .back-to-cart:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>

        @if(Session::has('error'))
            <div class="error-message">
                {{ Session::get('error') }}
            </div>
        @endif

        @if(count($cart) == 0)
            <p class="empty-cart-message">Your cart is empty. Please add items before checking out.</p>
            <div style="text-align: center;">
                <a href="{{ route('products.index') }}" class="back-to-cart">Continue Shopping</a>
            </div>
        @else
            <div class="order-summary">
                <h2>Order Summary</h2>
                @foreach($cart as $item)
                    <div class="order-item">
                        <span>{{ $item['product']->name }} (x{{ $item['quantity'] }})</span>
                        <span>${{ number_format($item['total_price'], 2) }}</span>
                    </div>
                @endforeach
                <div class="order-total">
                    Total: ${{ number_format($total, 2) }}
                </div>
            </div>

            <h2 class="section-title">Shipping Information</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="customer_name">Full Name:</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required>
                    @error('customer_name') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="customer_email">Email:</label>
                    <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required>
                    @error('customer_email') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_address">Address:</label>
                    <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                    @error('shipping_address') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_city">City:</label>
                    <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                    @error('shipping_city') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_state">State/Province (Optional):</label>
                    <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}">
                    @error('shipping_state') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_zip_code">Zip/Postal Code:</label>
                    <input type="text" id="shipping_zip_code" name="shipping_zip_code" value="{{ old('shipping_zip_code') }}" required>
                    @error('shipping_zip_code') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_country">Country:</label>
                    <input type="text" id="shipping_country" name="shipping_country" value="{{ old('shipping_country') }}" required>
                    @error('shipping_country') <span style="color: red; font-size: 0.9em;">{{ $message }}</span> @enderror
                </div>

                <h2 class="section-title">Payment Information (Placeholder)</h2>
                <p style="text-align: center; color: #888;">
                    *Payment gateway integration will go here in a later advanced phase.*<br>
                    For now, clicking "Place Order" will process the order.
                </p>

                <div class="form-group">
                    <input type="submit" value="Place Order">
                </div>
            </form>
        @endif
    </div>
</body>
</html>