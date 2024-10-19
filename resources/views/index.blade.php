<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product List</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
      padding: 40px;
    }

    .table-container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .table-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #343a40;
    }

    .product-image {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
    }

    .btn-edit {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
    }

    .btn-edit:hover {
      background-color: #0056b3;
    }

    .btn-delete {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
    }

    .btn-delete:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          @if(auth()->check())
            <li class="nav-item">
              <a href="{{ route('homepage') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('purchases') }}" class="nav-link">Purchases</a>
            </li>
            @if(auth()->user()->role === 'admin')
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">Admin Dashboard</a>
              </li>
            @endif
            <li class="nav-item">
              <a href="{{ route('account') }}" class="nav-link">Account</a>
            </li>
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link" style="color:#333; font-weight: 600;">Logout</button>
              </form>
            </li>
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
    </div>
  </nav>

  <div class="container">
    <div class="table-container">
      <h2>Product List</h2>

      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

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
              <!-- Button to toggle description -->
              <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#description-{{ $product->id }}">
                Show Description
              </button>
              <!-- Collapsible description section -->
              <div class="collapse mt-2" id="description-{{ $product->id }}">
                {{ $product->description }}
              </div>
            </td>
            <td>
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit</a>
              <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
