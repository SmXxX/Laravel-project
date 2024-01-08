<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarsController extends Controller
{
    // show all cars
    public function index(){
        return view('cars.index');
    }

    public function create(){
        $clients = Client::all();
        return view('cars.create',[
            'clients'=>$clients,
        ]);
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'client_id'=>'required',
            'plate'=>'required',
            'brand'=>'required',
            'model'=>'required',
            'year'=>'required',
            'engine'=>'required',
            'hp'=>'required',
            'kw',
            'fuel'=>'required',
            'vin_num'=>'required',
        ], [
            'client_id.required'=>'Избери клиент!',
            'plate.required'=>'Номер на колата е задължителен!',
            'brand.required'=>'Марката е задължителна!',
            'model.required'=>'Модела е задължителен!',
            'year.required'=>'Година на производство е задължителна!',
            'engine.required'=>'Литраж на двигател е задължителен!',
            'hp.required'=>'Мощност на двигателя е задължителен!',
            'fuel.required'=>'Вид гориво е завължително!',
            'vin_num.required'=>'Номер на рама е задължително!',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Car::create([
            'client_id'=>$request->client_id,
            'plate'=>$request->plate,
            'brand'=>$request->brand,
            'model'=>$request->model,
            'year'=>$request->year,
            'engine'=>$request->engine,
            'hp'=>$request->hp,
            'kw'=> $request->hp*0.7457,
            'fuel'=>$request->fuel,
            'vin_num'=>$request->vin_num,
            'additional_info'=> $request->additional_info,
        ]);

        return redirect('/')->with('message',"Колата е създадена успешно!");
    }

    public function edit($id, $cId){
        $getCar = Car::where('client_id',$cId)->where('id',$id)->first();
        return view('cars.edit',[
           'car'=>$getCar,
        ]);
    }

    public function update(Request $request, $id, $cId){
        $validator = Validator::make($request->all(), [
            'plate'=>'required',
            'brand'=>'required',
            'model'=>'required',
            'year'=>'required',
            'engine'=>'required',
            'hp'=>'required',
            'fuel'=>'required',
            'vin_num'=>'required',
        ], [
            'plate.required'=>'Номер на колата е задължителен!',
            'brand.required'=>'Марката е задължителна!',
            'model.required'=>'Модела е задължителен!',
            'year.required'=>'Година на производство е задължителна!',
            'engine.required'=>'Литраж на двигател е задължителен!',
            'hp.required'=>'Мощност на двигателя е задължителен!',
            'fuel.required'=>'Вид гориво е завължително!',
            'vin_num.required'=>'Номер на рама е задължително!',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Car::where('id',$id)->where('client_id',$cId)->update([
            'client_id'=>$cId,
            'plate'=>$request->plate,
            'brand'=>$request->brand,
            'model'=>$request->model,
            'year'=>$request->year,
            'engine'=>$request->engine,
            'hp'=>$request->hp,
            'kw'=>$request->hp*0.7457,
            'fuel'=>$request->fuel,
            'vin_num'=>$request->vin_num,
            'additional_info'=>$request->additional_info
        ]);
        return redirect()->route('single',$cId)->with('message',"Колата е редактирана успешно!");
    }
    

    // public function get_carInfo(Request $request){
    //     $carId = $request->selectedCar;
    //     $clientId = $request->clientId;
    //     $car = Car::where('id',$carId)->where('client_id',$clientId)->first();
    //     if ($car){
    //         return response()->json(['status' => true, 'car'=>$car], 200);
    //     }else{
    //         return response()->json(['status' => false, 'message' => 'Not Found!'], 404);
    //     }
    // }
}
