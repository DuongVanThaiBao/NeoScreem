<!DOCTYPE html>
<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<title>NeoScreen - Order Summary</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#ea2a33",
            "background-light": "#f8f6f6",
            "background-dark": "#211111",
          },
          fontFamily: {
            "display": ["Plus Jakarta Sans"]
          },
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
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
<div class="flex flex-col min-h-screen">
<header class="border-b border-primary/20 dark:border-primary/30">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex items-center justify-between h-20">
<div class="flex items-center gap-3">
<svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M13.8261 17.4264C16.7203 18.1174 20.2244 18.5217 24 18.5217C27.7756 18.5217 31.2797 18.1174 34.1739 17.4264C36.9144 16.7722 39.9967 15.2331 41.3563 14.1648L24.8486 40.6391C24.4571 41.267 23.5429 41.267 23.1514 40.6391L6.64374 14.1648C8.00331 15.2331 11.0856 16.7722 13.8261 17.4264Z" fill="currentColor"></path>
<path clip-rule="evenodd" d="M39.998 12.236C39.9944 12.2537 39.9875 12.2845 39.9748 12.3294C39.9436 12.4399 39.8949 12.5741 39.8346 12.7175C39.8168 12.7597 39.7989 12.8007 39.7813 12.8398C38.5103 13.7113 35.9788 14.9393 33.7095 15.4811C30.9875 16.131 27.6413 16.5217 24 16.5217C20.3587 16.5217 17.0125 16.131 14.2905 15.4811C12.0012 14.9346 9.44505 13.6897 8.18538 12.8168C8.17384 12.7925 8.16216 12.767 8.15052 12.7408C8.09919 12.6249 8.05721 12.5114 8.02977 12.411C8.00356 12.3152 8.00039 12.2667 8.00004 12.2612C8.00004 12.261 8 12.2607 8.00004 12.2612C8.00004 12.2359 8.0104 11.9233 8.68485 11.3686C9.34546 10.8254 10.4222 10.2469 11.9291 9.72276C14.9242 8.68098 19.1919 8 24 8C28.8081 8 33.0758 8.68098 36.0709 9.72276C37.5778 10.2469 38.6545 10.8254 39.3151 11.3686C39.9006 11.8501 39.9857 12.1489 39.998 12.236ZM4.95178 15.2312L21.4543 41.6973C22.6288 43.5809 25.3712 43.5809 26.5457 41.6973L43.0534 15.223C43.0709 15.1948 43.0878 15.1662 43.104 15.1371L41.3563 14.1648C43.104 15.1371 43.1038 15.1374 43.104 15.1371L43.1051 15.135L43.1065 15.1325L43.1101 15.1261L43.1199 15.1082C43.1276 15.094 43.1377 15.0754 43.1497 15.0527C43.1738 15.0075 43.2062 14.9455 43.244 14.8701C43.319 14.7208 43.4196 14.511 43.5217 14.2683C43.6901 13.8679 44 13.0689 44 12.2609C44 10.5573 43.003 9.22254 41.8558 8.2791C40.6947 7.32427 39.1354 6.55361 37.385 5.94477C33.8654 4.72057 29.133 4 24 4C18.867 4 14.1346 4.72057 10.615 5.94478C8.86463 6.55361 7.30529 7.32428 6.14419 8.27911C4.99695 9.22255 3.99999 10.5573 3.99999 12.2609C3.99999 13.1275 4.29264 13.9078 4.49321 14.3607C4.60375 14.6102 4.71348 14.8196 4.79687 14.9689C4.83898 15.0444 4.87547 15.1065 4.9035 15.1529C4.91754 15.1762 4.92954 15.1957 4.93916 15.2111L4.94662 15.223L4.95178 15.2312ZM35.9868 18.996L24 38.22L12.0131 18.996C12.4661 19.1391 12.9179 19.2658 13.3617 19.3718C16.4281 20.1039 20.0901 20.5217 24 20.5217C27.9099 20.5217 31.5719 20.1039 34.6383 19.3718C35.082 19.2658 35.5339 19.1391 35.9868 18.996Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
<h1 class="text-xl font-bold text-gray-900 dark:text-white">NeoScreen</h1>
</div>
<nav class="hidden md:flex items-center gap-8">
<a class="text-sm font-medium hover:text-primary transition-colors" href="#">Now Showing</a>
<a class="text-sm font-medium hover:text-primary transition-colors" href="#">Coming Soon</a>
<a class="text-sm font-medium hover:text-primary transition-colors" href="#">Offers</a>
<a class="text-sm font-medium hover:text-primary transition-colors" href="#">Gift Cards</a>
</nav>
<div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center">
                        <label class="relative"><span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-gray-500"><svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg></span><input class="form-input w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 focus:border-primary h-10 placeholder:text-gray-400 dark:placeholder:text-gray-500 px-4 pl-10 text-sm font-normal" placeholder="Search movies..." type="search" /></label>
                    </div>
                    
                    <div class="hidden lg:flex items-center">
                        @auth
                            {{-- Nếu đã đăng nhập --}}
                            <div class="relative ml-4">
                                <div>
                                    <button type="button" class="flex max-w-xs items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-background-dark" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        {{-- Thay thế bằng avatar thật nếu có --}}
                                        <span class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                             <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.79,40.31,185.67,25.08,212a8,8,0,0,0,13.84,8c18.1-31.33,50.62-52,89.08-52s71,20.67,89.08,52a8,8,0,0,0,13.84-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
                                        </span>
                                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">{{ Auth::user()->name }}</span>
                                        <svg class="ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                                
                                <div id="user-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Hồ sơ cá nhân</a>
                                    <a href="{{ route('cart') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Giỏ hàng</a>
                                    <form action="{{ route('logout') }}" method="POST" role="none">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Nếu chưa đăng nhập --}}
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="rounded-md bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 transition-colors btn-glow">Đăng ký</a>
                            </div>
                        @endauth
                    </div>
                    <button id="mobile-menu-button" class="lg:hidden text-gray-900 dark:text-white"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,88H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0-16H216a8,8,0,0,0,0-16Z"></path></svg></button>
                </div>
</div>
</div>
</header>
<main class="flex-grow">
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
<div class="max-w-4xl mx-auto bg-background-light dark:bg-background-dark/50 rounded-xl shadow-lg overflow-hidden">
<div class="p-8">
<h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Order Summary</h2>
<div class="space-y-8" id="cart-items">
<div class="cart-item" data-price="24.00">
<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Movie Tickets</h3>
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
<tr>
<th class="px-6 py-3" scope="col">Movie Name</th>
<th class="px-6 py-3" scope="col">Show Date</th>
<th class="px-6 py-3" scope="col">Theater</th>
<th class="px-6 py-3" scope="col">Seat(s)</th>
<th class="px-6 py-3" scope="col">Ticket Type</th>
<th class="px-6 py-3" scope="col">Price/Seat</th>
<th class="px-6 py-3" scope="col"></th>
</tr>
</thead>
<tbody>
<tr class="bg-white border-b dark:bg-background-dark/30 dark:border-gray-700">
<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">The Midnight Horizon</td>
<td class="px-6 py-4">2024-03-15, 07:00 PM</td>
<td class="px-6 py-4">Screening Room 3</td>
<td class="px-6 py-4">A1, A2</td>
<td class="px-6 py-4">Regular</td>
<td class="px-6 py-4">$12.00</td>
<td class="px-6 py-4">
<button class="remove-item-btn text-gray-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="cart-item" data-price="15.00">
<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Food &amp; Drinks</h3>
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
<tr>
<th class="px-6 py-3" scope="col">Food Combo Item</th>
<th class="px-6 py-3" scope="col">Quantity</th>
<th class="px-6 py-3" scope="col">Price</th>
<th class="px-6 py-3" scope="col"></th>
</tr>
</thead>
<tbody>
<tr class="bg-white border-b dark:bg-background-dark/30 dark:border-gray-700">
<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
<div>Snack Pack Combo</div>
<div class="text-xs text-gray-500 dark:text-gray-400">1 Large Popcorn, 2 Medium Drinks</div>
</td>
<td class="px-6 py-4">1</td>
<td class="px-6 py-4">$15.00</td>
<td class="px-6 py-4">
<button class="remove-item-btn text-gray-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="mt-8 pt-8 border-t-2 border-dashed border-primary/30">
<div class="flex justify-between items-center text-2xl font-bold text-gray-900 dark:text-white">
<span>Total</span>
<span id="total-amount">$39.00</span>
</div>
<p class="text-xs text-gray-500 dark:text-gray-400 mt-4">By proceeding, you agree to our Terms and Conditions and Privacy Policy.</p>
<button class="w-full mt-6 bg-primary hover:bg-primary/90 text-white font-bold py-3 px-4 rounded-lg text-lg transition-colors">
                Proceed to Payment
              </button>
</div>
</div>
</div>
</div>
</main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const cartItemsContainer = document.getElementById('cart-items');
      const totalAmountElement = document.getElementById('total-amount');
      function updateTotal() {
        let total = 0;
        const cartItems = cartItemsContainer.querySelectorAll('.cart-item');
        cartItems.forEach(item => {
          total += parseFloat(item.dataset.price);
        });
        totalAmountElement.textContent = `$${total.toFixed(2)}`;
      }
      cartItemsContainer.addEventListener('click', function (e) {
        const removeButton = e.target.closest('.remove-item-btn');
        if (removeButton) {
          const itemToRemove = removeButton.closest('.cart-item');
          if (itemToRemove) {
              const tableRow = removeButton.closest('tr');
              if (tableRow) {
                // If removing the last row in a table, remove the whole cart-item section
                const tableBody = tableRow.parentElement;
                if (tableBody.children.length === 1) {
                    itemToRemove.remove();
                } else {
                    tableRow.remove();
                }
              } else {
                itemToRemove.remove();
              }
              updateTotal();
          }
        }
      });
      // Initial total calculation
      updateTotal();

      const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', () => {
                    const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                    userMenuButton.setAttribute('aria-expanded', !isExpanded);
                    userMenu.classList.toggle('hidden');
                });

                // Close dropdown if clicked outside
                document.addEventListener('click', (event) => {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenuButton.setAttribute('aria-expanded', 'false');
                        userMenu.classList.add('hidden');
                    }
                });
            }
    });
    
  </script>

</body></html>