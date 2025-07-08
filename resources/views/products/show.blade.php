<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name ?? 'Product Not Found' }} - Product Details</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; display: flex; flex-wrap: wrap; gap: 30px; }
        h1, h2 { color: #333; }
        .product-image { flex: 1; min-width: 300px; max-width: 400px; }
        .product-image img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .product-details { flex: 2; min-width: 400px; }
        .product-details p { margin-bottom: 10px; }
        .price { font-size: 2em; color: #e44d26; font-weight: bold; margin-bottom: 20px; }
        .category-link { display: block; margin-top: 15px; color: #007bff; text-decoration: none; }
        .back-button { display: inline-block; margin-top: 30px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .back-button:hover { background-color: #0056b3; }
        .cart-link-top { text-align: right; margin-bottom: 20px; }
        .cart-link-top a { text-decoration: none; padding: 10px 15px; background-color: #6c757d; color: white; border-radius: 5px; }
        .cart-link-top a:hover { background-color: #5a6268; }
        .success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="cart-link-top">
        <a href="{{ route('cart.view') }}">View Cart</a>
    </div>
    <div class="container">
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

        <div class="product-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image">
            @endif
        </div>
        <div class="product-details">
            <h1>{{ $product->name }}</h1>
            <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
            <p>{{ $product->description }}</p>
            <div class="price">${{ number_format($product->price, 2) }}</div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 8px; margin-right: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button>
            </form>

        </div>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('products.index') }}" class="back-button">← Back to Products</a>
    </div>
</body>
</html>