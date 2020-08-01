<?php

namespace App\Http\Controllers;

use App\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $tickets = null;

        $getTickets = Support::where([
            ['user_id', $user->id]
            ])->get();

        if($getTickets->count()){
            $tickets = $getTickets;
        }

        return view('support', [
            'title' => 'Support',
            'tickets' => $tickets
        ]);
    }

    public function showSupport()
    {
        $tickets = Support::all();
        
        return view('admin.showAllSupports', [
            'tickets' => $tickets,
            'title' => 'Support Ticket'
        ]);
    }

    public function replySupport(Request $request)
    {
        $support = Support::findOrFail($request->support);
        $data = $request->validate([
            'response' => 'required'
        ]);
        $support->response = $request->response;
        $support->resolved = true;
        $support->save();

        session()->flash('status', 'The ticket has been successfully resolved');
        return redirect('/viewSupport');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);

        $support = new Support;
        $support->user_id = $user->id;

        $support->title = $request->title;
        $support->description = $request->description;
        $support->save();

        session()->flash('status', 'Your support ticket has been submitted');
        return redirect('/support');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function edit(Support $support)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        //
    }
}
