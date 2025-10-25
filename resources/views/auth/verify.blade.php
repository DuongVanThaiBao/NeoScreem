<!DOCTYPE html>
<html class="dark" lang="vi">

<head>
    <meta charset="utf-8" />
    <title>Xác minh tài khoản</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0d6efd", // Màu xanh dương giống Bootstrap
                        "background-dark": "#121212",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "xl": "1rem",
                    },
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
                    <h2 class="text-3xl font-bold tracking-tight text-white">🔐 Xác minh tài khoản</h2>
                    <p class="mt-2 text-sm text-white/70">
                        Chúng tôi đã gửi mã xác minh đến email:<br>
                        <strong class="font-semibold text-white/90">{{ $email }}</strong>
                    </p>
                </div>
                @if(session('success'))
                <div id="success-message" class="p-4 text-sm text-green-200 bg-green-500/20 rounded-lg" role="alert">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                <div class="p-4 text-sm text-red-200 bg-red-500/20 rounded-lg" role="alert">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('verify.check') }}" class="space-y-6" x-data="{ 
                    timer: 60,
                    resendDisabled: true,
                    startTimer() {
                        this.resendDisabled = true;
                        this.timer = 60;
                        const interval = setInterval(() => {
                            if (this.timer > 0) {
                                this.timer--;
                            } else {
                                clearInterval(interval);
                                this.resendDisabled = false;
                            }
                        }, 1000);
                    }
                }" x-init="startTimer()">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div x-data="{
                        code: Array(6).fill(''),
                        handleInput(index, event) {
                            const value = event.target.value;
                            if (/^[0-9]$/.test(value)) {
                                this.code[index - 1] = value;
                                if (index < 6) {
                                    event.target.nextElementSibling.focus();
                                }
                            } else if (value === '') {
                                this.code[index - 1] = '';
                            } else {
                                event.target.value = this.code[index-1] || '';
                            }
                        },
                        handleKeydown(index, event) {
                            if (event.key === 'Backspace' && event.target.value === '') {
                                if (index > 1) {
                                   event.target.previousElementSibling.focus();
                                }
                            }
                        }
                    }">
                        <input type="hidden" name="code" x-bind:value="code.join('')">

                        <div class="flex justify-center gap-3">
                            <template :key="i" x-for="i in 6">
                                <input type="text" maxlength="1" class="w-12 h-14 text-center text-2xl font-semibold bg-white/5 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200" x-model="code[i-1]" @input.debounce.1ms="handleInput(i, $event)" @keydown="handleKeydown(i, $event)">
                            </template>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background-dark transition-colors duration-200">
                            Xác minh
                        </button>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center space-x-2 text-sm text-white/60">
                            <a href="{{ route('verify.send', ['email' => $email]) }}" @click.prevent="if (!resendDisabled) { startTimer(); window.location.href=$el.href }" :class="{'opacity-50 cursor-not-allowed': resendDisabled, 'hover:text-primary': !resendDisabled}" class="font-medium underline transition-colors duration-200">
                                Gửi lại mã
                            </a>
                            <template x-if="resendDisabled">
                                <span class="font-medium" x-text="`trong 0:${timer.toString().padStart(2, '0')}`"></span>
                            </template>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    // Auto-hide success messages after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.remove();
                }, 500);
            }, 3000);
        }
    });
</script>
</html>