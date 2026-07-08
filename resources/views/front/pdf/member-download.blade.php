<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $product->name }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            font-size: 12pt;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .product-info {
            margin-bottom: 30px;
        }
        .description {
            background: #f5f5f5;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .author-info {
            background: #e8f4f8;
            padding: 15px;
            border: 1px solid #cce8f3;
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
            font-size: 10pt;
            color: #666;
        }
        .product-image {
            text-align: center;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .product-image img {
            max-width: 250px;
            height: auto;
            border: 1px solid #ddd;
        }
        h1 {
            color: #333;
            font-size: 18pt;
            margin-bottom: 10px;
        }
        h2 {
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 14pt;
            margin-top: 20px;
        }
        p {
            margin-bottom: 10px;
            text-align: justify;
        }
        strong {
            font-weight: bold;
        }
        em {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $product->name }}</h1>
        <p><em>{{ ucfirst($product->product_type) }}</em></p>
    </div>

    <div class="product-info">
        <h2>Product Information</h2>
        <p><strong>Category:</strong> {{ ucfirst(str_replace('_', ' ', $product->category)) }}</p>
        <p><strong>Price:</strong> ${{ $product->price }}</p>
        @if ($product->originalPrice)
            <p><strong>Original Price:</strong> ${{ $product->originalPrice }}</p>
        @endif
        <p><strong>Rating:</strong> {{ $product->rating }} stars</p>
        <p><strong>Reviews:</strong> {{ $product->reviews }}</p>
    </div>

    @if ($imageSrc)
        <div class="product-image">
            <h2>Product Image</h2>
            <img src="{{ $imageSrc }}" alt="{{ $product->name }}" />
        </div>
    @endif

    <div class="description">
        <h2>Description</h2>
        <div>{!! str_replace("\n", '<br>', e($product->description)) !!}</div>
    </div>

    @if ($product->user)
        <div class="author-info">
            <h2>Author Information</h2>
            <p><strong>Author:</strong> {{ $product->user->first_name }} {{ $product->user->last_name }}</p>
        </div>
    @endif

    <div class="footer">
        <p><strong>Generated on:</strong> {{ $generatedAt }}</p>
        <p><strong>Downloaded by:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
        <p><em>This is a member-exclusive document from Institute for Living a Longer Life</em></p>
    </div>
</body>
</html>
