<!DOCTYPE html>
<html class="dark" lang="vi">

<head>
    <meta charset="utf-8" />
    <title>Xác minh tài khoản</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: { primary: "#0d6efd", "background-dark": "#121212" },
                    fontFamily: { display: ["Plus Jakarta Sans", "sans-serif"] },
                },
            },
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-display bg-gray-100 dark:bg-background-dark text-white">
    <div class="relative min-h-screen">
        <div class="absolute inset-0 bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1559963110-71b394e7494d?q=80&w=2070&auto=format&fit=crop");'>
            <div class="absolute inset-0 bg-background-dark/80 backdrop-blur-md"></div>
        </div>

        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-md p-8 space-y-6 bg-black/40 border border-white/10 rounded-xl shadow-2xl backdrop-blur-lg">
                <div class="text-center">
                    <h2 class="text-3xl font-bold">🔐 Xác minh tài khoản</h2>
                    <p class="mt-2 text-sm text-white/70">
                        Mã xác minh đã được gửi đến email:<br>
                        <strong>{{ $email ?? 'Không xác định' }}</strong>
                    </p>
                </div>

                @if(session('error'))
                    <div class="p-3 text-sm text-red-100 bg-red-600 rounded-lg">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="p-3 text-sm text-green-100 bg-green-600 rounded-lg">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('verify.submit') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div>
                        <label for="code" class="block text-sm mb-1">Nhập mã xác minh</label>
                        <input type="text" name="code" id="code"
                            class="w-full rounded-lg border-gray-300 text-black focus:ring-primary focus:border-primary" required autofocus>
                    </div>
                    <button type="submit"
                        class="w-full py-2 font-semibold text-white bg-primary rounded-lg hover:bg-blue-700 transition">
                        Xác minh
                    </button>
                </form>

                <div class="text-sm text-center text-white/70">
                    Chưa nhận được mã?
                    <a href="{{ route('verify.send', ['email' => $email]) }}"
                       class="text-primary font-semibold hover:underline">
                        Gửi lại mã
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
