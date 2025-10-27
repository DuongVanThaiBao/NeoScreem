<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to NeoScreem</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Xin chào, {{ $username }} 👋</h2>
    <p>Chào mừng bạn đến với <strong>NeoScreem</strong> – nơi điện ảnh sống dậy qua từng khung hình.</p>

    <p>
        <img src="{{ $message->embed($imagePath) }}" 
             alt="NeoScreem Banner" 
             style="width:100%;max-width:500px;border-radius:10px;">
    </p>

    <p>Chúc bạn có những phút giây trải nghiệm tuyệt vời!</p>
    <p>– Đội ngũ NeoScreem 🎥</p>
</body>
</html>
