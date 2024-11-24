<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Bootstrap CSS and Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: 20px;
            background-color: skyblue;
        }

        .navbar {
            padding: 20px;
            background-color: skyblue;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .btn {
            background-color: #6fa9ff;
            color: #000;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #6fa9ff;
            color: #000;
            font-weight: bold;
            float: right;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <img src="/storage/images/man.jpg" alt="logo" class="rounded-circle me-3" style="width: 50px;">
            <a href="{{ route('homepage') }}" class="btn mx-3">Home</a>
            <a href="{{ route('purchases') }}" class="btn mx-3">Purchases</a>
            <a href="{{ route('account') }}" class="btn mx-3">Account</a>
            <a href="{{route('toppage')}}" class="btn mx-3">Product List</a>
            @if(auth()->check() && auth()->user()->role === 'admin') 
                <a href="{{route('dashboard')}}" class="btn mx-3">Admin Dashboard</a>
            @endif
            @if(Auth::check())
                <span class="navbar-text">Welcome, {{ auth()->user()->name }}</span>
            @endif
            <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn logout-btn">Logout</button>
      </form>
        </div>
    </nav>

    <!-- Shopping Cart -->
    <div class="container padding-bottom-3x mb-1">
        <h2 class="text-center">My Purchases</h2>

        <!-- Shopping Cart Table -->
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($purchases as $purchase)
<tr>
    <td>
        <div class="product-item d-flex align-items-center">
            @if($purchase->product)
                <a class="product-thumb" href="#">
                    <img src="{{ Storage::url($purchase->product->image) }}" alt="Product" style="width: 50px; height: 50px;">
                </a>
                <div class="product-info ml-3">
                    <h4 class="product-title">
                        <a href="#">{{ $purchase->product->productname }}</a>
                    </h4>
                </div>
            @else
                <span>Product not found</span>
            @endif
        </div>
    </td>
    <td class="text-center">{{ $purchase->quantity }}</td>
    <td class="text-center">
        @if($purchase->product)
            ${{ number_format($purchase->product->price, 2) }}
        @else
            N/A
        @endif
    </td>
    <td class="text-center">
        @if($purchase->product)
            ${{ number_format($purchase->quantity * $purchase->product->price, 2) }}
        @else
            N/A
        @endif
    </td>
    <td class="text-center">
        <a class="remove-from-cart" href="#" data-toggle="tooltip" title="Remove item">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No purchases found.</td>
</tr>
@endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
