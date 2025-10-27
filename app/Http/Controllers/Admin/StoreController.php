<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display the stores management page
     */
    public function index()
    {
        // Sample store data - in real app, this would come from database
        $store = [
            'id' => 1,
            'name' => 'NeoScreem Cinema',
            'address' => '123 Đường Nguyễn Huệ, Quận 1, TP.HCM',
            'phone' => '028 1234 5678',
            'opening_hours' => '8:00 - 23:00 (Hàng ngày)',
            'description' => 'Rạp chiếu phim hiện đại với công nghệ IMAX và Dolby Atmos. Phục vụ khách hàng với chất lượng tốt nhất.',
            'email' => 'info@neoscreem.com',
            'website' => 'www.neoscreem.com',
            'capacity' => 500,
            'screens' => 8
        ];

        return view('admin.stores', compact('store'));
    }

    /**
     * Update store information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'opening_hours' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'website' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'screens' => 'required|integer|min:1'
        ]);

        // In real app, this would update the database
        // For now, we'll just return success message
        
        return redirect()->route('admin.stores')->with('success', 'Thông tin cửa hàng đã được cập nhật thành công!');
    }
}
