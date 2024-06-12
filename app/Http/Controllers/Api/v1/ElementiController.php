<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FilmCollection;
use App\Http\Resources\v1\FilmCompletoCollection;
use App\Http\Resources\v1\SerieTvCollection;
use App\Http\Resources\v1\SerieTvCompletaCollection;
use App\Models\Film;
use App\Models\SerieTv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ElementiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->get();
            $serieTv = SerieTv::where('visualizzato', 1)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::all();
                    $serieTv = SerieTv::all();
                }
                $data=['data'=>[
                    'film'=>$this->creaCollectionFilm($film),
                    'serieTv'=>$this->creaCollectionSerieTv($serieTv)
                ]];
                return response()->json($data);
            } else {
                $data=['data'=>[
                    'film'=>new FilmCollection($film),
                    'serieTv'=>new SerieTvCollection($serieTv)
                ]];
                if(!$data) abort(404);
                return response()->json($data);
            }
        }  else {
            abort(403, 'TCI_0001');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function indexGenere(string $idGenere)
    {
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->where('idGenere', $idGenere)->get();
            $serieTv = SerieTv::where('visualizzato', 1)->where('idGenere', $idGenere)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::all()->where('idGenere', $idGenere);
                    $serieTv = SerieTv::all()->where('idGenere', $idGenere);
                }
                $data=[
                    'film'=>$this->creaCollectionFilm($film),
                    'serieTv'=>$this->creaCollectionSerieTv($serieTv)
                ];
                return response()->json($data);
            } else {
                $data=[
                    'film'=>new FilmCollection($film),
                    'serieTv'=>new SerieTvCollection($serieTv)
                ];
                if(!$data) abort(404);
                return response()->json($data);
            }
        }  else {
            abort(403, 'TCG_0001');
        }
    }

    /**
     * Display the specified resource.
     */
    public function indexAnno(string $annoUscita)
    {
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->where('annoUscita', $annoUscita)->get();
            $serieTv = SerieTv::where('visualizzato', 1)->where('annoInizio', $annoUscita)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::all()->where('annoUscita', $annoUscita);
                    $serieTv = SerieTv::all()->where('annoInizio', $annoUscita);
                }
                $data=[
                    'film'=>$this->creaCollectionFilm($film),
                    'serieTv'=>$this->creaCollectionSerieTv($serieTv)
                ];
                return response()->json($data);
            } else {
                $data=[
                    'film'=>new FilmCollection($film),
                    'serieTv'=>new SerieTvCollection($serieTv)
                ];
                if(!$data) abort(404);
                return response()->json($data);
            }
        }  else {
            abort(403, 'TCG_0001');
        }
    }

    //!--------------------------------------------------------------------------------------
    protected function creaCollectionFilm($film)
    {
        if ($film !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new FilmCompletoCollection($film);
            } else {
                $risorsa = new FilmCollection($film);
            }
    
            return $risorsa;
        }else{
            abort (404, 'FCF_0006');
        }
    }

    protected function creaCollectionSerieTv($film)
    {
        if ($film !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new SerieTvCompletaCollection($film);
            } else {
                $risorsa = new SerieTvCollection($film);
            }
    
            return $risorsa;
        }else{
            abort (404, 'FCF_0006');
        }
    }

}
