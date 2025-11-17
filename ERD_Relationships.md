# NeoScreem ERD - Giải Thích Chi Tiết Mối Quan Hệ

## Tổng Quan Hệ Thống

NeoScreem là hệ thống quản lý rạp chiếu phim tích hợp đầy đủ các module từ quản lý phim, đặt vé, đến quản trị nhân viên và báo cáo. Hệ thống được thiết kế với kiến trúc relational database chuẩn hóa.

---

## 1. Module Quản Lý Người Dùng (Authentication)

### users → sessions (1:N)
- **Mối quan hệ**: Một người dùng có thể có nhiều session đăng nhập
- **Đặc điểm**: 
  - `user_id` trong `sessions` có thể NULL (session guest)
  - Khi user bị xóa, session vẫn tồn tại (không cascade delete)
- **Use case**: User đăng nhập trên nhiều thiết bị cùng lúc

### users → password_reset_tokens (1:N)
- **Mối quan hệ**: Một user có thể có nhiều token reset mật khẩu
- **Đặc điểm**: Email là khóa chính trong `password_reset_tokens`
- **Use case**: User yêu cầu reset password nhiều lần

---

## 2. Module Quản Lý Phim & Khuyến Mãi

### phim → showtimes (1:N)
- **Mối quan hệ**: Một phim có nhiều suất chiếu khác nhau
- **Đặc điểm**: 
  - `phim_id` bắt buộc trong `showtimes`
  - Khi phim bị xóa, tất cả suất chiếu liên quan cũng bị xóa
- **Use case**: Phim "Avengers" chiếu vào nhiều thời điểm khác nhau

### khuyen_mai → phim_khuyen_mai → phim (N:M)
- **Mối quan hệ**: Nhiều-nhiều qua bảng junction
- **Đặc điểm**:
  - Composite Primary Key (`phim_id`, `khuyen_mai_id`)
  - Cascade delete từ cả hai phía
- **Use case**: 
  - Một khuyến mãi áp dụng cho nhiều phim
  - Một phim có thể có nhiều khuyến mãi

### theaters → showtimes (1:N)
- **Mối quan hệ**: Một rạp có nhiều suất chiếu
- **Đặc điểm**: `theater_id` có thể NULL (suất chiếu online/virtual)
- **Use case**: Rạp CGV có nhiều phòng chiếu với suất chiếu khác nhau

---

## 3. Module Đặt Vé (Booking System)

### users → bookings (1:N)
- **Mối quan hệ**: Một user có thể đặt nhiều vé
- **Đặc điểm**: Cascade delete - khi user bị xóa, booking cũng bị xóa
- **Use case**: User đặt vé cho nhiều phim khác nhau

### showtimes → bookings (1:N)
- **Mối quan hệ**: Một suất chiếu có nhiều đặt vé
- **Đặc điểm**: Cascade delete - khi suất chiếu bị hủy, booking bị xóa
- **Use case**: Suất chiếu 19:00 có 50 người đặt vé

### Flow hoàn chỉnh của việc đặt vé:
```
users → bookings → showtimes → phim
                ↓
            theaters
```

---

## 4. Module Quản Trị (Admin Management)

### employees → schedules (1:N)
- **Mối quan hệ**: Một nhân viên có nhiều lịch làm việc
- **Đặc điểm**: Cascade delete - khi nhân viên nghỉ việc, lịch làm bị xóa
- **Use case**: Nhân viên A có lịch làm từ Thứ 2-Thứ 6

### users → segments (1:N)
- **Mối quan hệ**: Một admin có thể tạo nhiều phân khúc khách hàng
- **Đặc điểm**: `created_by` NULL ON DELETE - khi admin bị xóa, phân khúc vẫn tồn tại
- **Use case**: Admin tạo phân khúc "Khách hàng VIP", "Khách hàng mới"

### Bảng báo cáo & thống kê:
- `statistics`: Lưu trữ số liệu real-time
- `report_schedules`: Lịch gửi báo cáo tự động
- `report_templates`: Mẫu báo cáo tùy chỉnh

---

## 5. Module System (Laravel Framework)

### Laravel Queue System:
- `jobs`: Queue jobs pending
- `job_batches`: Batch job tracking
- `failed_jobs`: Failed job logging

### Laravel Cache System:
- `cache`: Application cache
- `cache_locks`: Cache locking mechanism

---

## 6. Ràng Buộc Dữ Liệu Quan Trọng

### Cascade Delete Rules:
1. **users → bookings**: Xóa user → xóa bookings
2. **showtimes → bookings**: Xóa suất chiếu → xóa bookings  
3. **phim → phim_khuyen_mai**: Xóa phim → xóa liên kết KM
4. **khuyen_mai → phim_khuyen_mai**: Xóa KM → xóa liên kết phim
5. **employees → schedules**: Xóa nhân viên → xóa lịch làm

### Unique Constraints:
1. **users.email**: Email duy nhất cho mỗi user
2. **employees.code**: Mã nhân viên duy nhất
3. **report_templates.name**: Tên template báo cáo duy nhất
4. **segments.name**: Tên phân khúc duy nhất
5. **failed_jobs.uuid**: UUID job lỗi duy nhất

### Check Constraints:
1. **khuyen_mai.phan_tram_giam_gia**: Phải nằm trong khoảng 0-100%

---

## 7. Indexes Tối Ưu Hiệu Năng

### Primary Indexes:
- Tất cả các cột `id` đều được index tự động

### Foreign Key Indexes:
- `sessions.user_id`: Tìm session của user nhanh
- `bookings.user_id`, `bookings.showtime_id`: Query booking hiệu quả
- `showtimes.phim_id`, `showtimes.theater_id`: Tìm suất chiếu theo phim/rạp
- `schedules.employee_id`: Query lịch làm nhân viên

### Unique Indexes:
- `users.email`: Đăng nhập/đăng ký nhanh
- `employees.code`: Tìm nhân viên theo mã

### Additional Indexes:
- `phim.ten_phim`, `phim.the_loai`: Tìm kiếm phim
- `showtimes.ngay_chieu`: Lọc suất chiếu theo ngày
- `bookings.booking_status`: Lọc booking theo trạng thái

---

## 8. Flow Dữ Liệu Thực Tế

### Flow đặt vé phim:
```
1. User đăng nhập → users
2. Xem phim → phim
3. Chọn suất chiếu → showtimes (join theaters)
4. Đặt vé → bookings
5. Áp dụng khuyến mãi → phim_khuyen_mai → khuyen_mai
```

### Flow quản lý nhân viên:
```
1. Admin tạo nhân viên → employees
2. Tạo lịch làm → schedules
3. Theo dõi thống kê → statistics
4. Xuất báo cáo → report_templates → report_schedules
```

### Flow quản lý khuyến mãi:
```
1. Admin tạo khuyến mãi → khuyen_mai
2. Gán cho phim cụ thể → phim_khuyen_mai
3. User đặt vé được giảm giá → bookings
```

---

## 9. Lưu Ý Quan Trọng

### Performance Considerations:
1. **Soft Delete**: Nên cân nhắc soft delete cho `users`, `phim` để giữ dữ liệu lịch sử
2. **Partitioning**: `bookings` có thể partition theo tháng nếu dữ liệu lớn
3. **Archiving**: `sessions` cũ nên được archive định kỳ

### Security Considerations:
1. **PII Data**: `users.email`, `users.phone` cần được mã hóa
2. **Audit Trail**: Nên thêm `created_by`, `updated_by` cho các bảng quan trọng
3. **Row Level Security**: Restrict access theo `user_id` cho `bookings`

### Scalability Considerations:
1. **Read Replicas**: Bảng `phim`, `showtimes` phù hợp cho read replicas
2. **Sharding**: `bookings` có thể sharding theo `user_id`
3. **Caching**: `phim`, `khuyen_mai` nên được cache aggressively

---

## 10. Tóm Tắt Kiến Trúc

Hệ thống NeoScreem được thiết kế với:
- **15+ tables** bao phủ đầy đủ business requirements
- **Normalization** 3NF để tránh data redundancy
- **Referential integrity** với proper foreign key constraints
- **Optimized indexes** cho các query patterns phổ biến
- **Scalable architecture** sẵn sàng cho growth trong tương lai
