<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Car;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['cars', 'user'])
            ->orderBy('created_at', 'desc')
            ->filter(request(['search']))
            ->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Името е задължително!',
            'phone_number.required' => 'Телефонният номер е задължителен!',
            'phone_number.min' => 'Трябва да съдържа минимум 10 числа!',
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

        DB::beginTransaction();

        try {
            // Create user account for client
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign client role
            $user->assignRole('client');

            // Create client profile linked to user
            Client::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]);

            DB::commit();

            return redirect()->route('admin.clients.index')->with('message', 'Клиентът е създаден успешно!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Грешка при създаване на клиент: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Request $request, $id)
    {
        $client = Client::with(['cars', 'user'])->findOrFail($id);
        $cars = $client->cars()->orderBy('id', 'asc')->get();

        // Handle car selection from URL parameter
        $selectedCar = null;
        if ($request->has('car')) {
            $selectedCar = Car::where('id', $request->car)
                ->where('client_id', $client->id)
                ->first();
        }

        // Default to first car if no selection
        if (!$selectedCar) {
            $selectedCar = $cars->first();
        }

        $repairs = $selectedCar ? Repair::where('car_id', $selectedCar->id)->orderBy('created_at', 'desc')->get() : collect();

        return view('admin.clients.show', compact('client', 'cars', 'selectedCar', 'repairs'));
    }

    public function edit($id)
    {
        $client = Client::with('user')->findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::with('user')->findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|min:10',
        ];

        $messages = [
            'name.required' => 'Името е задължително!',
            'phone_number.required' => 'Телефонният номер е задължителен!',
            'phone_number.min' => 'Трябва да съдържа минимум 10 числа!',
        ];

        // If client has user account, validate email
        if ($client->user) {
            $rules['email'] = 'required|email|unique:users,email,' . $client->user->id;
            $messages['email.required'] = 'Email е задължителен!';
            $messages['email.email'] = 'Въведете валиден email адрес!';
            $messages['email.unique'] = 'Този email вече съществува!';

            if ($request->filled('password')) {
                $rules['password'] = 'min:6|confirmed';
                $messages['password.min'] = 'Паролата трябва да е минимум 6 символа!';
                $messages['password.confirmed'] = 'Паролите не съвпадат!';
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Update client
            $client->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]);

            // Update user if exists
            if ($client->user) {
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $client->user->update($userData);
            }

            DB::commit();

            return redirect()->route('admin.clients.index')->with('message', 'Клиентът е редактиран успешно!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Грешка при редактиране: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $client = Client::with('user')->findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete all repairs for client's cars
            $carIds = $client->cars()->pluck('id');
            Repair::whereIn('car_id', $carIds)->delete();

            // Delete all cars
            $client->cars()->delete();

            // Delete user account if exists
            if ($client->user) {
                $client->user->delete();
            }

            // Delete client
            $client->delete();

            DB::commit();

            return redirect()->route('admin.clients.index')->with('message', 'Клиентът е изтрит успешно!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Грешка при изтриване: ' . $e->getMessage());
        }
    }
}
