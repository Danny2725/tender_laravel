<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Trang đăng nhập
    public function login()
    {
        return view('login', ['title' => 'Login']);
    }

    public function logout()
    {
        // Hủy session của người dùng
        Session::flush();

        // Chuyển hướng đến trang đăng nhập hoặc trang chủ
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    // Xử lý đăng nhập (dummy)
    public function authenticate(Request $request)
    {
        // Lấy thông tin từ form
        $role = $request->input('role');

        // Chuyển hướng đến trang thích hợp dựa trên vai trò
        if ($role == 'contractor') {
            return redirect()->route('tender.list_contractor');
        } elseif ($role == 'supplier') {
            return redirect()->route('tender.list_supplier');
        } else {
            return redirect()->back()->with('error', 'Invalid role selected');
        }
    }
}
