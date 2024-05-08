<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Stati;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\StatiCollection;
use App\Http\Resources\v1\StatiResource;
use Illuminate\Support\Facades\Gate;

class StatiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $ruoli = Stati::all();
        if($ruoli){
            return new StatiCollection($ruoli);
        }else{
            abort(404,'STC-I');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($idStato)
    {

        $stato = Stati::find($idStato);
        if (!$stato) {
            // Gestisci il caso in cui lo stato non esista
            abort(404, 'STCS-S');
        }else{
            return new StatiResource($stato);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stati $stati)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stati $stati)
    {
        //
    }
}
