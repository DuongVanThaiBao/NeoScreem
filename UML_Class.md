# NeoScreem UML - Class Diagram

## Class Diagram trong Mermaid

```mermaid
classDiagram
    %% User Management Classes
    class User {
        -id: bigint
        -name: string
        -email: string
        -password_hash: string
        -phone: string
        -avatar: string
        -role: enum
        -status: enum
        -email_verified_at: datetime
        -created_at: datetime
        -updated_at: datetime
        
        +login(email, password): boolean
        +register(userData): User
        +updateProfile(userData): boolean
        +changePassword(oldPass, newPass): boolean
        +resetPassword(email): boolean
        +verifyEmail(token): boolean
        +getBookings(): Booking[]
        +getPaymentMethods(): PaymentMethod[]
    }
    
    class Staff {
        -employee_code: string
        -position: string
        -salary: decimal
        -hire_date: date
        -work_schedule: json
        
        +checkIn(): Attendance
        +checkOut(): Attendance
        +getSchedule(): WorkSchedule[]
        +processOfflinePayment(bookingId): Payment
        +manageShowtimes(): Showtime[]
        +generateDailyReport(): Report
    }
    
    class Admin {
        -permissions: json
        
        +manageUsers(): User[]
        +manageMovies(): Movie[]
        +manageTheaters(): Theater[]
        +managePromotions(): Promotion[]
        +generateReports(): Report[]
        +configureSystem(): SystemConfig
    }
    
    %% Movie Management Classes
    class Movie {
        -id: bigint
        -title: string
        -description: text
        -duration: int
        -release_date: date
        -poster_url: string
        -trailer_url: string
        -rating: decimal
        -status: enum
        -created_at: datetime
        -updated_at: datetime
        
        +addShowtime(theaterId, startTime): Showtime
        +removeShowtime(showtimeId): boolean
        +getActiveShowtimes(): Showtime[]
        +updateRating(): decimal
        +checkAvailability(showtimeId): Seat[]
        +applyPromotion(promotionId): void
    }
    
    class Genre {
        -id: bigint
        -name: string
        -description: string
        
        +getMovies(): Movie[]
        +addMovie(movieId): void
        +removeMovie(movieId): void
    }
    
    class Actor {
        -id: bigint
        -name: string
        -bio: text
        -photo_url: string
        -birth_date: date
        
        +getMovies(): Movie[]
        +addMovie(movieId, role): void
        +removeMovie(movieId): void
    }
    
    %% Theater Management Classes
    class Theater {
        -id: bigint
        -name: string
        -address: string
        -phone: string
        -total_screens: int
        -status: enum
        
        +getScreens(): Screen[]
        +addScreen(screenData): Screen
        +updateScreen(screenId, data): boolean
        +removeScreen(screenId): boolean
        +getShowtimes(): Showtime[]
    }
    
    class Screen {
        -id: bigint
        -theater_id: bigint
        -name: string
        -capacity: int
        -screen_type: enum
        -seat_layout: json
        
        +getSeats(): Seat[]
        +updateSeatLayout(layout): boolean
        +getAvailableSeats(showtimeId): Seat[]
        +blockSeats(seatIds): void
        +releaseSeats(seatIds): void
    }
    
    class Seat {
        -id: bigint
        -screen_id: bigint
        -row: string
        -number: int
        -type: enum
        -status: enum
        
        +isAvailable(showtimeId): boolean
        +block(showtimeId): boolean
        +release(showtimeId): boolean
        +getPrice(showtimeId): decimal
    }
    
    %% Booking Management Classes
    class Showtime {
        -id: bigint
        -movie_id: bigint
        -screen_id: bigint
        -start_time: datetime
        -end_time: datetime
        -base_price: decimal
        -status: enum
        
        +getAvailableSeats(): Seat[]
        +blockSeats(seatIds): boolean
        +calculatePrice(seatIds): decimal
        +applyPromotion(promotionId): decimal
        +checkBookingConflict(seatIds): boolean
        +updateStatus(status): void
    }
    
    class Booking {
        -id: bigint
        -user_id: bigint
        -showtime_id: bigint
        -booking_code: string
        -total_amount: decimal
        -discount_amount: decimal
        -final_amount: decimal
        -status: enum
        -payment_status: enum
        -created_at: datetime
        -updated_at: datetime
        
        +addSeats(seatIds): BookingSeat[]
        +removeSeats(seatIds): boolean
        +calculateTotal(): decimal
        +applyPromotion(promotionCode): boolean
        +confirmBooking(): void
        +cancelBooking(): boolean
        +generateQRCode(): string
        +sendConfirmationEmail(): void
    }
    
    class BookingSeat {
        -id: bigint
        -booking_id: bigint
        -seat_id: bigint
        -price: decimal
        -status: enum
        
        +getSeat(): Seat
        +updatePrice(newPrice): void
        +cancel(): void
    }
    
    %% Payment Management Classes
    class Payment {
        -id: bigint
        -booking_id: bigint
        -payment_method_id: bigint
        -amount: decimal
        -transaction_id: string
        -status: enum
        -paid_at: datetime
        
        +processPayment(): boolean
        +refund(): boolean
        +generateReceipt(): string
        +updateStatus(status): void
    }
    
    class PaymentMethod {
        -id: bigint
        -user_id: bigint
        -type: enum
        -provider: string
        -account_number: string
        -is_default: boolean
        -status: enum
        
        +validate(): boolean
        +setDefault(): void
        +remove(): boolean
        +charge(amount): Payment
    }
    
    class Promotion {
        -id: bigint
        -code: string
        -name: string
        -description: text
        -discount_type: enum
        -discount_value: decimal
        -min_amount: decimal
        -max_discount: decimal
        -start_date: datetime
        -end_date: datetime
        -usage_limit: int
        -used_count: int
        -status: enum
        
        +isValid(): boolean
        +applyToAmount(amount): decimal
        +incrementUsage(): void
        +checkEligibility(userId): boolean
        +expire(): void
    }
    
    %% Review Management Classes
    class Review {
        -id: bigint
        -user_id: bigint
        -movie_id: bigint
        -rating: int
        -comment: text
        -status: enum
        -created_at: datetime
        -updated_at: datetime
        
        +approve(): void
        +reject(): void
        +updateMovieRating(): void
        +report(): void
    }
    
    %% Report Classes
    class Report {
        -id: bigint
        -type: enum
        -title: string
        -data: json
        -generated_by: bigint
        -generated_at: datetime
        -period: string
        
        +generateDailyReport(): json
        +generateMonthlyReport(): json
        +generateRevenueReport(): json
        +generateAttendanceReport(): json
        +exportToPDF(): string
        +exportToExcel(): string
    }
    
    %% Relationships
    User <|-- Staff : inherits
    Staff <|-- Admin : inherits
    
    User ||--o{ Booking : creates
    User ||--o{ PaymentMethod : owns
    User ||--o{ Review : writes
    
    Movie ||--o{ Showtime : has
    Movie ||--o{ Genre : belongs_to
    Movie ||--o{ Actor : has
    Movie ||--o{ Review : receives
    
    Theater ||--o{ Screen : contains
    Screen ||--o{ Seat : has
    Screen ||--o{ Showtime : hosts
    
    Showtime ||--o{ Booking : enables
    Booking ||--o{ BookingSeat : contains
    BookingSeat ||--|| Seat : references
    
    Booking ||--|| Payment : requires
    Payment ||--|| PaymentMethod : uses
    
    Booking ||--o{ Promotion : applies
    Promotion ||--o{ Booking : applied_to
    
    Staff ||--o{ Report : generates
    Admin ||--o{ Report : generates
```

## Chi Tiết Classes và Relationships

### 1. **User Management Hierarchy**

#### **User Class** (Base Class)
- **Purpose**: Quản lý thông tin cơ bản của tất cả users
- **Key Methods**: Authentication, profile management, password reset
- **Business Rules**: 
  - Email must be unique
  - Password minimum 8 characters
  - Account must be verified before booking

#### **Staff Class** (Extends User)
- **Purpose**: Quản lý nhân viên rạp chiếu
- **Additional Attributes**: Employee code, position, salary, work schedule
- **Key Methods**: Check-in/out, manage showtimes, process offline payments
- **Business Rules**: 
  - Must have valid work schedule
  - Can only manage assigned theaters

#### **Admin Class** (Extends Staff)
- **Purpose**: Quản lý hệ thống toàn diện
- **Additional Attributes**: Permissions JSON
- **Key Methods**: Full CRUD operations, system configuration
- **Business Rules**: 
  - Can manage all theaters
  - Can access all reports

### 2. **Movie Management System**

#### **Movie Class**
- **Purpose**: Central entity for movie information
- **Key Methods**: Showtime management, rating calculation
- **Relationships**: 
  - Has many Showtimes
  - Belongs to many Genres
  - Has many Actors
  - Has many Reviews
- **Business Rules**: 
  - Cannot delete movie with active bookings
  - Rating updates automatically from reviews

#### **Genre & Actor Classes**
- **Purpose**: Categorization and cast management
- **Relationship Type**: Many-to-many with Movie
- **Key Methods**: Movie association management

### 3. **Theater Management**

#### **Theater Class**
- **Purpose**: Physical cinema location
- **Key Methods**: Screen management, showtime coordination
- **Business Rules**: 
  - Must have at least 1 screen
  - Cannot delete theater with active bookings

#### **Screen & Seat Classes**
- **Purpose**: Individual screening room and seating
- **Key Methods**: 
  - Seat availability checking
  - Dynamic pricing based on seat type
  - Block/release operations
- **Business Rules**: 
  - Seat layout must be valid
  - Cannot book same seat multiple times

### 4. **Booking System**

#### **Showtime Class**
- **Purpose**: Specific movie screening instance
- **Key Methods**: 
  - Real-time seat availability
  - Price calculation with promotions
  - Conflict detection
- **Business Rules**: 
  - Cannot overlap showtimes in same screen
  - Must allow 30min cleaning time between shows

#### **Booking Class**
- **Purpose**: Customer booking transaction
- **Key Methods**: 
  - Multi-seat booking
  - Promotion application
  - QR code generation
  - Email notifications
- **Business Rules**: 
  - 15-minute booking timeout
  - Cannot modify confirmed booking
  - Cancellation rules apply

#### **BookingSeat Class** (Join Table)
- **Purpose**: Link booking with specific seats
- **Key Methods**: Price management, status tracking
- **Business Rules**: 
  - Price locked at booking time
  - Cannot change seats after confirmation

### 5. **Payment System**

#### **Payment Class**
- **Purpose**: Transaction processing
- **Key Methods**: 
  - Multiple payment gateway integration
  - Refund processing
  - Receipt generation
- **Business Rules**: 
  - Payment timeout: 10 minutes
  - Auto-cancel on payment failure

#### **PaymentMethod Class**
- **Purpose**: Customer payment options
- **Key Methods**: Validation, default setting
- **Business Rules**: 
  - Must validate before first use
  - Can have multiple methods per user

### 6. **Promotion System**

#### **Promotion Class**
- **Purpose**: Discount and offer management
- **Key Methods**: 
  - Validation logic
  - Usage tracking
  - Eligibility checking
- **Business Rules**: 
  - Cannot stack promotions
  - Usage limits enforced
  - Date-based validity

### 7. **Review System**

#### **Review Class**
- **Purpose**: Customer feedback
- **Key Methods**: 
  - Approval workflow
  - Rating calculation
  - Content moderation
- **Business Rules**: 
  - Must have attended movie to review
  - One review per movie per user
  - Automatic rating updates

### 8. **Reporting System**

#### **Report Class**
- **Purpose**: Business intelligence
- **Key Methods**: 
  - Multiple report types
  - Export capabilities
  - Scheduled generation
- **Business Rules**: 
  - Role-based access
  - Data retention policies

## Design Patterns Applied

### 1. **Strategy Pattern**
- **Payment Processing**: Different payment gateways (Credit Card, Bank Transfer, E-wallet)
- **Promotion Calculation**: Different discount types (Percentage, Fixed Amount, Buy X Get Y)

### 2. **Factory Pattern**
- **Report Generation**: Different report types use same interface
- **Notification System**: Email, SMS, Push notifications

### 3. **Observer Pattern**
- **Booking Status Changes**: Notify users, update seat availability
- **Movie Rating Updates**: Recalculate when new reviews added

### 4. **Repository Pattern**
- **Data Access**: Abstract database operations
- **Testing**: Easy to mock repositories

### 5. **Decorator Pattern**
- **Seat Pricing**: Base price + weekend surcharge + premium seat surcharge
- **Booking Features**: Base booking + insurance + food combo

## SOLID Principles Implementation

### **Single Responsibility Principle**
- Each class has one reason to change
- Example: `Payment` only handles payment logic, not booking logic

### **Open/Closed Principle**
- Open for extension, closed for modification
- Example: New payment methods can be added without changing existing code

### **Liskov Substitution Principle**
- Subclasses can replace parent classes
- Example: `Staff` and `Admin` can be used wherever `User` is expected

### **Interface Segregation Principle**
- Clients don't depend on unused interfaces
- Example: Payment interfaces separated by method type

### **Dependency Inversion Principle**
- Depend on abstractions, not concretions
- Example: Services depend on repository interfaces, not concrete implementations
