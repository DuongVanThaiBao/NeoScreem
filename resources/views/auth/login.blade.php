<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>NeoScreem Login</title>
  <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
  <link href="https://fonts.googleapis.com" rel="preconnect"/>
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <style type="text/tailwindcss">
    @keyframes poster-rotate {
      0% { object-position: 0% 50%; }
      25% { object-position: 50% 0%; }
      50% { object-position: 100% 50%; }
      75% { object-position: 50% 100%; }
      100% { object-position: 0% 50%; }
    }
    .poster-animation { animation: poster-rotate 20s linear infinite; }
  </style>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#ea2a33",
            "background-light": "#f8f6f6",
            "background-dark": "#121212",
          },
          fontFamily: { "display": ["Plus Jakarta Sans"] },
          borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
        },
      },
    }
  </script>
</head>
{{-- Hiển thị thông báo thành công sau khi xác minh email --}}
@if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">Success!</span> {{ session('success') }}
    </div>
@endif
<body class="bg-background-dark font-display text-gray-200">
  <div class="relative flex min-h-screen w-full">
    <div class="hidden lg:block w-1/2 relative overflow-hidden">
      <img alt="Movie poster" class="h-full w-full object-cover poster-animation" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCacZICYIvSqThWEbtHePVzwBl3-gH3m19WgkMBGVlPmjhFbVzm5S1KVji5pLiFo-b2u65WUaxHJrEEL0ES3l69hFht7TpQO33YzORVgvycM8jkFGUhwXFH9NzBSCexXlhSvyA7fQpBRBcQsF4aCUlJsaUIuaw7OdkVKN2HwQx50wU46XTfZf5BR1kKP_9uhuLYG3vTidAgz6HmAHaTVwmsBNAVBKhlUVVCFVH4A5IURoLMDazWcmuU28pvGsOQuUmRoVhI1MPm8JM2"/>
      <div class="absolute inset-0 bg-gradient-to-r from-background-dark/80 via-background-dark/50 to-transparent"></div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
      <div class="absolute inset-0 lg:hidden">
        <img alt="Movie poster" class="h-full w-full object-cover opacity-20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBYK4AefWvKgJ967HcSqZhBb7Gmj9mxCx9icZynkUEvd0gSrCw7O0VDfFjWS61MSWH3fSoZitnyRf6voRVINDDUbfwWVe_BDO8yvxxUXrAILLUfmdNmHq6nI4N0bYE_Xe3Jb66gA3EVfdefIhii1GNuejXySCO2IkoYm2Hm-kE2fK2x4x-uObwMGoifU0dvgYH-bZ1zI5uT1AL17F2zT4D_LVon-fNuLzBPgTfORRHd84kGkj6SKXLLlLPJCdaGjtAP3w4K4F8sGiiR"/>
        <div class="absolute inset-0 bg-background-dark/80"></div>
      </div>

      <div class="relative z-10 w-full max-w-md">
        <div class="flex items-center gap-3 mb-8 justify-center lg:justify-start">
          <div class="w-10 h-10 text-primary">
            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
              <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-white">NeoScreem</h2>
        </div>

        <div class="text-center lg:text-left mb-8">
          <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Welcome Back</h1>
          <p class="mt-2 text-gray-400">Sign in to continue your movie journey.</p>
        </div>

        <!-- ✅ Thông báo lỗi đăng nhập -->
        @if (session('error'))
          <div class="mb-4 text-center text-red-400 font-semibold">
            {{ session('error') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 text-center text-red-400 font-semibold">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="bg-black/30 backdrop-blur-xl p-8 rounded-2xl shadow-2xl space-y-6 border border-white/10">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-300" for="email">Email</label>
                <div class="mt-1">
                  <input class="form-input block w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 text-white placeholder-gray-500" id="email" name="email" placeholder="Enter your email" required type="email"/>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300" for="password">Password</label>
                <div class="mt-1 relative">
                  <input class="form-input block w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 text-white placeholder-gray-500 pr-10" id="password" name="password" placeholder="Enter your password" required type="password"/>
                  <!-- Nút con mắt -->
                  <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-white">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-end">
              <a class="text-sm font-medium text-primary hover:text-primary/80" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>

            <div>
              <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-background-dark focus:ring-primary transition-all duration-300" type="submit">
                Login
              </button>
            </div>
          </div>
        </form>

        <p class="text-center text-sm text-gray-400 mt-8">
          Don't have an account? 
          <a class="font-medium text-primary hover:text-primary/80" href="{{ route('register') }}">Sign up</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);

      if (type === 'text') {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.104-3.362m3.315-2.28A9.958 9.958 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.042 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />`;
      } else {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
      }
    });
  </script>
</body>
</html>
