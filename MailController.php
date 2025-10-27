<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class MailController extends Controller
{
    public function sendMail()
    {
        $username = 'Duong Thai Bao';

        // Đường dẫn tới ảnh trong public/images/
        $inlineImage = public_path('images/banner.jpg');      // ảnh hiển thị trong nội dung
        $attachment = public_path('images/logo.jpg');         // ảnh đính kèm

        Mail::to('example@gmail.com')->send(new WelcomeMail($username, $inlineImage, $attachment));

        return "📩 Email đã được gửi thành công!";
    }
}
