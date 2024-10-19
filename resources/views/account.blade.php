<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Settings</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
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

    .main-section {
      padding: 30px;
    }

    .main-section h2 {
      font-size: 24px;
      margin-bottom: 20px;
      text-align: center;
    }

    .profile-pic {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      display: block;
      margin: 0 auto;
    }

    .change-pic {
      text-align: center;
      color: purple;
      font-weight: bold;
      margin-top: 10px;
      cursor: pointer;
    }

    .form-control {
      margin-bottom: 15px;
      padding: 10px;
      font-size: 16px;
    }

    .password-input-group {
      position: relative;
    }

    .password-input-group i {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .btn-save {
      background-color: #6fa9ff;
      color: #fff;
      font-weight: bold;
      font-size: 18px;
    }

    /* Hide the file input */
    .file-input {
      display: none;
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
  <nav class="navbar">
    <div class="container-fluid">
      <img src="/storage/images/man.jpg" alt="logo" class="rounded-circle me-3" style="width: 50px;">
      <a href="{{route('homepage')}}" class="btn mx-3">Home</a>
      <a href="{{route('purchases')}}" class="btn mx-3">Purchases</a>
      <a href="{{route('account')}}" class="btn mx-3">Account</a>
      @if(auth()->user()->role === 'admin') 
        <a href="{{route('dashboard')}}" class="btn mx-3">Admin Dashboard</a>
      @endif
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn logout-btn">Logout</button>
      </form>
    </div>
  </nav>

  <!-- Main Section -->
  <div class="container main-section">
    <div class="row">
      <div class="col-md-8">
        <h2>Account settings</h2>
        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
            </div>
            <div class="form-group password-input-group">
              <label for="new-password">New Password</label>
              <input type="password" id="new-password" class="form-control" name="password" placeholder="New Password">
              <i class="bi bi-eye-slash"></i>
            </div>
            <div class="form-group password-input-group">
              <label for="confirm-password">Confirm Password</label>
              <input type="password" id="confirm-password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
              <i class="bi bi-eye-slash"></i>
            </div>

            <!-- Hidden file input for uploading image -->
            <input type="file" id="profile_picture" class="file-input" name="profile_picture" accept="image/*">
            
            <button type="submit" class="btn btn-save w-100">Save</button>
            
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
        </form>
      </div>
      <div class="col-md-4 text-center">
        <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="profile-pic">
        <div class="change-pic">Change profile pic</div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Icons -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.js"></script>
  
  <script>
    // Trigger file input when clicking "Change profile pic"
    document.querySelector('.change-pic').addEventListener('click', function() {
      document.getElementById('profile_picture').click();
    });

    // Toggle password visibility
    const togglePasswordVisibility = () => {
      const passwordFields = document.querySelectorAll('.password-input-group input');
      const icons = document.querySelectorAll('.password-input-group i');

      icons.forEach((icon, index) => {
        icon.addEventListener('click', () => {
          const passwordField = passwordFields[index];
          if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
          } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
          }
        });
      });
    };

    togglePasswordVisibility();
  </script>
</body>
</html>
