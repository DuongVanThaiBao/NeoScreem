<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    // Cập nhật admin
    $admin = App\Models\User::find(1);
    if ($admin) {
        $admin->update([
            'name' => 'Administrator',
            'email' => 'admin@neoscreem.com',
            'role' => 'admin',
            'password' => bcrypt('admin123')
        ]);
        echo "Admin updated successfully\n";
    } else {
        echo "Admin not found\n";
    }

    // Xóa user test cũ
    $oldUser = App\Models\User::where('email', 'test@example.com')->first();
    if ($oldUser) {
        $oldUser->delete();
        echo "Old test user deleted\n";
    }

    // Tạo user mới
    $newUser = App\Models\User::create([
        'name' => 'Regular User',
        'email' => 'user@neoscreem.com',
        'password' => bcrypt('user123'),
        'role' => 'user'
    ]);

    echo "New user created with ID: " . $newUser->id . "\n";

    // Hiển thị tất cả users
    $users = App\Models\User::all();
    echo "\nCurrent users in database:\n";
    foreach ($users as $user) {
        echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
    }

    echo "\nSetup completed successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
