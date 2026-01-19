<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('client')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        $clients = Client::orderBy('name', 'asc')->get();
        return view('admin.cars.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'plate' => 'required|string|max:20',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'engine' => 'nullable|string|max:50',
            'hp' => 'nullable|integer|min:1',
            'fuel' => 'nullable|string|max:50',
            'vin_num' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|url',
        ], [
            'client_id.required' => 'Моля изберете клиент!',
            'client_id.exists' => 'Избраният клиент не съществува!',
            'plate.required' => 'Регистрационният номер е задължителен!',
            'brand.required' => 'Марката е задължителна!',
            'model.required' => 'Моделът е задължителен!',
            'year.required' => 'Годината е задължителна!',
            'year.integer' => 'Годината трябва да е число!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hp = $request->hp ?? 0;
        $kw = intval($hp * 0.7457);

        Car::create([
            'client_id' => $request->client_id,
            'plate' => $request->plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'engine' => $request->engine,
            'hp' => $hp,
            'kw' => $kw,
            'fuel' => $request->fuel,
            'vin_num' => $request->vin_num,
            'color' => $request->color,
            'additional_info' => $request->additional_info,
            'image' => $request->image,
        ]);

        return redirect()->route('admin.cars.index')->with('message', 'Колата е добавена успешно!');
    }

    public function show($id)
    {
        $car = Car::with(['client', 'repairs'])->findOrFail($id);
        $repairs = Repair::where('car_id', $car->id)->orderBy('created_at', 'desc')->get();

        return view('admin.cars.show', compact('car', 'repairs'));
    }

    public function edit($id)
    {
        $car = Car::with('client')->findOrFail($id);
        $clients = Client::orderBy('name', 'asc')->get();

        return view('admin.cars.edit', compact('car', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'plate' => 'required|string|max:20',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'engine' => 'nullable|string|max:50',
            'hp' => 'nullable|integer|min:1',
            'fuel' => 'nullable|string|max:50',
            'vin_num' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|url',
        ], [
            'client_id.required' => 'Моля изберете клиент!',
            'plate.required' => 'Регистрационният номер е задължителен!',
            'brand.required' => 'Марката е задължителна!',
            'model.required' => 'Моделът е задължителен!',
            'year.required' => 'Годината е задължителна!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hp = $request->hp ?? 0;
        $kw = intval($hp * 0.7457);

        $car->update([
            'client_id' => $request->client_id,
            'plate' => $request->plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'engine' => $request->engine,
            'hp' => $hp,
            'kw' => $kw,
            'fuel' => $request->fuel,
            'vin_num' => $request->vin_num,
            'color' => $request->color,
            'additional_info' => $request->additional_info,
            'image' => $request->image,
        ]);

        return redirect()->route('admin.cars.index')->with('message', 'Колата е редактирана успешно!');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // Delete all repairs for this car
        Repair::where('car_id', $car->id)->delete();

        // Delete car
        $car->delete();

        return redirect()->route('admin.cars.index')->with('message', 'Колата е изтрита успешно!');
    }
}
