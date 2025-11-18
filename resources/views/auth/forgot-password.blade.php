<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Forgot Password - NeoScreem</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#ea2a33",
        "background-light": "#0a0a0a",
        "background-dark": "#000000",
      },
      fontFamily: {
        "display": ["Plus Jakarta Sans", "sans-serif"]
      },
    },
  },
}
</script>

<style>
body {
  font-family: 'Plus Jakarta Sans', sans-serif;
}
</style>
</head>

<body class="bg-background-light font-display text-gray-200">

<div class="relative min-h-screen bg-gradient-to-b from-black to-gray-900">
    <div class="relative z-10 flex min-h-screen flex-col">
        <!-- Header -->
        <header class="border-b border-white/10 px-4 sm:px-6 lg:px-8">
            <div class="container mx-auto flex h-20 items-center justify-between">
                <a class="flex items-center gap-3 text-white" href="#">
                    <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                    </svg>
                    <span class="text-xl font-bold tracking-wider">NeoScreem</span>
                </a>
                <a href="{{ route('login') }}" class="hidden md:flex items-center justify-center rounded-lg bg-primary/20 px-6 py-2.5 text-sm font-bold text-white transition-colors hover:bg-primary/40">
                    Sign In
                </a>
            </div>
        </header>

        <!-- Form -->
        <main class="flex flex-1 items-center justify-center p-4">
            <div class="w-full max-w-md space-y-8 rounded-xl bg-white/10 p-8 shadow-2xl backdrop-blur-lg border border-white/10">
                <div class="text-center">
                    <h1 class="text-3xl font-extrabold text-white sm:text-4xl">Forgot Password?</h1>
                    <p class="mt-4 text-gray-400">
                        No worries! Enter your email and we’ll send you a reset link.
                    </p>
                </div>

                <!-- Hiển thị thông báo thành công -->
                @if (session('status'))
                    <p class="text-green-400 text-center font-medium">{{ session('status') }}</p>
                @endif

                <!-- Hiển thị lỗi nếu email chưa được đăng ký -->
                @if ($errors->any())
                    <div class="text-red-400 text-sm text-center font-medium">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form class="space-y-6" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label class="sr-only" for="email">Email address</label>
                        <input id="email" name="email" type="email" required
                            class="w-full rounded-lg border-none bg-black/40 p-4 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-black"
                            placeholder="Enter your email address">
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-primary px-4 py-3 text-base font-bold text-white shadow-lg shadow-primary/30 transition-all duration-300 hover:bg-opacity-90 hover:shadow-primary/50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-black">
                        Send Reset Link
                    </button>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-primary/80 transition-colors hover:text-primary">
                        Back to Sign In
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
