<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VistaTraduzioniController extends Controller
{
    public function index(){
        // Recupera i parametri dalla richiesta
        $chiave = request('chiave');
        $tipo = request('tipo');
        $idLingua = request('idLingua');

        $query = DB::table('vista_traduzioni');
        if($query!==null){
            if($chiave !==null){
                $query->where('chiave',$chiave);
            }elseif($tipo!==null){
                $query->where('tipo',$tipo);
            }elseif($idLingua!==null){
                $query->where('idLingua',$idLingua);
            }
    
            $traduzioni = $query->get();
            return response()->json($traduzioni);
        }else{
            abort(404,'VT-I');
        }
        
    }

    public function show($id){
        $risorsa = $this->trovaID($id);
        if($risorsa!==null){
            return $risorsa;
        }else{
            abort(404, "VT-S");
        }
    }
    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //
    protected function trovaID($id){
        $risorsa = DB::table('vista_traduzioni');
        if ($risorsa !== null){
            $risorsa->where('id',$id);
            $traduzione = $risorsa->get();
        return response()->json($traduzione);
        }else{
            abort(404,'VT-ID non trovato');
        }
    }
}
