<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Các cột có thể ghi dữ liệu (fillable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 👈 Thêm dòng này để lưu role khi tạo user/admin
    ];

    /**
     * Các cột ẩn khi trả về JSON hoặc API.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Gửi mail reset mật khẩu.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Kiểm tra quyền user.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
