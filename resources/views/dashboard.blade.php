<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f6f9;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #343a40;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      color: white;
      padding: 20px 0;
    }

    .sidebar a {
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      display: block;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    /* Dashboard header */
    .dashboard-header {
      background-color: #007bff;
      color: white;
      padding: 10px;
      margin-left: 250px;
      font-size: 24px;
      font-weight: bold;
    }

    /* Dashboard cards */
    .card {
      margin: 30px 10px;
      width: 16rem; /* Slightly smaller width for better fit */
      height: 16rem; /* Adjusted height */
    }

    .card .fas {
      font-size: 48px;
      margin-bottom: 10px;
    }

    .dashboard-stats {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around; /* Allow better spacing */
    }

    .chart-container {
      width: 100%;
      margin-top: 40px;
    }

    /* Container for the main content */
    .container-fluid {
      margin-left: 270px; /* Add left margin to make space for sidebar */
    }

    .filter-section {
      margin: 20px 0;
    }

    /* Make the graph more proportionate */
    canvas {
      max-height: 400px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="admin-info text-center mb-4">
        @if($admins->count() > 0)
            @foreach($admins as $admin)
                <div class="mb-2">
                    <form action="{{ route('admin.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img src="{{ $admin->profile_picture ? asset('storage/' . $admin->profile_picture) : 'https://via.placeholder.com/80' }}" 
                             class="rounded-circle" alt="Admin Profile" style="width:80px; height:80px;">
                        <h4 class="mt-2">{{ $admin->name }}</h4>
                        <input type="file" name="profile_picture" class="form-control mt-2">
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
                    </form>
                </div>
            @endforeach
        @else
            <img src="https://via.placeholder.com/80" class="rounded-circle" alt="Admin Profile">
            <h4 class="mt-2">No Admin Found</h4>
        @endif
    </div>
    <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="{{ route('admin.users') }}"><i class="fas fa-users"></i> Users</a>
    <a href="{{ route('index') }}"><i class="fas fa-boxes"></i> Products</a>
    <a href="{{ route('homepage') }}"><i class="fas fa-home"></i> Home</a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf 
            <button type="submit" class="btn btn-link nav-link" style="color:#333; font-weight: 600;">Logout</button>
          </form>
</div>

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    Admin Dashboard
  </div>

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="dashboard-stats">
      <!-- Dashboard cards -->
      <div class="card text-white bg-primary mb-3">
        <div class="card-header"><i class="fas fa-user"></i> Registered Users</div>
        <div class="card-body">
          <h5 class="card-title">{{ $totalUsers }}</h5>
          <p class="card-text">Total number of registered users.</p>
        </div>
      </div>

      <div class="card text-white bg-success mb-3">
        <div class="card-header"><i class="fas fa-box"></i> Registered Products</div>
        <div class="card-body">
          <h5 class="card-title">{{ $totalProducts }}</h5>
          <p class="card-text">Total number of products available.</p>
        </div>
      </div>

      <div class="card text-white bg-warning mb-3">
        <div class="card-header"><i class="fas fa-shopping-cart"></i> Most Purchased Product</div>
        <div class="card-body">
          @if($mostPurchasedProduct)
            <h5 class="card-title">{{ $mostPurchasedProduct->productname }}</h5>
            <p class="card-text">Purchased {{ $mostPurchasedProduct->total_quantity }} times.</p>
          @else
            <h5 class="card-title">No purchases yet</h5>
          @endif
        </div>
      </div>
    </div>

    <!-- Filter and Graph Section -->
    <div class="filter-section">
      <label for="filter">Filter by Month:</label>
      <select id="filter" class="form-control" style="width: 200px;">
        <option value="all">All</option>
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
      </select>
    </div>

    <!-- Sales Graph Section -->
    <div class="chart-container">
      <h4>Sales Overview</h4>
      <canvas id="salesChart"></canvas> <!-- Bar chart placeholder -->
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js for the bar chart -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Sample Chart.js Data -->
  <script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesData = @json($salesData); // Laravel sales data passed to JavaScript

    var salesChart = new Chart(ctx, {
      type: 'bar', // Change type to 'bar'
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Example months
        datasets: [{
          label: 'Sales',
          data: salesData, // Sales data from backend
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)', 
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)', 
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Filtering logic (optional - you can add dynamic filtering for your data)
    document.getElementById('filter').addEventListener('change', function() {
      var selectedMonth = this.value;
      if (selectedMonth !== 'all') {
        // Modify salesData based on filter (replace this with your logic for dynamic data)
        alert('Filter applied: ' + selectedMonth);
      } else {
        // Reset to default data
        alert('Showing all months');
      }
    });
  </script>
</body>
</html>
