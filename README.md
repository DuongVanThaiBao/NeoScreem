# NeoScreem Cinema Management Platform

NeoScreem là hệ thống quản trị rạp phim xây dựng trên Laravel, cung cấp giao diện tối (dark theme) cùng bộ công cụ quản lý phim, lịch chiếu, nhân sự, marketing và cài đặt hệ thống. Tài liệu này tổng hợp sơ đồ kiến trúc, các module Admin và cách vận hành dự án.

## Mục lục

1. [Tổng quan & sơ đồ module](#tổng-quan--sơ-đồ-module)
2. [Bảng chức năng chi tiết](#bảng-chức-năng-chi-tiết)
3. [Phân tầng MVC](#phân-tầng-mvc)
4. [Lưu trữ dữ liệu](#lưu-trữ-dữ-liệu)
5. [Khởi chạy dự án](#khởi-chạy-dự-án)
6. [Tài khoản quản trị](#tài-khoản-quản-trị)
7. [Kiểm thử & tiện ích](#kiểm-thử--tiện-ích)
8. [Lộ trình & ghi chú](#lộ-trình--ghi-chú)

## Tổng quan & sơ đồ module

```
NeoScreem Admin Portal
└─ Trang chủ & Tổng quan
   ├─ Dashboard bán lẻ (RetailPulse)
   ├─ Điều hướng nhanh tới module con
└─ Quản lý cửa hàng (Stores)
└─ Quản lý phim (Movies)
└─ Quản lý người dùng (Users)
└─ Đơn hàng & Suất chiếu (Orders)
└─ Marketing
   ├─ Chiến dịch
   ├─ Phân tích
   └─ Nhắm mục tiêu khách hàng
└─ Nhân sự (HR)
   ├─ Nhân viên
   ├─ Lịch làm việc
   └─ Báo cáo nhân sự
└─ Hệ thống
   ├─ Cài đặt
   ├─ Bảo mật
   ├─ Sao lưu
   └─ Nhật ký hệ thống
└─ API & tiện ích nội bộ (reset stats, test data)
```

Tất cả route `/admin/*` được bảo vệ bởi middleware `auth` và điều hướng từ sidebar trong `resources/views/admin/admin.blade.php`.

## Bảng chức năng chi tiết

| Nhóm | Routes chính | Controller | View/Thư mục |
| --- | --- | --- | --- |
| Trang chủ Admin | `GET /admin` | `Admin\StatisticsController@adminHome` | `resources/views/admin/admin.blade.php` |
| Dashboard RetailPulse | `GET /admin/dashboard` | `Admin\StatisticsController@dashboard` | `resources/views/admin/dashboard.blade.php` |
| Cửa hàng | `GET/PUT /admin/stores` | `Admin\StoreController@index/update` | `resources/views/admin/stores.blade.php` |
| Phim | `GET/POST/PUT/DELETE /admin/movies...` | `Admin\MovieController` | `resources/views/admin/movies*.blade.php` |
| Người dùng | `GET/PUT/DELETE /admin/users...` | `Admin\UsersController` | `resources/views/admin/users/*.blade.php` |
| Đơn hàng & Suất chiếu | `GET /admin/orders` | `Admin\OrdersController@index` | `resources/views/admin/orders.blade.php` |
| Marketing – Campaigns | `GET /admin/marketing/campaigns` | `Admin\MarketingController@campaigns` | `resources/views/admin/marketing/campaigns.blade.php` |
| Marketing – Analytics | `GET /admin/marketing/analytics` | `Admin\MarketingController@analytics` | `resources/views/admin/marketing/analytics.blade.php` |
| Marketing – Targets | `GET/POST /admin/marketing/targets...` | `Admin\MarketingController@targets/storeSegment/exportSegment` | `resources/views/admin/marketing/targets.blade.php` |
| HR – Nhân viên | `Route::resource('admin/hr/employees')` | `Admin\EmployeeController` | `resources/views/admin/hr/employee-*.blade.php` |
| HR – Lịch làm việc | `GET/POST /admin/hr/schedules` | `Admin\ScheduleController` | `resources/views/admin/hr/schedules.blade.php` |
| HR – Báo cáo | `GET .../reports` + export | `Admin\HrReportsController` | `resources/views/admin/hr/reports*.blade.php` |
| Hệ thống – Cài đặt | `GET/PUT /admin/system/settings` | Closure (`web.php`) | `resources/views/admin/system/settings.blade.php` |
| Hệ thống – Bảo mật | `GET/PUT /admin/system/security` | Closure (`web.php`) | `resources/views/admin/system/security.blade.php` |
| Hệ thống – Sao lưu | `GET/POST /admin/system/backup...` | Closure (`web.php`) | `resources/views/admin/system/backup.blade.php` |
| Hệ thống – Nhật ký | `GET/POST /admin/system/logs...` | Closure (`web.php`) | `resources/views/admin/system/logs.blade.php` |
| API nội bộ thống kê | `/admin/api/statistics`, `/test-update-stats`, `/reset-stats`, ... | `Admin\StatisticsController` + closures | N/A (JSON) |

## Phân tầng MVC

### Controllers
- `App\Http\Controllers\Admin\*` cho từng module: Movies, Users, Orders, Marketing, HR, Store, Statistics.
- `App\Http\Controllers\Auth\*` xử lý đăng nhập/đăng ký/reset.
- `HomeController` cho trang client `/home`.

### Models
- `User`, `Admin`, `Employee`, `Schedule`, `Statistics`, `Segment`, `ReportSchedule`, `ReportTemplate` (Eloquent models).
- Dữ liệu phim hiện lưu bằng JSON (chưa có model Eloquent riêng).

### Views
- `resources/views/admin/...` chứa toàn bộ giao diện quản trị (tách theo module).
- `resources/views/auth/...` cho trang đăng nhập đăng ký.
- `resources/views/home.blade.php`, `welcome.blade.php` cho phía client.

### Routes
- Định nghĩa trong `routes/web.php` với nhóm `Route::middleware(['auth'])` cho Admin, kèm các tiện ích API và test.

## Lưu trữ dữ liệu

- **Phim**: `storage/app/movies.json` – seed 5 phim mẫu, thêm mới gán ID nhỏ nhất chưa dùng, lưu các trường `rating`, `tickets_sold`, `revenue`.
- **Cài đặt hệ thống**: `storage/app/settings.json` (thông tin rạp, giờ hoạt động, giá vé).
- **Chính sách bảo mật**: `storage/app/security.json` (policy mật khẩu, 2FA, IP whitelist...).
- **Sao lưu**: `storage/app/backups/*.zip` – tạo qua `/admin/system/backup/create`.
- **Log**: `storage/logs/laravel.log`, quản lý qua trang Nhật ký hệ thống.

## Khởi chạy dự án

```bash
git clone https://github.com/<your-org>/NeoScreem.git
cd NeoScreem
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate          # nếu sử dụng database
php artisan storage:link     # để truy cập storage qua public
npm install && npm run build # hoặc npm run dev trong quá trình phát triển
php artisan serve
```

## Tài khoản quản trị

1. Đăng ký người dùng qua form `/register`, sau đó cập nhật cột `role` thành `admin` (nếu database có cột).
2. Hoặc tạo nhanh bằng `php artisan tinker`:
   ```php
   \App\Models\User::create([
       'name' => 'Admin',
       'email' => 'admin@example.com',
       'password' => bcrypt('secret'),
       'role' => 'admin',
   ]);
   ```

## Kiểm thử & tiện ích

- Các route `/test-update-stats`, `/reset-stats`, `/reset-all-stats` đóng vai trò tiện ích để giả lập dữ liệu dashboard.
- Trang Admin hiển thị flash message nổi (z-index cao) để thông báo thao tác thành công.
- Script “Onboarding Protection” chặn script lạ được nhúng vào khu vực admin.

## Lộ trình & ghi chú

- Tích hợp module đặt vé thực tế để cập nhật `tickets_sold` và `revenue` cho từng phim.
- (Tuỳ chọn) Tạo Eloquent model cho Movies thay vì JSON.
- Hoàn thiện phân quyền vai trò (role) và phân cấp người dùng nếu cần.

---

NeoScreem phát triển trên Laravel, sử dụng giấy phép MIT giống framework nền tảng. Mọi đóng góp vui lòng tạo Pull Request hoặc liên hệ đội phát triển.
