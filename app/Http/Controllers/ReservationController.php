<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Training;
use App\User;
use App\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('search');

       $clients = User::all();

        return view('reservations.index' , compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user_id =  auth()->user()->id;
        $training_id = $request->input('trainingId');
        $dateTraining = $request->input('currentDay');

        $training = Training::findOrFail($training_id);

        $data  =  [ 'user_id' => $user_id , 
                    'training_id' => $training_id ];


        $entrenoCurrentDay = Training::where('day' ,   $dateTraining)->get(['id']);
        $reservadoYa = Reservation::where('user_id' , $user_id)->whereIn('training_id' , $entrenoCurrentDay)->get();

         $cosa = $dateTraining;

        if($reservadoYa->isEmpty()){
            Reservation::create($data);
            $countClientRes = Reservation::where('training_id' , $training_id)->get()->count();
            $trainingUpdate = Training::findOrFail($training_id);
            $trainingUpdate->enroll = $countClientRes;
            $trainingUpdate->save();
            return redirect('/reservations')->with(compact('cosa'));
        }else{
            $notification = 'Ya estás apuntando a un entrenamiento este día. Cancele el anterior entrenamiento y apuntate al nuevo';
            return redirect('/reservations')->with(compact('notification','cosa'));
        }

       

       
         
       // return redirect('/trainings')->with(compact('cosa'));
       

       //  return view('trainings.index')->with('notification',$notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $training = Training::findOrFail($id)->users;

      //  print($training);

        return view('reservations.show' , compact('training'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //dd($request->user_id);

        if($request->user_id){
             $cliente_id = $request->user_id;
        }else{
             $cliente_id = auth()->user()->id;
        }

        $training = Training::findOrFail($id);

        $day = $training->day->format('Y-m-d');

        

        $del = Reservation::where("user_id" , $cliente_id)->where("training_id" , $id)->delete();

        $countClientRes = Reservation::where('training_id' , $id)->get()->count();
        $trainingUpdate = Training::findOrFail($id);
        $trainingUpdate->enroll = $countClientRes;
        $trainingUpdate->save();

         $cosa = $day;
         if($request->user_id){
            return redirect('/trainings/'.$id);
         }else{
            return redirect('/reservations')->with(compact('cosa'));
         }
         
    }

    public function storeModal(Request $request){
       
        $user_id = $request->get('cliente_id');
        $training_id = $request->get('training_id');
        $dateTraining = $request->get('current_date');

        $training_capacity = Training::where('id' , $training_id)->first()->capacity;
        $training_enroll = Training::where('id' , $training_id)->first()->enroll;

        if($training_enroll < $training_capacity){
            $data  =  [ 'user_id' => $user_id , 
                    'training_id' => $training_id ];

            $exist = Reservation::where('user_id' , $user_id)
                                ->where('training_id' ,  $training_id)
                                ->exists();

            if(!$exist){
                Reservation::create($data);
                $countClientRes = Reservation::where('training_id' , $training_id)->get()->count();
                $trainingUpdate = Training::findOrFail($training_id);
                $trainingUpdate->enroll = $countClientRes;
                $trainingUpdate->save();            
            }else{
                $notification = 'El cliente ya esta apuntado a este entrenamiento';
            }
        }else{
            $notification = 'El entreno ya está completo, no puede apuntar más a clientes';
        }

        

        $cosa =  $dateTraining;

       
         return redirect('/reservations')->with(compact('notification','cosa'));

    }


    public function backReservation(Request $request){

       // $dateTraining = $request->date;

        $cosa =  $request->date;

        return redirect('/reservations')->with(compact('cosa'));
    }

}

