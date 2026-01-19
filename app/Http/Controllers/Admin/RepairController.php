<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairController extends Controller
{
    public function index()
    {
        $repairs = Repair::with(['car', 'car.client'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.repairs.index', compact('repairs'));
    }

    public function create(Request $request)
    {
        $clients = Client::with('cars')->orderBy('name', 'asc')->get();
        $selectedClient = $request->client_id ? Client::find($request->client_id) : null;
        $selectedCar = $request->car_id ? Car::find($request->car_id) : null;

        return view('admin.repairs.create', compact('clients', 'selectedClient', 'selectedCar'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'repair' => 'required|string|max:500',
            'part' => 'nullable|string|max:500',
            'kilometers' => 'nullable|integer|min:0',
            'work_cost' => 'nullable|numeric|min:0',
            'part_cost' => 'nullable|numeric|min:0',
        ], [
            'car_id.required' => 'Моля изберете кола!',
            'car_id.exists' => 'Избраната кола не съществува!',
            'repair.required' => 'Описанието на ремонта е задължително!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Repair::create([
            'car_id' => $request->car_id,
            'repair' => $request->repair,
            'part' => $request->part,
            'kilometers' => $request->kilometers ?? 0,
            'work_cost' => $request->work_cost ?? 0,
            'part_cost' => $request->part_cost ?? 0,
        ]);

        return redirect()->route('admin.repairs.index')->with('message', 'Ремонтът е добавен успешно!');
    }

    public function edit($id)
    {
        $repair = Repair::with(['car', 'car.client'])->findOrFail($id);
        $clients = Client::with('cars')->orderBy('name', 'asc')->get();

        return view('admin.repairs.edit', compact('repair', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'repair' => 'required|string|max:500',
            'part' => 'nullable|string|max:500',
            'kilometers' => 'nullable|integer|min:0',
            'work_cost' => 'nullable|numeric|min:0',
            'part_cost' => 'nullable|numeric|min:0',
        ], [
            'car_id.required' => 'Моля изберете кола!',
            'repair.required' => 'Описанието на ремонта е задължително!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $repair->update([
            'car_id' => $request->car_id,
            'repair' => $request->repair,
            'part' => $request->part,
            'kilometers' => $request->kilometers ?? 0,
            'work_cost' => $request->work_cost ?? 0,
            'part_cost' => $request->part_cost ?? 0,
        ]);

        return redirect()->route('admin.repairs.index')->with('message', 'Ремонтът е редактиран успешно!');
    }

    public function destroy($id)
    {
        $repair = Repair::findOrFail($id);
        $repair->delete();

        return redirect()->route('admin.repairs.index')->with('message', 'Ремонтът е изтрит успешно!');
    }

    public function getCarsByClient($clientId)
    {
        $cars = Car::where('client_id', $clientId)->get();
        return response()->json($cars);
    }
}
