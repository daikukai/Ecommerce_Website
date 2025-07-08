<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        h1 { text-align: center; color: #333; }
        .categories-list, .products-grid { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
        .category-item, .product-item { border: 1px solid #eee; padding: 15px; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
        .category-item { background-color: #f9f9f9; }
        .product-item { flex: 1 1 calc(33% - 40px); box-sizing: border-box; } /* Approx 3 per row */
        .product-item img { max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px; }
        .product-item h3 { margin-top: 0; font-size: 1.2em; }
        .product-item p { font-size: 0.9em; color: #666; }
        .product-item .price { font-weight: bold; color: #e44d26; font-size: 1.1em; }
        .cart-link-top { text-align: right; margin-bottom: 20px; } /* New style for cart link */
        .cart-link-top a { text-decoration: none; padding: 10px 15px; background-color: #6c757d; color: white; border-radius: 5px; }
        .cart-link-top a:hover { background-color: #5a6268; }
        .success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    {{-- NEW: View Cart link at the top --}}
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

        <h1>Welcome to Our E-commerce Store!</h1>

        <h2>Categories</h2>
        <div class="categories-list">
            @forelse($categories as $category)
                <div class="category-item">
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                </div>
            @empty
                <p>No categories found.</p>
            @endforelse
        </div>

        <h2>Our Products</h2>
        <div class="products-grid">
            @forelse($products as $product)
                {{-- START OF CHANGE: Wrap the product-item div with an <a> tag --}}
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; flex: 1 1 calc(33% - 40px); box-sizing: border-box;">
                    <div class="product-item">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/150?text=No+Image" alt="No Image">
                        @endif
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                        <p>Category: {{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                </a>
                {{-- END OF CHANGE --}}
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
    </div>
</body>
</html>