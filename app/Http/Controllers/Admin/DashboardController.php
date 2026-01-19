<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Car;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $totalCars = Car::count();
        $totalRepairs = Repair::count();

        $recentClients = Client::with('cars')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentRepairs = Repair::with('car')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalClients',
            'totalCars',
            'totalRepairs',
            'recentClients',
            'recentRepairs'
        ));
    }

    public function clients(Request $request)
    {
        $clients = Client::with(['cars', 'user'])
            ->orderBy('created_at', 'desc')
            ->filter(request(['search']))
            ->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function showClient($id)
    {
        $client = Client::with(['cars', 'user'])->findOrFail($id);
        $cars = $client->cars()->orderBy('id', 'asc')->get();
        $selectedCar = $cars->first();
        $repairs = $selectedCar ? Repair::where('car_id', $selectedCar->id)->orderBy('created_at', 'desc')->get() : collect();

        return view('admin.clients.show', compact('client', 'cars', 'selectedCar', 'repairs'));
    }

    public function allCars(Request $request)
    {
        $cars = Car::with(['client'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    public function allRepairs(Request $request)
    {
        $repairs = Repair::with(['car', 'car.client'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.repairs.index', compact('repairs'));
    }
}
