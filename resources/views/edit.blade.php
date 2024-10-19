<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

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

        .btn-update {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            width: 100%;
            border: none;
        }

        .btn-update:hover {
            background-color: #0056b3;
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
        <h2>Edit Product</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="productname">Product Name</label>
        <input type="text" class="form-control" id="productname" name="productname" value="{{ $product->productname }}" required>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" step="0.01" required>
    </div>

    <div class="form-group">
        <label for="available_stock">Available Stock</label>
        <input type="number" class="form-control" id="available_stock" name="available_stock" value="{{ $product->available_stock }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="image">Product Image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" name="image">
            <label class="custom-file-label" for="image">Choose file</label>
        </div>
        <!-- Display the existing image -->
        @if($product->image)
            <div class="mt-3">
                <img src="{{ Storage::url($product->image) }}" alt="Product Image" style="width: 100px;">
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
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
