# NeoScreem ERD (Entity Relationship Diagram)

## Tổng quan hệ thống
NeoScreem là hệ thống quản lý rạp chiếu phim với các module chính:
- **Quản lý người dùng** (Authentication)
- **Quản lý phim & khuyến mãi** (Movie Management)
- **Quản lý rạp & suất chiếu** (Theater Management)
- **Đặt vé** (Booking System)
- **Quản trị viên & Báo cáo** (Admin & Reporting)

## Core Tables

### users
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **name** (VARCHAR(255)) - Tên người dùng
- **email** (VARCHAR(255), Unique) - Email duy nhất
- **email_verified_at** (TIMESTAMP, Nullable) - Thời gian xác thực email
- **password** (VARCHAR(255)) - Mật khẩu đã hash
- **remember_token** (VARCHAR(100), Nullable) - Token ghi nhớ đăng nhập
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `email` (unique), `remember_token` (index)

### password_reset_tokens
- **email** (PK, VARCHAR(255)) - Khóa chính, email người dùng
- **token** (VARCHAR(255)) - Token reset mật khẩu
- **created_at** (TIMESTAMP, Nullable) - Thời gian tạo token
- **Constraints**: Primary key trên `email`

### sessions
- **id** (PK, VARCHAR(255)) - ID session Laravel
- **user_id** (FK to users.id, BIGINT, Nullable, Indexed) - Liên kết user
- **ip_address** (VARCHAR(45), Nullable) - IP người dùng
- **user_agent** (TEXT, Nullable) - Browser info
- **payload** (LONGTEXT) - Dữ liệu session
- **last_activity** (INTEGER) - Thời gian hoạt động cuối
- **Indexes**: `user_id` (index), `last_activity` (index)

## Movie Management Tables

### phim (Movies)
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **ten_phim** (VARCHAR(255)) - Tên phim
- **dao_dien** (VARCHAR(255), Nullable) - Đạo diễn
- **dien_vien** (VARCHAR(255), Nullable) - Diễn viên
- **the_loai** (VARCHAR(100), Nullable) - Thể loại
- **thoi_luong** (INTEGER, Nullable) - Thời lượng (phút)
- **mo_ta** (TEXT, Nullable) - Mô tả phim
- **anh_poster** (VARCHAR(255), Nullable) - Link poster
- **trailer_url** (VARCHAR(255), Nullable) - Link trailer
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `ten_phim` (index), `the_loai` (index)
- **thoi_luong** (INTEGER, Nullable)
- **mo_ta** (TEXT, Nullable)
- **anh_poster** (VARCHAR, Nullable)
- **trailer_url** (VARCHAR, Nullable)
- **created_at** (TIMESTAMP)
- **updated_at** (TIMESTAMP)

### khuyen_mai (Promotions)
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **ten_khuyen_mai** (VARCHAR(255)) - Tên khuyến mãi
- **mo_ta** (TEXT, Nullable) - Mô tả chi tiết
- **phan_tram_giam_gia** (DECIMAL(5,2), Nullable) - % giảm giá (20.00 = 20%)
- **so_tien_giam_gia** (DECIMAL(12,2), Nullable) - Số tiền giảm (VNĐ)
- **ngay_bat_dau** (DATE, Nullable) - Ngày bắt đầu
- **ngay_ket_thuc** (DATE, Nullable) - Ngày kết thúc
- **anh_banner** (VARCHAR(255), Nullable) - Banner khuyến mãi
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Constraints**: CHECK (`phan_tram_giam_gia` BETWEEN 0 AND 100)
- **ngay_bat_dau** (DATE, Nullable)
- **ngay_ket_thuc** (DATE, Nullable)
- **anh_banner** (VARCHAR, Nullable)
- **created_at** (TIMESTAMP)
- **updated_at** (TIMESTAMP)

### phim_khuyen_mai (Movie-Promotion Junction Table)
- **phim_id** (FK to phim.id, BIGINT, ON DELETE CASCADE) - ID phim
- **khuyen_mai_id** (FK to khuyen_mai.id, BIGINT, ON DELETE CASCADE) - ID khuyến mãi
- **Constraints**: Composite Primary Key (`phim_id`, `khuyen_mai_id`)

### theaters
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **name** (VARCHAR(255)) - Tên rạp
- **location** (VARCHAR(255), Nullable) - Địa chỉ
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `name` (index)

### showtimes
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **phim_id** (FK to phim.id, BIGINT) - ID phim
- **theater_id** (FK to theaters.id, BIGINT, Nullable) - ID rạp
- **ngay_chieu** (DATE) - Ngày chiếu
- **gio_chieu** (TIME) - Giờ chiếu
- **gia_ve** (DECIMAL(10,2)) - Giá vé
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Constraints**: FOREIGN KEY (`phim_id`) REFERENCES `phim`(`id`), FOREIGN KEY (`theater_id`) REFERENCES `theaters`(`id`)
- **Indexes**: `phim_id` (index), `ngay_chieu` (index)
- **created_at** (TIMESTAMP)
- **updated_at** (TIMESTAMP)

### bookings
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **user_id** (FK to users.id, BIGINT) - ID người đặt
- **showtime_id** (FK to showtimes.id, BIGINT) - ID suất chiếu
- **seats** (VARCHAR(255), Nullable) - Số ghế (A1,A2,A3)
- **total_price** (DECIMAL(10,2)) - Tổng tiền
- **booking_status** (ENUM('pending','confirmed','cancelled'), Default 'pending') - Trạng thái
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Constraints**: FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE, FOREIGN KEY (`showtime_id`) REFERENCES `showtimes`(`id`) ON DELETE CASCADE
- **Indexes**: `user_id` (index), `showtime_id` (index), `booking_status` (index)
- **booking_status** (VARCHAR, Nullable)
- **created_at** (TIMESTAMP)
- **updated_at** (TIMESTAMP)

## Admin Management Tables (feature/admin branch)

### statistics
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **tickets_sold_today** (INTEGER, Default 0) - Số vé bán hôm nay
- **revenue_today** (DECIMAL(15,2), Default 0) - Doanh thu hôm nay
- **avg_customers_per_store** (DECIMAL(8,2), Default 0) - TB khách hàng/rạp
- **campaign_roi** (DECIMAL(8,2), Default 0) - ROI chiến dịch
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật

### employees
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **code** (VARCHAR(50), Unique) - Mã nhân viên
- **name** (VARCHAR(255)) - Tên nhân viên
- **department** (VARCHAR(100)) - Phòng ban
- **position** (VARCHAR(100), Nullable) - Vị trí
- **email** (VARCHAR(255), Nullable) - Email
- **phone** (VARCHAR(20), Nullable) - SĐT
- **hire_date** (DATE, Nullable) - Ngày tuyển dụng
- **salary** (DECIMAL(10,2), Nullable) - Lương
- **status** (ENUM('active','inactive','terminated'), Default 'active') - Trạng thái
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `code` (unique), `department` (index)

### schedules
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **employee_id** (FK to employees.id, BIGINT, ON DELETE CASCADE) - ID nhân viên
- **department** (VARCHAR(100), Nullable) - Phòng ban làm việc
- **date** (DATE) - Ngày làm việc
- **start_time** (TIME) - Giờ bắt đầu
- **end_time** (TIME) - Giờ kết thúc
- **break_duration** (INTEGER, Nullable) - Thời gian nghỉ (phút)
- **status** (ENUM('scheduled','completed','absent'), Default 'scheduled') - Trạng thái
- **notes** (TEXT, Nullable) - Ghi chú
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `employee_id` (index), `date` (index)

### report_schedules
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **email** (VARCHAR(255)) - Email nhận báo cáo
- **cadence** (ENUM('daily','weekly','monthly')) - Tần suất gửi
- **filters** (JSON, Nullable) - Bộ lọc báo cáo
- **next_run_at** (TIMESTAMP, Nullable) - Lần chạy tiếp theo
- **is_active** (BOOLEAN, Default true) - Trạng thái kích hoạt
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `email` (index), `cadence` (index)

### report_templates
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **name** (VARCHAR(255)) - Tên template
- **description** (TEXT, Nullable) - Mô tả
- **config** (JSON, Nullable) - Cấu hình báo cáo
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `name` (unique)

### segments
- **id** (PK, BIGINT, Auto-increment) - Khóa chính
- **name** (VARCHAR(255)) - Tên phân khúc
- **filters** (JSON) - Điều kiện lọc
- **size** (INTEGER, Default 0) - Số lượng khách hàng
- **created_by** (FK to users.id, BIGINT, Nullable, ON DELETE NULL) - Người tạo
- **created_at** (TIMESTAMP) - Thời gian tạo
- **updated_at** (TIMESTAMP) - Thời gian cập nhật
- **Indexes**: `name` (unique)

## System Tables

### cache
- **key** (PK, VARCHAR)
- **value** (MEDIUMTEXT)
- **expiration** (INTEGER)

### cache_locks
- **key** (PK, VARCHAR)
- **owner** (VARCHAR)
- **expiration** (INTEGER)

### jobs
- **id** (PK, Auto-increment)
- **queue** (VARCHAR, Indexed)
- **payload** (LONGTEXT)
- **attempts** (UNSIGNED TINYINT)
- **reserved_at** (UNSIGNED INTEGER, Nullable)
- **available_at** (INTEGER)
- **created_at** (INTEGER)

### job_batches
- **id** (PK, VARCHAR)
- **name** (VARCHAR)
- **total_jobs** (INTEGER)
- **pending_jobs** (INTEGER)
- **failed_jobs** (INTEGER)
- **failed_job_ids** (LONGTEXT, Nullable)
- **options** (TEXT, Nullable)
- **cancelled_at** (INTEGER, Nullable)
- **created_at** (INTEGER)
- **finished_at** (INTEGER, Nullable)

### failed_jobs
- **id** (PK, Auto-increment)
- **uuid** (VARCHAR, Unique)
- **connection** (TEXT)
- **queue** (TEXT)
- **payload** (LONGTEXT)
- **exception** (LONGTEXT)
- **failed_at** (TIMESTAMP)

## Relationships Summary

1. **User Management**: users → bookings (1:N), users → sessions (1:N), users → segments (1:N)
2. **Movie System**: phim → showtimes (1:N), phim → phim_khuyen_mai (1:N)
3. **Promotion System**: khuyen_mai → phim_khuyen_mai (1:N)
4. **Theater & Showtime**: theaters → showtimes (1:N), showtimes → bookings (1:N)
5. **Employee Management**: employees → schedules (1:N)
6. **Admin Features**: Various admin tables for reporting and statistics

## Key Constraints

- All foreign key relationships use `ON DELETE CASCADE` where specified
- Email fields are unique across relevant tables
- Timestamp fields use Laravel's default timestamp format
- JSON fields store flexible configuration data for admin features
