# NeoScreem UML - Use Case Diagram

## Use Case Diagram trong Mermaid

```mermaid
graph TD
    %% Actors
    User((User))
    Admin((Admin))
    Staff((Staff))
    
    %% System Boundary
    subgraph NeoScreem System
        %% User Use Cases
        UC1[Đăng ký tài khoản]
        UC2[Đăng nhập]
        UC3[Xem phim]
        UC4[Tìm kiếm phim]
        UC5[Xem lịch chiếu]
        UC6[Đặt vé]
        UC7[Thanh toán]
        UC8[Xem lịch sử đặt vé]
        UC9[Quản lý profile]
        UC10[Đánh giá phim]
        
        %% Staff Use Cases
        UC11[Quản lý suất chiếu]
        UC12[Xuất vé tại quầy]
        UC13[Xử lý thanh toán offline]
        UC14[Xem báo cáo ngày]
        
        %% Admin Use Cases
        UC15[Quản lý phim]
        UC16[Quản lý khuyến mãi]
        UC17[Quản lý rạp chiếu]
        UC18[Quản lý nhân viên]
        UC19[Quản lý lịch làm]
        UC20[Tạo báo cáo]
        UC21[Quản lý user]
        UC22[Xem thống kê]
        UC23[Quản lý phân khúc KH]
        UC24[Cấu hình hệ thống]
    end
    
    %% User Relationships
    User --> UC1
    User --> UC2
    User --> UC3
    User --> UC4
    User --> UC5
    User --> UC6
    User --> UC7
    User --> UC8
    User --> UC9
    User --> UC10
    
    %% Staff Relationships
    Staff --> UC2
    Staff --> UC3
    Staff --> UC5
    Staff --> UC11
    Staff --> UC12
    Staff --> UC13
    Staff --> UC14
    
    %% Admin Relationships
    Admin --> UC2
    Admin --> UC15
    Admin --> UC16
    Admin --> UC17
    Admin --> UC18
    Admin --> UC19
    Admin --> UC20
    Admin --> UC21
    Admin --> UC22
    Admin --> UC23
    Admin --> UC24
    
    %% Use Case Relationships
    UC6 --> UC5 : <<include>>
    UC7 --> UC6 : <<extend>>
    UC12 --> UC6 : <<extend>>
    UC13 --> UC7 : <<extend>>
    UC15 --> UC3 : <<extend>>
    UC16 --> UC6 : <<extend>>
    UC20 --> UC22 : <<include>>
```

## Mô Tả Chi Tiết Use Cases

### 1. **User Use Cases**

#### UC1: Đăng ký tài khoản
- **Actor**: User
- **Description**: User tạo tài khoản mới để sử dụng hệ thống
- **Preconditions**: User có email và số điện thoại hợp lệ
- **Postconditions**: Tạo thành công user mới trong database
- **Main Flow**:
  1. User nhập thông tin (name, email, password, phone)
  2. System validate thông tin
  3. System gửi verification email
  4. User xác thực email
  5. System activate tài khoản

#### UC2: Đăng nhập
- **Actors**: User, Staff, Admin
- **Description**: Xác thực身份 để truy cập hệ thống
- **Preconditions**: User đã có tài khoản hợp lệ
- **Postconditions**: User được cấp session/token
- **Main Flow**:
  1. User nhập email/password
  2. System authenticate credentials
  3. System tạo session
  4. Redirect đến dashboard tương ứng

#### UC6: Đặt vé
- **Actor**: User
- **Description**: User đặt vé xem phim online
- **Preconditions**: User đã đăng nhập, phim có suất chiếu
- **Postconditions**: Tạo booking record với trạng thái pending
- **Main Flow**:
  1. User chọn phim
  2. System hiển thị lịch chiếu
  3. User chọn suất chiếu và ghế
  4. System tính giá vé
  5. User xác nhận đặt vé
  6. System tạo booking pending

#### UC7: Thanh toán
- **Actor**: User
- **Description**: Thanh toán cho booking đã tạo
- **Preconditions**: Có booking pending
- **Postconditions**: Booking được confirm, tạo payment record
- **Main Flow**:
  1. User chọn phương thức thanh toán
  2. System redirect đến payment gateway
  3. User hoàn thành thanh toán
  4. System nhận confirmation
  5. System update booking status

### 2. **Staff Use Cases**

#### UC11: Quản lý suất chiếu
- **Actor**: Staff
- **Description**: Thêm/sửa/xóa suất chiếu phim
- **Preconditions**: Staff đã đăng nhập, có quyền quản lý
- **Postconditions**: Suất chiếu được cập nhật trong database
- **Main Flow**:
  1. Staff chọn phim và rạp
  2. Staff nhập thông tin suất chiếu
  3. System validate thông tin
  4. System cập nhật suất chiếu
  5. System gửi notification

#### UC12: Xuất vé tại quầy
- **Actor**: Staff
- **Description**: Tạo booking cho khách hàng tại quầy
- **Preconditions**: Customer có thông tin, suất chiếu còn chỗ
- **Postconditions**: Tạo booking confirmed, xuất vé giấy
- **Main Flow**:
  1. Staff nhập thông tin customer
  2. Staff chọn suất chiếu và ghế
  3. System tính giá vé
  4. Customer thanh toán
  5. System tạo booking và xuất vé

### 3. **Admin Use Cases**

#### UC15: Quản lý phim
- **Actor**: Admin
- **Description**: Thêm/sửa/xóa thông tin phim
- **Preconditions**: Admin đã đăng nhập
- **Postconditions**: Phim được cập nhật trong database
- **Main Flow**:
  1. Admin nhập thông tin phim
  2. System upload poster/trailer
  3. System validate thông tin
  4. System lưu phim vào database
  5. System cập nhật search index

#### UC18: Quản lý nhân viên
- **Actor**: Admin
- **Description**: Quản lý thông tin nhân viên
- **Preconditions**: Admin đã đăng nhập
- **Postconditions**: Nhân viên được cập nhật
- **Main Flow**:
  1. Admin nhập thông tin nhân viên
  2. System generate employee code
  3. System validate thông tin
  4. System tạo/cập nhật nhân viên
  5. System gửi welcome email

## Mối Quan Hệ Giữa Use Cases

### Include Relationships:
- **Đặt vé** includes **Xem lịch chiếu**: Phải xem lịch trước khi đặt
- **Tạo báo cáo** includes **Xem thống kê**: Báo cáo dựa trên thống kê

### Extend Relationships:
- **Thanh toán** extends **Đặt vé**: Tùy chọn sau khi đặt
- **Xuất vé tại quầy** extends **Đặt vé**: Alternative flow
- **Quản lý phim** extends **Xem phim**: Admin có thêm quyền
- **Quản lý khuyến mãi** extends **Đặt vé**: Áp dụng giảm giá

### Generalization:
- **Staff** is-a **User** với quyền mở rộng
- **Admin** is-a **User** với quyền tối đa

## Business Rules

1. **Authentication**: Tất cả actors phải đăng nhập trừ việc xem phim
2. **Authorization**: Mỗi actor có quyền truy cập tương ứng
3. **Payment**: Booking chỉ confirmed sau khi thanh toán thành công
4. **Seat Management**: Ghế không thể được đặt bởi nhiều user cùng lúc
5. **Showtime Constraints**: Không thể đặt vé cho suất chiếu đã hết hạn
6. **Data Validation**: Tất cả input phải được validate trước khi xử lý

## Non-Functional Requirements

1. **Performance**: Response time < 2 seconds cho các operations chính
2. **Security**: Password encryption, secure session management
3. **Usability**: Intuitive UI cho user, staff, admin
4. **Reliability**: 99.9% uptime cho booking system
5. **Scalability**: Support 1000+ concurrent users
