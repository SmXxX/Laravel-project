<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Client;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
     // show all clients
     public function index(){
        return view('clients.index', [
            'clients' => Client::orderBy('created_at', 'desc')->filter(request(['search']))->paginate(6)
        ]);
    }

    //show single client
    public function show(Request $request, $id){
        $client = Client::where('id', $id)->first();
        $cars = Car::where('client_id', $client->id)->orderBy('id','asc')->get();
        $selectedCar = Car::where('client_id', $client->id)->orderBy('id','asc')->first();
        $repairs = Repair::where('car_id', $selectedCar->id)->get();
        return view('clients.single_view',[
            'client' => $client,
            'cars' => $cars,
            'selectedCar' => $selectedCar,
            'repairs' => $repairs
        ]);
    }

    public function create(){
        return view('clients.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|min:10'
        ], [
            'name.required' => 'Името е задължително!',
            'phone_number.required' => 'Телефонният номер е задължителен!',
            'phone_number.min' => 'Трябва да съдържа минимум 10 числа!',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = 1;
        // $client = new Client();
        // $client->user_id = $user_id;
        // $client->name = $request->name;
        // $client->phone_number = $request->phone_number;
        // $client->save();

        Client::create([
            'user_id'=>$user_id,
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
        ]);

        return redirect('/')->with('message',"Клиента е създаден успешно!");
    }

    public function edit($id){
        $getClient = Client::findOrFail($id);
        return view('clients.edit',[
           'client'=>$getClient,
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|min:10'
        ], [
            'name.required' => 'Името е задължително!',
            'phone_number.required' => 'Телефонният номер е задължителен!',
            'phone_number.min' => 'Трябва да съдържа минимум 10 числа!',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = 1;
        // $client = new Client();
        // $client->user_id = $user_id;
        // $client->name = $request->name;
        // $client->phone_number = $request->phone_number;
        // $client->save();

        Client::where('id',$id)->update([
            'user_id'=>$user_id,
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
        ]);
        return redirect('/')->with('message',"Клиента е редактиран успешно!");
    }

    public function destroy($id){
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect('/')->with('message',"Клиента е изтрит успешно!");
    }
}
