<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $role = $request->query('role');
        $status = $request->query('status');

        $users = User::query()
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%");
                });
            })
            ->when($role && Schema::hasColumn('users','role'), function ($qb) use ($role) {
                $qb->where('role', $role);
            })
            ->when($status && Schema::hasColumn('users','banned_at'), function ($qb) use ($status) {
                if ($status === 'active') {
                    $qb->whereNull('banned_at');
                } elseif ($status === 'banned') {
                    $qb->whereNotNull('banned_at');
                }
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users', compact('users', 'q', 'role', 'status'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,banned',
        ]);

        // Basic updates
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Optional columns
        if (isset($data['role']) && \Illuminate\Support\Facades\Schema::hasColumn('users','role')) {
            $user->role = $data['role'];
        }
        if (isset($data['status']) && \Illuminate\Support\Facades\Schema::hasColumn('users','banned_at')) {
            $user->banned_at = $data['status'] === 'banned' ? now() : null;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Vô hiệu hóa thay vì xóa cứng nếu có cột banned_at
        if (\Illuminate\Support\Facades\Schema::hasColumn('users','banned_at')) {
            $user->banned_at = now();
            $user->save();
        } else {
            $user->delete();
        }
        return redirect()->route('admin.users.index')->with('success', 'Đã xóa/vô hiệu hóa người dùng');
    }
}
