<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <style>
    body { font-family: sans-serif; margin: 20px; }

    /* New/Updated: Header bar for logo and cart link - Simple Styling */
    .header-bar {
        background-color: #f8f9fa; /* Light background for the header */
        padding: 10px 0; /* Simple padding */
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px; /* Space below header */
    }
    .header-bar .shop-name { /* Text next to logo */
        font-weight: bold;
        font-size: 1.2em;
        color: #3498DB; /* Logo Blue */
        display: flex; /* To align logo image and text */
        align-items: center;
    }
    .header-bar .shop-name img { /* Logo image itself */
        height: 30px; /* Small logo size */
        width: auto; /* Maintain aspect ratio */
        margin-right: 10px;
    }
    .header-bar .cart-link-top { /* Cart link in header */
        text-decoration: none;
        padding: 8px 15px;
        background-color: #E74C3C; /* Logo Red background for cart link */
        color: white;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease; /* Simple transition */
    }
    .header-bar .cart-link:hover {
        background-color: #c0392b; /* Darker red on hover */
    }

    .container { max-width: 1200px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }

    /* Updated: Main heading color */
    h1 { text-align: center; color: #3498DB; /* Logo Blue for main heading */ margin-bottom: 20px; }

    .categories-list, .products-grid { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; }
    .category-item, .product-item { border: 1px solid #eee; padding: 15px; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
    .category-item { background-color: #f9f9f9; }

    .product-item { flex: 1 1 calc(33% - 40px); box-sizing: border-box; } /* Approx 3 per row */
    /* IMPORTANT: Consider reducing height here if 500px is too tall for your images */
    .product-item img { max-width: 100%; height: 500px; object-fit: cover; border-radius: 4px; margin-bottom: 10px; }

    /* Updated: Product name color */
    .product-item h3 { margin-top: 0; font-size: 1.2em; color: #E74C3C; /* Logo Red for product names */ }

    .product-item p { font-size: 0.9em; color: #666; }

    .product-item .price { font-weight: bold; color: #3498DB; /* Logo Blue for prices */ font-size: 1.1em; }

    
    .btn { /* General button style */
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        font-weight: bold;
        transition: background-color 0.3s ease; /* Simple transition */
    }
    .btn-primary { /* For "Add to Cart" button */
        background-color: #3498DB; /* Logo Blue */
        color: white;
    }
    .btn-primary:hover {
        background-color: #2980b9; /* Darker blue on hover */
    }

    /* Original Alert Message Styles (no changes here) */
    .success-message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    .error-message { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
</style>
</head>
<body>
    {{-- NEW LOGO SECTION AT THE TOP --}}
    <div style="padding: 10px 20px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
            <img src="{{ asset('images/logo.png') }}" alt="Shop Logo"
                 style="height: 60px; width: 160px; margin-right: 10px;">
        </a>
    </div>
    {{-- END NEW LOGO SECTION --}}

   

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

        <h1>Welcome to Horizon E-commerce Store!</h1>

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