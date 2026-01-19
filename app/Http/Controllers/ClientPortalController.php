<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // If user is admin, redirect to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Get client associated with user
        $client = $user->client;

        if (!$client) {
            return view('client.no-profile');
        }

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

        // Get total repairs count
        $totalRepairs = Repair::whereIn('car_id', $cars->pluck('id'))->count();

        return view('client.dashboard', compact('client', 'cars', 'selectedCar', 'repairs', 'totalRepairs'));
    }

    public function getCarInfoAndRepairs(Request $request)
    {
        $user = auth()->user();
        $client = $user->client;

        if (!$client) {
            return response()->json(['error' => 'No client profile'], 403);
        }

        $carId = $request->input('selectedCar');

        // Verify the car belongs to this client
        $car = Car::where('id', $carId)
            ->where('client_id', $client->id)
            ->first();

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $repairs = Repair::where('car_id', $car->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'car' => $car,
            'repair' => $repairs
        ]);
    }

    public function repairHistory()
    {
        $user = auth()->user();
        $client = $user->client;

        if (!$client) {
            return view('client.no-profile');
        }

        $carIds = $client->cars()->pluck('id');
        $repairs = Repair::with('car')
            ->whereIn('car_id', $carIds)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('client.repair-history', compact('client', 'repairs'));
    }
}
