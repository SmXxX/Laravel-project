<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Repair;
use Illuminate\Http\Request;

class GetCarInfoAndRepairsController extends Controller
{
    public function CarInfoAndRepairs(Request $request){
        $carId = $request->selectedCar;
        // $clientId = $request->clientId;
        $repairId = $request->repairId;
        
        // Fetch car info
        $car = Car::where('id', $carId)->first();
    
        // Fetch repair info (replace with your actual code to fetch repair data)
        $repair = Repair::where('id', $repairId)->first(); 
    
        if ($car && $repair){
            return response()->json(['status' => true, 'car' => $car, 'repair' => $repair], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Not Found!'], 404);
        }
    }
    
}
