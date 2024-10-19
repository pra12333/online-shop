<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: grey /* Light blue background */
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Custom styles for table */
        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for alternating rows */
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fdfdfd; /* Slightly lighter color for odd rows */
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-align: center;
        }

    </style>
</head>
<body>
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

    <div class="container">
        <h2 class="mt-4">Registered Users</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-hover mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
