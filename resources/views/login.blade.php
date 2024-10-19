<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body, html {
      height: 100%;
      font-family: 'Arial', sans-serif;
    }

    /* Full gradient background */
    body {
      background: linear-gradient(to right, #ee0979, #ff6a00, #00f260, #0575e6);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Login form container */
    .login-box {
      background: rgba(0, 0, 0, 0.8);
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
      width: 350px;
      text-align: center;
    }

    /* Title of login form */
    .login-box h1 {
      color: white;
      font-size: 28px;
      margin-bottom: 30px;
    }

    /* Input fields */
    .login-box input {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      background-color: #333;
      border: 1px solid #00ff00;
      border-radius: 5px;
      color: white;
      font-size: 16px;
    }

    /* Login button */
    .login-box button {
      background-color: transparent;
      border: 2px solid #00ff00;
      color: #00ff00;
      padding: 12px;
      width: 100%;
      border-radius: 5px;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .login-box button:hover {
      background-color: #00ff00;
      color: #000;
    }

    /* Forgot password */
    .login-box a {
      display: block;
      color: #00ff00;
      text-decoration: none;
      margin: 15px 0;
    }

    .login-box a:hover {
      text-decoration: underline;
    }

    /* Social media icons */
    .social-icons {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .social-icons a {
      color: white;
      margin: 0 10px;
      font-size: 24px;
    }

    .social-icons a:hover {
      color: #00ff00;
    }
  </style>
</head>
<body>
@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif

  <div class="login-box">
    <h1>LOGIN</h1>
    <p>Please enter your login and password!</p>

    <!-- Username and password fields -->
    <form method="POST" action="{{route('login')}}">
        @csrf 
      <div class="form-group mb-3">
      <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
      </div>
      <div class="form-group mb-3">
      <input type="password" placeholder="Password" id="password" class="form-control" name="password" required autofocus>
      </div>
      <a href="#">Forgot password?</a>
      

      <!-- Login button -->
      <button type="submit">Login</button>

      <!-- Social icons -->
      <div class="social-icons">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-google"></i></a>
      </div>
    </form>
  </div>

  <!-- Font Awesome for icons -->
  <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
</body>
</html>
