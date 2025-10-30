<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Reset Password - NeoScreem</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#ea2a33",
            "background-light": "#f8f6f6",
            "background-dark": "#211111",
          },
          fontFamily: {
            display: ["Plus Jakarta Sans"],
          },
        },
      },
    };
  </script>

  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
  </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-gray-100">

  <div class="relative min-h-screen w-full bg-cover bg-center bg-no-repeat" 
       style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB6enkcCRG-nFVItgmDqKWuxPYn76QPs9GaUwa9_8FzzrUH53gXEBCiQdPJebA5Qoej7Hb46rsocJxOIcQMC1xBHi-wF4Sofb0n3IFPWOBIgf5WAPActGZiqjz4wiCb_xClMCXd1jkYvf35qkw3-d_BvgMeGwZmMVUbKfOUkrdewsH8IbPtitKYAWaDQpWeVpQ4Tg7zmPf0DDHbM6UIwF9mxV__Am7rSEuSJ4t6eP-3-cRVl_S21XuAQML9fvFleY8hfyJl2iCxEuAm');">
    
    <div class="absolute inset-0 bg-background-dark/80 backdrop-blur-sm"></div>

    <div class="relative z-10 flex min-h-screen flex-col">
      
      <!-- Header -->
      <header class="flex items-center justify-between px-6 sm:px-10 py-4">
        <div class="flex items-center gap-3">
          <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"/>
          </svg>
          <h1 class="text-xl font-bold text-white">NeoScreem</h1>
        </div>
        <a href="{{ route('login') }}" 
           class="rounded bg-primary/20 dark:bg-primary/20 px-4 py-2 text-sm font-bold text-white hover:bg-primary/40 transition-colors">
          Sign In
        </a>
      </header>

      <!-- Main -->
      <main class="flex flex-1 items-center justify-center p-4">
        <div class="w-full max-w-md space-y-8 rounded-xl bg-background-light/10 dark:bg-background-dark/50 p-8 shadow-2xl backdrop-blur-lg">
          <div class="text-center">
            <h2 class="text-3xl font-extrabold text-white">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-300 dark:text-gray-400">Enter a new password for your account.</p>
          </div>

          <!-- FORM -->
          <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="relative">
              <label class="sr-only" for="password">New Password</label>
              <input id="password" name="password" type="password" autocomplete="new-password"
                     placeholder="New Password" required
                     class="peer w-full rounded-lg border-2 border-transparent bg-white/10 dark:bg-white/5 px-4 py-3 text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-0">
              <button type="button" onclick="togglePasswordVisibility('password', this)" 
                      class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-white">
                <span class="material-symbols-outlined text-xl">visibility_off</span>
              </button>
            </div>

            <div class="relative">
              <label class="sr-only" for="password_confirmation">Confirm Password</label>
              <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                     placeholder="Confirm New Password" required
                     class="peer w-full rounded-lg border-2 border-transparent bg-white/10 dark:bg-white/5 px-4 py-3 text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-0">
              <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" 
                      class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-white">
                <span class="material-symbols-outlined text-xl">visibility_off</span>
              </button>
            </div>

            <div>
              <button type="submit"
                      class="w-full justify-center rounded-lg bg-primary px-4 py-3 text-base font-bold text-white shadow-lg shadow-primary/30 transition-all hover:bg-opacity-90 hover:shadow-primary/50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background-dark">
                Reset Password
              </button>
            </div>
          </form>

          <!-- Hiển thị lỗi -->
          @if ($errors->any())
            <div class="mt-4 text-red-400 text-sm">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

        </div>
      </main>
    </div>
  </div>

  <script>
    function togglePasswordVisibility(inputId, button) {
      const input = document.getElementById(inputId);
      const icon = button.querySelector('.material-symbols-outlined');
      if (input.type === "password") {
          input.type = "text";
          icon.textContent = "visibility";
      } else {
          input.type = "password";
          icon.textContent = "visibility_off";
      }
    }
  </script>
</body>
</html>
