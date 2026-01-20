<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::role('admin')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Името е задължително!',
            'email.required' => 'Email е задължителен!',
            'email.email' => 'Въведете валиден email адрес!',
            'email.unique' => 'Този email вече съществува!',
            'password.required' => 'Паролата е задължителна!',
            'password.min' => 'Паролата трябва да е минимум 6 символа!',
            'password.confirmed' => 'Паролите не съвпадат!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect()->route('admin.users.index')->with('message', 'Администраторът е създаден успешно!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Prevent editing yourself through this interface
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Не можете да редактирате собствения си акаунт тук.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Името е задължително!',
            'email.required' => 'Email е задължителен!',
            'email.email' => 'Въведете валиден email адрес!',
            'email.unique' => 'Този email вече съществува!',
        ]);

        if ($request->filled('password')) {
            $validator->addRules([
                'password' => 'min:6|confirmed',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('message', 'Администраторът е редактиран успешно!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Не можете да изтриете собствения си акаунт!');
        }

        // Prevent deleting the last admin
        $adminCount = User::role('admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'Не можете да изтриете последния администратор!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'Администраторът е изтрит успешно!');
    }
}
