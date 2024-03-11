<?php

namespace App\Http\Controllers;

use App\Models\Mac;
use App\Http\Requests\StoreMacRequest;
use App\Http\Requests\UpdateMacRequest;

class MacController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMacRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mac  $mac
     * @return \Illuminate\Http\Response
     */
    public function show(Mac $mac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mac  $mac
     * @return \Illuminate\Http\Response
     */
    public function edit(Mac $mac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMacRequest  $request
     * @param  \App\Models\Mac  $mac
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMacRequest $request, Mac $mac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mac  $mac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mac $mac)
    {
        //
    }
}
