<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#ea2a33",
                        "background-light": "#f8f6f6",
                        "background-dark": "#121212",
                    },
                    fontFamily: {
                        display: ["Plus Jakarta Sans"]
                    },
                    borderRadius: {
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                },
            },
        }
    </script>

    <style type="text/tailwindcss">
        @keyframes poster-rotate {
          0%, 100% { transform: scale(1.1) rotate(0deg) translateX(5%); }
          25% { transform: scale(1.15) rotate(1deg) translateX(0%); }
          50% { transform: scale(1.1) rotate(0deg) translateX(-5%); }
          75% { transform: scale(1.05) rotate(-1deg) translateX(0%); }
        }
        .poster-animation { animation: poster-rotate 40s ease-in-out infinite; }
    </style>
</head>
<body class="bg-background-dark font-display text-gray-200">

<div class="relative min-h-screen flex items-center justify-center lg:justify-start">
    <div class="absolute inset-0 z-10 w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="absolute inset-0 bg-background-dark lg:bg-transparent lg:bg-gradient-to-r from-background-dark via-background-dark/70 to-transparent"></div>

        <div class="relative z-10 w-full max-w-md">
            <div class="flex items-center gap-3 mb-8 justify-center lg:justify-start">
                <div class="w-10 h-10 text-primary">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">NeoScreem</h2>
            </div>

            <div class="text-center lg:text-left mb-8">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Create Account</h1>
                <p class="mt-2 text-gray-400">Join us and start your movie journey today.</p>
            </div>

            
            <form method="POST" action="{{ route('register') }}" 
                  class="bg-black/30 backdrop-blur-xl p-8 rounded-2xl shadow-2xl space-y-6 border border-white/10"
                  x-data="{ passwordVisible: false, confirmPasswordVisible: false }">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300" for="username">Full Name</label>
                        <input id="username" name="name" type="text" required
                               class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 text-white placeholder-gray-500 form-control"
                               placeholder="Enter your full name" value="{{ old('name') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300" for="email">Email Address</label>
                        <input id="email" name="email" type="email" required
                               class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 text-white placeholder-gray-500 form-control"
                               placeholder="Enter your email" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300" for="password">Password</label>
                        <div class="relative mt-1">
                            <input :type="passwordVisible ? 'text' : 'password'" id="password" name="password"
                                   class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 pr-12 text-white placeholder-gray-500 form-control"
                                   placeholder="Create a password" required>
                            <button type="button" 
                                    @click="passwordVisible = !passwordVisible"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-white">
                                <span class="material-symbols-outlined" 
                                      x-text="passwordVisible ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300" for="confirm-password">Confirm Password</label>
                        <div class="relative mt-1">
                            <input :type="confirmPasswordVisible ? 'text' : 'password'" id="confirm-password" 
                                   name="password_confirmation" required
                                   class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 pr-12 text-white placeholder-gray-500 form-control"
                                   placeholder="Confirm your password">
                            <button type="button" 
                                    @click="confirmPasswordVisible = !confirmPasswordVisible"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-white">
                                <span class="material-symbols-outlined" 
                                      x-text="confirmPasswordVisible ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-background-dark focus:ring-primary transition-all duration-300">
                    Register
                </button>
            </form>

            <p class="text-center text-sm text-gray-400 mt-8">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80">Log in</a>
            </p>
        </div>
    </div>

    <div class="absolute inset-0 lg:left-1/2 hidden lg:block">
        <div class="h-full w-full overflow-hidden">
            <img src="https://m.media-amazon.com/images/M/MV5BYjJkZGUwMDEtYTJiYS00ZTc5LTk3MjQtNjgxODM2NjNmYzhmXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg"
                 alt="Movie poster"
                 class="h-full w-full object-cover poster-animation">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent">
                <div class="absolute bottom-0 p-8 md:p-10 z-10 w-full">
                    <h2 class="text-white text-3xl md:text-5xl font-bold [text-shadow:0_2px_4px_rgba(0,0,0,0.7)]">
                        Phim Chiếu Rạp Mới
                    </h2>
                    <p class="text-white/80 mt-3 max-w-2xl text-base md:text-lg [text-shadow:0_1px_3px_rgba(0,0,0,0.7)]">
                        Khám phá những bộ phim bom tấn đang được chiếu tại rạp với trải nghiệm âm thanh và hình ảnh tuyệt vời
                    </p>
                    <div class="mt-6 flex gap-4">
                        <button class="px-6 py-3 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-md">
                            Xem Ngay
                        </button>
                        <button class="px-6 py-3 bg-white/20 text-white text-sm font-bold rounded-lg hover:bg-white/30 backdrop-blur-sm transition-colors">
                            Tìm Hiểu Thêm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
</body>
</html>
