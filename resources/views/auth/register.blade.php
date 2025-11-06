<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NeoScreem Login</title>

  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
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
          borderRadius: {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
</head>

<body class="bg-background-dark font-display text-gray-200">
  
  {{-- Hiển thị thông báo thành công --}}
  @if (session('success'))
      <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
          <span class="font-medium">Success!</span> {{ session('success') }}
      </div>
  @endif

  <div class="min-h-screen flex w-full">

    {{-- Form đăng nhập (bên trái trên desktop) --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative z-10 bg-transparent">
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

        @if (session('error'))
          <div class="mb-4 text-center text-red-400 font-semibold">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
          <div class="mb-4 text-center text-red-400 font-semibold">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" 
                  class="bg-black/30 backdrop-blur-xl p-8 rounded-2xl shadow-2xl space-y-6 border border-white/10">
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
                            <input type="password" id="password" name="password"
                                   class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 pr-12 text-white placeholder-gray-500 form-control"
                                   placeholder="Create a password" required>
                            <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-white">
                                <!-- eye open -->
                                <svg id="password-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.104-3.362m3.315-2.28A9.958 9.958 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.042 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <!-- eye closed -->
                                <svg id="password-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88A3 3 0 0114.12 14.12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300" for="confirm-password">Confirm Password</label>
                        <div class="relative mt-1">
                            <input type="password" id="confirm-password" 
                                   name="password_confirmation" required
                                   class="form-input w-full rounded-lg border-transparent bg-black/30 focus:ring-primary focus:border-primary h-12 px-4 pr-12 text-white placeholder-gray-500 form-control"
                                   placeholder="Confirm your password">
                            <button type="button" id="toggleConfirmPassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-white">
                                <!-- eye open -->
                                <svg id="confirm-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.104-3.362m3.315-2.28A9.958 9.958 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.042 5.263M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <!-- eye closed -->
                                <svg id="confirm-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88A3 3 0 0114.12 14.12" />
                                </svg>
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

    {{-- Banner (bên phải trên desktop, ẩn trên mobile) --}}
    @php
      // Giới hạn danh sách phim hiển thị trên banner (tối đa 8)
      $phimSapChieu = ($phimSapChieu ?? collect());
      if (method_exists($phimSapChieu, 'take')) {
          $phimSapChieu = $phimSapChieu->take(8);
      }
      $first = $phimSapChieu->first();
    @endphp
    <div class="hidden lg:block w-1/2 relative overflow-hidden bg-black">
      <div id="banner-slider" class="absolute inset-0 group">
        {{-- Hiển thị tất cả ảnh banner của các phim (server-side) để đảm bảo luôn có hình, tối đa 8 ảnh --}}
        @foreach($phimSapChieu as $i => $p)
          @php
            $img = $p->anh_banner ? asset('storage/' . $p->anh_banner) : asset('storage/banner.jpg');
            $title = e($p->ten_phim ?? '');
            $desc = e(Str::limit($p->tom_tat ?? $p->mo_ta ?? '', 150));
          @endphp
          <div class="absolute inset-0 poster-animation flex items-center justify-center {{ $i === 0 ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-1000 ease-in-out" data-index="{{ $i }}" data-title="{{ $title }}" data-description="{{ $desc }}">
            <img src="{{ $img }}" alt="{{ $p->ten_phim ?? 'banner' }}" class="max-h-full max-w-full object-contain" />
          </div>
        @endforeach
        {{-- Nếu không có phim, vẫn hiển thị ảnh mặc định --}}
        @if($phimSapChieu->isEmpty())
          <div class="absolute inset-0 poster-animation flex items-center justify-center opacity-100">
            <img src="{{ asset('storage/banner.jpg') }}" alt="banner" class="max-h-full max-w-full object-contain" />
          </div>
        @endif
        <div class="absolute inset-0 z-10 flex items-end">
          <div class="w-full p-8 md:p-10">
            <h2 id="banner-title" class="text-white text-3xl md:text-5xl font-bold [text-shadow:0_2px_4px_rgba(0,0,0,0.7)]">{{ $first->ten_phim ?? 'Phim nổi bật' }}</h2>
            <p id="banner-description" class="text-white/80 mt-3 max-w-2xl text-base md:text-lg [text-shadow:0_1px_3px_rgba(0,0,0,0.7)]">{{ Str::limit($first->tom_tat ?? $first->mo_ta ?? 'Khám phá những bộ phim bom tấn đang được chiếu tại rạp.', 150) }}</p>
            <div class="mt-6 flex gap-3">
              <a href="#" class="px-4 py-2 bg-primary text-white rounded-lg">Xem Ngay</a>
              <a href="#" class="px-4 py-2 bg-white/20 text-white rounded-lg">Chi tiết</a>
            </div>
          </div>
        </div>

        <div id="banner-dots" class="absolute bottom-6 left-0 right-0 z-20 flex justify-center gap-2"></div>
        <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/30 rounded-full text-white hover:bg-black/50 transition-all opacity-0 group-hover:opacity-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-black/30 rounded-full text-white hover:bg-black/50 transition-all opacity-0 group-hover:opacity-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

  </div>

  {{-- Trailer Modal --}}
  <div id="trailer-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="relative w-full max-w-4xl">
      <button id="close-modal-btn" class="absolute -top-10 right-0 z-10 h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center transition-transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>

      <div style="position: relative; padding-bottom: 56.25%; height: 0;">
        <iframe id="trailer-iframe" class="absolute top-0 left-0 w-full h-full rounded-lg shadow-xl"
          frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // --- PASSWORD TOGGLES (register) ---
      const togglePasswordBtn = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const passwordEyeOpen = document.getElementById('password-eye-open');
      const passwordEyeClosed = document.getElementById('password-eye-closed');

      if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener('click', () => {
          const isPwd = passwordInput.getAttribute('type') === 'password';
          passwordInput.setAttribute('type', isPwd ? 'text' : 'password');
          if (passwordEyeOpen && passwordEyeClosed) {
            if (isPwd) {
              passwordEyeOpen.classList.remove('hidden');
              passwordEyeClosed.classList.add('hidden');
            } else {
              passwordEyeOpen.classList.add('hidden');
              passwordEyeClosed.classList.remove('hidden');
            }
          }
        });
      }

      const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
      const confirmInput = document.getElementById('confirm-password');
      const confirmEyeOpen = document.getElementById('confirm-eye-open');
      const confirmEyeClosed = document.getElementById('confirm-eye-closed');

      if (toggleConfirmBtn && confirmInput) {
        toggleConfirmBtn.addEventListener('click', () => {
          const isPwd = confirmInput.getAttribute('type') === 'password';
          confirmInput.setAttribute('type', isPwd ? 'text' : 'password');
          if (confirmEyeOpen && confirmEyeClosed) {
            if (isPwd) {
              confirmEyeOpen.classList.remove('hidden');
              confirmEyeClosed.classList.add('hidden');
            } else {
              confirmEyeOpen.classList.add('hidden');
              confirmEyeClosed.classList.remove('hidden');
            }
          }
        });
      }

      // Continue with existing DOMContentLoaded logic...
      const slides = [
        @foreach($phimSapChieu as $phim)
          {
            title: @json($phim->ten_phim),
            description: @json(Str::limit($phim->tom_tat, 150)),
            image: @json($phim->anh_banner ? asset('storage/' . $phim->anh_banner) : asset('storage/banner.jpg'))
          },
        @endforeach
      ];

      const banner = document.getElementById('banner-slider');
      console.log('BANNER SLIDES COUNT:', slides.length, slides);
      if (!slides || slides.length === 0) {
        // Không có slide — giữ nội dung server-side (fallback) hiển thị trên banner
        console.log('No slides available, using server-side fallback');
      } else {
        let currentSlide = 0;
        const bannerTitle = document.getElementById('banner-title');
        const bannerDescription = document.getElementById('banner-description');
        const dotsContainer = document.getElementById('banner-dots');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');
        let slideInterval;

        // Lấy các overlay đã render server-side
        const overlays = banner ? Array.from(banner.querySelectorAll('[data-index]')) : [];

        function showSlide(index) {
          if (!banner) return;
          index = ((index % slides.length) + slides.length) % slides.length; // normalize

          // sử dụng overlay có sẵn nếu có
          if (overlays.length) {
            overlays.forEach((ov, i) => {
              if (i === index) {
                ov.classList.remove('opacity-0');
                ov.classList.add('opacity-100');
              } else {
                ov.classList.remove('opacity-100');
                ov.classList.add('opacity-0');
              }
            });
          } else {
            // fallback: tạo overlay như trước
            const slide = slides[index];
            const overlay = document.createElement("div");
            overlay.className = "absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 ease-in-out";
            overlay.style.backgroundImage = `linear-gradient(90deg, rgba(18,18,18,0.8) 0%, rgba(18,18,18,0.6) 25%, rgba(18,18,18,0) 50%), url('${slides[index].image}')`;
            banner.insertBefore(overlay, banner.firstChild);
            setTimeout(() => overlay.classList.add("opacity-100"), 10);
            const oldOverlays = banner.querySelectorAll(".absolute.inset-0.bg-cover");
            if (oldOverlays.length > 1) setTimeout(() => oldOverlays[0].remove(), 1000);
          }

          // Cập nhật tiêu đề / mô tả
          bannerTitle.textContent = slides[index].title || (overlays[index] ? overlays[index].dataset.title : '');
          bannerDescription.textContent = slides[index].description || (overlays[index] ? overlays[index].dataset.description : '');

          // cập nhật dots
          const dots = dotsContainer ? Array.from(dotsContainer.querySelectorAll('button')) : [];
          dots.forEach((dot, i) => {
            const active = i === index;
            dot.classList.toggle('bg-white', active);
            dot.classList.toggle('w-4', active);
            dot.classList.toggle('bg-white/50', !active);
            dot.classList.toggle('w-2', !active);
          });

          currentSlide = index;
        }

        function nextSlide() { showSlide((currentSlide + 1) % slides.length); }
        function prevSlide() { showSlide((currentSlide - 1 + slides.length) % slides.length); }
        function resetSlideInterval() { clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 5000); }

        // Tạo dots dựa trên số slide (ưu tiên overlays nếu có)
        const dotCount = overlays.length || slides.length;
        for (let i = 0; i < dotCount; i++) {
          const dot = document.createElement('button');
          dot.classList.add('h-2', 'rounded-full', 'transition-all', 'duration-300');
          dot.addEventListener('click', () => { showSlide(i); resetSlideInterval(); });
          if (dotsContainer) dotsContainer.appendChild(dot);
        }

        if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetSlideInterval(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetSlideInterval(); });

        showSlide(0);
        slideInterval = setInterval(nextSlide, 5000);
      }

      // --- Trailer Modal ---
      const modal = document.getElementById('trailer-modal');
      const closeModalBtn = document.getElementById('close-modal-btn');
      const trailerIframe = document.getElementById('trailer-iframe');

      document.body.addEventListener('click', function (event) {
        if (event.target.matches('[data-trailer]')) {
          const trailerUrl = event.target.dataset.trailer;
          trailerIframe.src = trailerUrl;
          modal.classList.remove('hidden');
        }
      });

      closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        trailerIframe.src = '';
      });

      function closeModal() {
        if (modal && trailerIframe) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            trailerIframe.src = ''; // Dừng video
        }
    }
    if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);

    });
  </script>
</body>

</html>