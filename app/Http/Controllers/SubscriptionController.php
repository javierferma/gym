<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $name = $request->get('search');
        $filter = $request->get('filter');

        if($filter == 1){
            $subscriptions = Subscription::where('status' , 0)->paginate(5);
        }else if($filter == 2){
            $subscriptions = Subscription::where('status' , 1)->paginate(5);
        }else{
           if($name){
                $users = User::clients() ->name($name)->pluck('id');
                $subscriptions = Subscription::whereIn('user_id' , $users)->paginate(5);
            }else{
                $subscriptions = Subscription::all();
                $subscriptions = Subscription::orderBy('created_at' , 'desc')->paginate(5);
            }             
        }



        return view('subscriptions.index', compact('subscriptions'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function paid(Request $request)
    {
        $subscription = Subscription::findOrFail($request->id);

        $data = ['status' => 1];

        $subscription->fill($data);
        $subscription->save();

        return redirect('/subscriptions');
    }

    public function unpaid(Request $request)
    {
        $subscription = Subscription::findOrFail($request->id);

        $data = ['status' => 0];

        $subscription->fill($data);
        $subscription->save();

        return redirect('/subscriptions');
    }

    public function payment()
    {
        $user_id =  auth()->user()->id;
        $payments = Subscription::where('user_id', $user_id)->get();

        dd($payments->toArray());

        return 'Hola';
    }

}
