<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập Rạp Phim</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #000;
      font-family: Arial, sans-serif;
      overflow: hidden;
      color: #fff;
    }
    .movie-strip {
      position: fixed;
      top: 0; left: 0;
      width: 200%;
      height: 100%;
      display: flex;
      animation: slide 60s linear infinite alternate;
      z-index: -1;
    }
    .movie-strip img {
      width: 20%;
      object-fit: cover;
      opacity: 0.5;
      filter: blur(1px);
    }
    @keyframes slide {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    .login-card {
      max-width: 500px;
      width: 90%;
      padding: 3rem;
      border-radius: 20px;
      background-color: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 30px rgba(0,0,0,0.6);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .login-card:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 40px rgba(0,0,0,0.8);
    }
    .login-card h3 {
      color: #ffd700;
    }
    .form-control {
      background-color: rgba(255,255,255,0.1);
      border: none;
      color: #fff;
    }
    .form-control:focus {
      background-color: rgba(255,255,255,0.2);
      color: #fff;
    }
    .btn-custom {
      background: linear-gradient(90deg, #ff9800, #ffc107);
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-custom:hover, .btn-custom:active {
      background: linear-gradient(90deg, #ffc107, #ff9800);
      color: #fff;
    }
    a { color: #ffd700; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <!-- Nền phim -->
  <div class="movie-strip">
    <img src="https://image.tmdb.org/t/p/w500/6MKr3KgOLmzOP6MSuZERO41Lpkt.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/2uNW4WbgBXL25BAbXGLnLqX71Sw.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/q719jXXEzOoYaps6babgKnONONX.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/9O7gLzmreU0nGkIB6K3BsJbzvNv.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/wXsQvli6tWqja51pYxXNG1LFIGV.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/6MKr3KgOLmzOP6MSuZERO41Lpkt.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/2uNW4WbgBXL25BAbXGLnLqX71Sw.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/q719jXXEzOoYaps6babgKnONONX.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/9O7gLzmreU0nGkIB6K3BsJbzvNv.jpg" alt="">
    <img src="https://image.tmdb.org/t/p/w500/wXsQvli6tWqja51pYxXNG1LFIGV.jpg" alt="">
  </div>

  <!-- Hộp đăng nhập -->
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card text-white">
      <h3 class="text-center mb-4">🎬 Đăng nhập</h3>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="remember" name="remember">
          <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>
        <button type="submit" class="btn btn-custom w-100 py-2">Đăng nhập</button>
      </form>
      <div class="text-center mt-3">
        <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
      </div>
      <div class="text-center mt-3">
        <a href="{{ route('register') }}" class="">Bạn chưa có tài khoản? Đăng ký nhé!</a>
        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
