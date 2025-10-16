<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();

        // Search by name or email
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if (request('role') !== null && request('role') !== '') {
            $query->where('role', request('role'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = bcrypt($validated['password']);
            $validated['email_verified_at'] = now();

            User::create($validated);

            return redirect()->route('admin.users')->with('success', 'Tạo người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo người dùng!');
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            // Update password only if provided
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('admin.users')->with('success', 'Cập nhật người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng!');
        }
    }

    public function destroy(User $user)
    {
        try {
            // Prevent deleting admin users
            if ($user->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản Admin!'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa người dùng thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa người dùng!'
            ], 500);
        }
    }
}
