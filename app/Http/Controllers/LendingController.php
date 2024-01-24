<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;

class LendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = response()->json(Lending::all());
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lending = new Lending();
        $lending->user_id = $request->user_id;
        $lending->copy_id = $request->copy_id;
        $lending->start = $request->start;
        $lending->save();
    }

    /**
     * Display the specified resource.
     */
    public function show ($user_id, $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)->where('copy_id', $copy_id)->where('start', $start)->get();
        return $lending[0];
    }

    /**
     * Update the specified resource in storage.
     */
    //egyelőre ezt nincs értelme
    /* public function update(Request $request, $user_id, $copy_id, $start)
    {
        $lending = $this->show($user_id, $copy_id, $start);
        
    } */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $copy_id, $start)
    {
        Lending::where('user_id', $user_id)
        ->where('copy_id', $copy_id)
        ->where('start', $start)
        ->delete();
    }
    public function allLendingUserCopy(){
       
        $datas = Lending::with(['copies','users'])
        ->get();
        return $datas;
    }
    public function dateLending(){
        $datas = Lending::with(['copies','users'])->where('start','=','1972-09-19')->get();
    
        return $datas;
    }


}
