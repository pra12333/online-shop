<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
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
        }

        .search-box {
            margin-top: 10px;
            text-align: right;
        }

        .search-box input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 200px;
        }

        .search-box button {
            padding: 10px 15px;
            background-color: #6fa9ff;
            color: white;
            border: none;
            border-radius: 4px;
            margin-left: 5px;
        }

        .main-section {
            padding: 30px;
            text-align: center;
        }

        .main-section h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .info-box {
            padding: 40px;
            border-radius: 8px;
            margin: 10px;
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .info-box-green {
            background-color: #4CAF50;
        }

        .info-box-yellow {
            background-color: #C5B700;
        }

        .news-section {
            margin-top: 40px;
            text-align: left;
        }

        .news-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .news-section ul {
            list-style: none;
            padding-left: 0;
        }

        .news-section ul li {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .news-section ul li::before {
            content: "★";
            margin-right: 10px;
            color: black;
        }

        .image-box {
            text-align: center;
            margin-top: 20px;
        }

        .image-box img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/storage/images/man.jpg" alt="logo" class="rounded-circle me-3" style="width: 50px;">
                <a href="{{route('homepage')}}" class="btn mx-1">Home</a>
                <a href="{{route('purchases')}}" class="btn mx-1">Purchases</a>
                @if(auth()->user()->role === 'admin') 
                <a href="{{route('dashboard')}}" class="btn mx-3">Admin Dashboard</a>
                @endif
                <a href="{{route('toppage')}}" class="btn mx-3">Product List</a>
                <a href="{{route('account')}}" class="btn mx-1">Account</a>
            </div>
            <form action="{{route('logout')}}" method="POST" class="d-inline">
                @csrf 
                <button type="submit" class="btn btn-link nav-link" style="color:#333; font-weight: 600;">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Search Box -->
    <div class="container search-box">
        <input type="text" placeholder="Search">
        <button type="button">Search</button>
    </div>

    <!-- Main Section -->
    <div class="container main-section">
    <h1>Good morning, {{ auth()->user()->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="info-box info-box-green">
                Purchased Goods <br> {{ $purchasedGoods }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box info-box-yellow">
                Most Purchased Item <br>
                @if($mostPurchasedItem)
                    {{ $mostPurchasedItem->productname }}
                @else
                    No Purchases Yet
                @endif
            </div>
        </div>
    </div>
</div>


        <div class="row news-section">
            <div class="col-md-6">
                <h2>News and Updates</h2>
                <ul>
                    <li>Most sold item this month</li>
                    <li>Featured item this month</li>
                </ul>
            </div>
            <div class="col-md-6 image-box">
                <img src="/storage/images/inve.jpg" alt="news image">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
