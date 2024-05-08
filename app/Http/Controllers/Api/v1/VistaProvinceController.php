<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VistaProvinceController extends Controller
{
    public function index(){
        // Recupera i parametri dalla richiesta

        $query = DB::table('vista_province');
        if($query!==null){
            $province = $query->get();
            return response()->json($province);
        }else{
            abort(404,'VP-I');
        }
        
    }

    public function show($provincia){
        $risorsa = $this->trovaID($provincia);
        if($risorsa!==null){
            return $risorsa;
        }else{
            abort(404, "VP-S");
        }
    }
    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //
    protected function trovaID($provincia){
        $risorsa = DB::table('vista_province');
        if ($risorsa !== null){
            $risorsa->where('provincia',$provincia);
            $province = $risorsa->get();
        return response()->json($province);
        }else{
            abort(404,'VP-ID non trovato');
        }
    }
}
