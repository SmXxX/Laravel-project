<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairsController extends Controller
{
    // show all repairs
    public function index(){
        return view('repairs.index');
    }

    public function create(){
        $cars = Car::all();
        return view('repairs.create',[
            'cars'=>$cars,
        ]);
    }

    public function store(Request $request){
        //  dd($request->all());
        $validator = Validator::make($request->all(), [
            'car_id'=>'required',
            'repair'=>'required',
            'part'=>'required',
            'kilometers'=>'required',
            'work_cost'=>'required',
            'part_cost'=>'required',
            
        ], [
            'car_id.required'=>'Избери кола!',
            'repair.required'=>'Извършен ремонт е задължителен!',
            'part.required'=>'Част е задължителна!',
            'kilometers.required'=>'Километри са задължителни!',
            'work_cost.required'=>'Цена труд е задължителна!',
            'part_cost.required'=>'Цена част е задължителна!',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Repair::create([
            'car_id'=>$request->car_id,
            'repair'=>$request->repair,
            'part'=>$request->part,
            'kilometers'=>$request->kilometers,
            'work_cost'=>$request->work_cost,
            'part_cost'=>$request->part_cost,
        ]);

        return redirect()->route('single')->with('message','Ремонтът е създаден успешно!');
    }
    public function edit($id, $carId){
        $getRepair = Repair::where('car_id',$carId)->where('id',$id)->first();
        return view('repairs.edit',[
           'repair'=>$getRepair,
        ]);
    }
}
