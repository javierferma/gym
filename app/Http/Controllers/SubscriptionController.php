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
        $subscriptions = Subscription::all();

       $clients = User::clients()->orderBy('created_at', 'desc')
                    ->name($name)
                    ->paginate(5);
        return view('subscriptions.index', compact('clients' , 'subscriptions'));
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
}
