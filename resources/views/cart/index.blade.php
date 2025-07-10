<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        h1 { text-align: center; color: #333; }
        .cart-item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 15px 0; }
        .cart-item:last-child { border-bottom: none; }
        .item-image img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; margin-right: 20px; }
        .item-details { flex-grow: 1; }
        .item-details h3 { margin: 0 0 5px 0; font-size: 1.1em; }
        .item-details p { margin: 0; font-size: 0.9em; color: #666; }
        .item-quantity { display: flex; align-items: center; }
        .item-quantity input { width: 50px; text-align: center; margin: 0 10px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; }
        .item-quantity button { background-color: #007bff; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; }
        .item-quantity button:hover { background-color: #0056b3; }
        .item-price { font-weight: bold; margin-left: 20px; width: 100px; text-align: right; }
        .cart-summary { text-align: right; margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee; }
        .cart-summary h2 { font-size: 1.8em; color: #e44d26; }
        .cart-actions { text-align: center; margin-top: 20px; }
        .cart-actions a, .cart-actions button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }
        .cart-actions a:hover, .cart-actions button:hover { background-color: #218838; }
        .cart-actions .clear-cart-btn { background-color: #dc3545; }
        .cart-actions .clear-cart-btn:hover { background-color: #c82333; }
        .empty-cart-message { text-align: center; margin-top: 50px; font-size: 1.2em; color: #555; }
        .back-button { display: inline-block; margin-top: 30px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .back-button:hover { background-color: #0056b3; }
        .success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Shopping Cart</h1>

        @if(Session::has('success'))
            <div class="success-message">
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::has('error'))
            <div class="error-message">
                {{ Session::get('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            @foreach($cart as $item)
                <div class="cart-item">
                    <div class="item-image">
                        @if($item['product']->image_url)
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}">
                        @else
                            <img src="https://via.placeholder.com/80?text=No+Image" alt="No Image">
                        @endif
                    </div>
                    <div class="item-details">
                        <h3>{{ $item['product']->name }}</h3>
                        <p>Price: ${{ number_format($item['product']->price, 2) }}</p>
                        <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 0.8em;">Remove</button>
                        </form>
                    </div>
                    <div class="item-quantity">
                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </div>
                    <div class="item-price">
                        ${{ number_format($item['total_price'], 2) }}
                    </div>
                </div>
            @endforeach

            <div class="cart-summary">
                <h2>Total: ${{ number_format($total, 2) }}</h2>
            </div>

            <div class="cart-actions">
                <a href="{{ route('products.index') }}" class="back-button">Continue Shopping</a>
                <form action="{{ route('cart.clear') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="clear-cart-btn">Clear Cart</button>
                </form>
                <a href="{{ route('checkout.show') }}" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Proceed to Checkout</a></div>
        @else
            <p class="empty-cart-message">Your cart is empty.</p>
            <div class="cart-actions">
                <a href="{{ route('products.index') }}" class="back-button">Start Shopping</a>
            </div>
        @endif
    </div>
</body>
</html>