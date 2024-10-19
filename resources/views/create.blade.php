<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            padding: 50px;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .btn-register {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            width: 100%;
            border: none;
        }

        .btn-register:hover {
            background-color: #218838;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Custom file input style */
        .custom-file-label::after {
            content: "Browse";
            background-color: #007bff;
            border-left: none;
            color: white;
            padding: 0.375rem 0.75rem;
        }

        .custom-file-label {
            background-color: white;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Create Product</h2>
        <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            @foreach ($errors->all() as $error)
  <li>{{$error}}</li>
@endforeach



            <div class="form-group">
                <label for="productname">Product Name</label>
                <input type="text" class="form-control" id="productname" name="productname" placeholder="Enter product name" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock">Available Stock</label>
                <input type="number" class="form-control" id="stock" name="available_stock" placeholder="Enter available stock" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description" required></textarea>
            </div>

            <div class="form-group">
    <label for="image">Product Image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="image" name="image">
        <label class="custom-file-label" for="image">Choose file</label>
    </div>
</div>

            </div>

            <button type="submit" class="btn btn-register">Register Product</button>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom script for showing file name in the file input -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

</body>
</html>
