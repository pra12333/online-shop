<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Top Page Example</title>

  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: skyblue;
    }

    /* Navbar styles */
    .navbar {
      background-color: skyblue;
      padding: 20px;
    }

    .navbar-nav .nav-link {
      color: #333;
      margin-right: 20px;
      font-weight: 600;
    }

    .navbar-nav .nav-link:hover {
      color: #007bff;
    }

    /* Hero section */
    .hero-section {
      background-color: #4db3e8;
      color: white;
      text-align: center;
      padding: 80px 20px;
      position: relative;
    }

    .hero-section h1 {
      font-size: 48px;
      font-weight: bold;
    }

    .hero-section .cta-button {
      background-color: #ff7e29;
      color: white;
      padding: 15px 30px;
      font-size: 18px;
      border-radius: 30px;
      border: none;
      margin-top: 20px;
      transition: background-color 0.3s;
    }

    .hero-section .cta-button:hover {
      background-color: #ff9b59;
    }

    /* Icon section */
    .icon-section {
      display: flex;
      justify-content: space-around;
      padding: 50px 20px;
      background-color: skyblue;
    }

    .icon-box {
      text-align: center;
      padding: 20px;
    }

    .icon-box img {
      width: 400px;
      height: 200px;
      margin-bottom: 20px;
    }

    .icon-box h5 {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    /* Support button on the right */
    .support-btn {
      position: fixed;
      right: 20px;
      bottom: 50px;
      background-color: blue;
      color: white;
      padding: 10px 20px;
      border-radius: 30px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
    }

    .support-btn:hover {
      background-color: #007bff;
    }

    /* Product Image Style */
    .product-image {
      width: 100px;
      height: auto;
      object-fit: contain;
    }
  </style>
</head>
<body>

  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        @if(auth()->check())
          <a href="{{ route('homepage') }}" class="btn mx-1">Home</a>
          <a href="{{ route('purchases') }}" class="btn mx-1">Purchases</a>
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="btn mx-3">Admin Dashboard</a>
          @endif
          <a href="{{ route('account') }}" class="btn mx-1">Account</a>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf 
            <button type="submit" class="btn btn-link nav-link" style="color:#333; font-weight: 600;">Logout</button>
          </form>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Sign In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
          </li>
        @endif
      </ul>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section">
    <h1>Simple, All-in-One Accounting & Inventory Software</h1>
  </section>

  <!-- Product Table Section -->
  <section class="container mt-5">
    <h2 class="text-center">Product Table</h2>
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="table-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Available Stock</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{ $product->productname }}</td>
              <td>${{ number_format($product->price, 2) }}</td>
              <td>
                @if($product->image)
                  <img src="{{ Storage::url($product->image) }}" class="product-image" alt="{{ $product->productname }}">
                @else
                  No Image
                @endif
              </td>
              <td>{{ $product->available_stock }}</td>
              <td>
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#description-{{ $product->id }}">
                  Show Description
                </button>
                <div class="collapse" id="description-{{ $product->id }}">
                  <p class="mt-2">{{ $product->description }}</p>
                </div>
              </td>
              <td>
                @if(auth()->check())
                  <!-- Buy Button to open modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buyModal{{ $product->id }}">
                    Buy
                  </button>
                @else
                  <a href="{{ route('login') }}" class="btn btn-primary">Login to Buy</a>
                @endif
              </td>
            </tr>

            <!-- Modal for selecting quantity -->
            <div class="modal fade" id="buyModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Quantity for {{ $product->productname }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('products.buy', $product->id) }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $product->available_stock }}" value="1" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Confirm Purchase</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <!-- Icon Section -->
  <section class="icon-section">
    <div class="icon-box">
      <img src="/storage/images/1.jpg" alt="Inventory Management Icon">
      <h5>Inventory Management</h5>
    </div>
    <div class="icon-box">
      <img src="/storage/images/pay.jpg" alt="Point of Sale Icon">
      <h5>Point of Sale</h5>
    </div>
    <div class="icon-box">
      <img src="/storage/images/max.jpg" alt="Manufacturing Icon">
      <h5>Manufacturing</h5>
    </div>
  </section>

  <!-- Support Button -->
  <div class="support-btn">Support</div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
