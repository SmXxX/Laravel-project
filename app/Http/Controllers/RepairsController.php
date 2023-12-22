<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairsController extends Controller
{
    // show all repairs
    public function index(){
        return view('repairs.index');
    }

    public function create(Client $client){
        // Retrieve only the cars of the client
        $cars = Car::where('client_id', $client->id)->get();
        return view('repairs.create', [
            'cars' => $cars,
            'client' => $client, // Pass the client data to the view
        ]);
    }
    

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'car_id' => 'required',
            'repair' => 'required',
            'part' => 'required',
            'kilometers' => 'required',
            'work_cost' => 'required',
            'part_cost' => 'required',
        ], [
            'car_id.required' => 'Избери кола!',
            'repair.required' => 'Извършен ремонт е задължителен!',
            'part.required' => 'Част е задължителна!',
            'kilometers.required' => 'Километри са задължителни!',
            'work_cost.required' => 'Цена труд е задължителна!',
            'part_cost.required' => 'Цена част е задължителна!',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only('car_id', 'repair', 'part', 'kilometers', 'work_cost', 'part_cost'));
        }
    
        $car = Car::findOrFail($request->car_id);
    
        Repair::create([
            'car_id' => $car->id,
            'repair' => $request->repair,
            'part' => $request->part,
            'kilometers' => $request->kilometers,
            'work_cost' => $request->work_cost,
            'part_cost' => $request->part_cost,
        ]);
    
        return redirect()->route('single', ['id' => $car->client_id])->with('message', 'Ремонтът е създаден успешно!');
    }
    
    public function edit($id){
        $getRepair = Repair::where('id',$id)->first();
        return view('repairs.edit',[
           'repair_car'=>$getRepair,
        ]);
    }

    public function update(Request $request, $id, $repairId){
        $validator = Validator::make($request->all(), [
            'repair'=>'required',
            'part'=>'required',
            'kilometers'=>'required',
            'work_cost'=>'required',
            'part_cost'=>'required',
            
        ], [
            'repair.required'=>'Извършен ремонт е задължителен!',
            'part.required'=>'Сменена част е задължителна!',
            'kilometers.required'=>'Километри са задължителни!',
            'work_cost.required'=>'Цена труд е задължителна!',
            'part_cost.required'=>'Цена част е задължителна!',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only('repair', 'part', 'kilometers', 'work_cost', 'part_cost'));
        }

        Repair::where('id',$id)->update([
            'repair'=>$request->repair,
            'part'=>$request->part,
            'kilometers'=>$request->kilometers,
            'work_cost'=>$request->work_cost,
            'part_cost'=>$request->part_cost,
        ]);

        $car = Repair::findOrFail($repairId)->car;
        $clientId = $car->client_id;
        return redirect()->route('single', ['id' => $clientId])->with('message','Ремонтът е редактиран успешно!');
    }
    public function destroy($id){
        $repair = Repair::findOrFail($id);
        // $clientId = $repair->car->client_id; // Assuming car relationship exists
        $repair->delete();
        return redirect()->back()->with('message', 'Ремонтът е изтрит успешно!');
    }    
}
