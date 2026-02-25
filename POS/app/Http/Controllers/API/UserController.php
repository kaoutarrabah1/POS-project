<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض جميع المستخدمين (للمدير فقط)
    public function index()
    {
        $users = User::withCount('orders', 'reservations')->get();
        return response()->json($users);
    }

    // عرض مستخدم واحد (للمدير فقط)
    public function show(User $user)
    {
        return response()->json($user->load(['orders', 'reservations']));
    }

    // إنشاء مستخدم جديد (للمدير فقط) - اختياري
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,manager,client',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? User::ROLE_CLIENT,
        ]);

        return response()->json($user, 201);
    }

    // تحديث مستخدم (للمدير فقط)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|in:admin,manager,client',
        ]);

        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return response()->json($user);
    }

    // تحديث الدور فقط (ميثود مساعدة)
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:admin,manager,client',
        ]);

        $user->update(['role' => $request->role]);
        return response()->json(['message' => 'Role mis à jour', 'user' => $user]);
    }

    // حذف مستخدم (للمدير فقط)
    public function destroy(User $user)
    {
        // منع حذف النفس (اختياري)
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Vous ne pouvez pas supprimer votre propre compte'], 400);
        }

        $user->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}