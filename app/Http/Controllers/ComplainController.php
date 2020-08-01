<?php

namespace App\Http\Controllers;

use App\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplainController extends Controller
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

        $getTickets = Complain::where([
            ['user_id', $user->id]
            ])->get();

        if($getTickets->count()){
            $tickets = $getTickets;
        }

        return view('complain', [
            'title' => 'Complain',
            'tickets' => $tickets
        ]);
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

        $complain = new Complain;
        $complain->user_id = $user->id;

        $complain->title = $request->title;
        $complain->description = $request->description;
        $complain->save();

        if($request->hasFile('attachment')){
            $name = time().'_'.$request->file('attachment')->getClientOriginalName();
            Storage::putFileAs('public/images', $request->file('attachment'), $name);
            $complain->attachment = $name;
            $complain->save();
        }

        session()->flash('status', 'Your complain ticket has been submitted');
        return redirect('/complain');
    }

    public function showComplaints()
    {
        $tickets = Complain::all();
        
        return view('admin.showAllComplaints', [
            'tickets' => $tickets,
            'title' => 'Complain Tickets'
        ]);
    }

    public function replyComplain(Request $request)
    {
        $complain = Complain::findOrFail($request->complain);
        $data = $request->validate([
            'response' => 'required'
        ]);
        $complain->response = $request->response;
        $complain->resolved = true;
        $complain->save();

        session()->flash('status', 'The ticket has been successfully resolved');
        return redirect('/viewComplaints');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show(Complain $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(Complain $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complain $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complain $complain)
    {
        //
    }
}
