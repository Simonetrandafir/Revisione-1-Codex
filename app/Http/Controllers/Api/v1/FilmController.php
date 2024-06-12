<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FilmStoreRequest;
use App\Http\Requests\v1\FilmUpdateRequest;
use App\Http\Resources\v1\FilmCollection;
use App\Http\Resources\v1\FilmCompletoCollection;
use App\Http\Resources\v1\FilmCompletoResource;
use App\Http\Resources\v1\FilmResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $film=null;
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::all();
                }
                return $this->creaCollection($film);
            } else {
                return new FilmCollection($film);
            }
        }  else {
            abort(403, 'FC_0001');
        }
    }
    public function indexGenere($idGenere){
        $film=null;
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->where('idGenere',$idGenere)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::where('idGenere',$idGenere)->get();
                }
                return $this->creaCollection($film);
            } else {
                return new FilmCollection($film);
            }
        }  else {
            abort(403, 'FCI_0000');
        }
    }

    public function indexRegista($regista){
        $film=null;
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->where('regista',$regista)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::where('regista',$regista)->get();
                }
                return $this->creaCollection($film);
            } else {
                return new FilmCollection($film);
            }
        }  else {
            abort(403, 'FCI_0010');
        }
    }

    public function indexAnno($anno){
        $film=null;
        if (Gate::allows('leggere')) {
            $film = Film::where('visualizzato', 1)->where('annoUscita',$anno)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = Film::where('annoUscita',$anno)->get();
                }
                return $this->creaCollection($film);
            } else {
                return new FilmCollection($film);
            }
        }  else {
            abort(403, 'FCI_0011');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmStoreRequest $request)
    {
        if (Gate::allows("creare")) {
            $data = $request->validated();
            $config = Film::create($data);
            return new FilmCompletoResource($config);
        } else {
            abort(403,"FCS_0003");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idFilm)
    {
        $film=null;
        if (Gate::allows('leggere')) {
            $film = Film::where('idFilm', $idFilm)
                ->where('visualizzato', 1)
                ->firstOrFail();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $film = $this->trovaIdDatabase($idFilm);
                }
                return $this->creaRisorsa($film);
            } else{
                return new FilmResource($film);
            }
        } else {
            abort(403,'FC_0002');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmUpdateRequest $request, $idFilm)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')){
                $data = $request->validated();
                $film = $this->trovaIdDatabase($idFilm);
                $film->fill($data);
                $film->save();
                return new FilmCompletoResource($film);
            }else {
                abort(403,'FCU_0004');
            }
        } else {
            abort(404,'FCU_0005');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idFilm)
    {
        if (Gate::allows('eliminare')) {
            $film = $this->trovaIdDatabase($idFilm);
            $film->deleteOrFail();
            $this->aggiornaIdDatabase('films', 'idFilm');
            return response()->noContent();
        } else {
            abort (403, 'FCD_0006');
        }
    }

    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //
    /**
     * Aggiorna id della tabella ricevendo la tabelle, l'id della tabella e il model
     * 
     * @param string $tabella
     * @param string $id
     * @param string $model
     */
    protected static function aggiornaIdDatabase ($tabella,$id){
        if($tabella!==null&&$id!==null){
            $maxId = Film::max($id);
            $statement = "ALTER TABLE $tabella AUTO_INCREMENT = $maxId";
            $query = DB::statement($statement);
            if ($query !== null){
                return $query;
            }else{
                abort(404,'ATID_XXXX');
            }
        }else{
            abort(404,'ATID-BASE');
        }
    }

    /**
     * Prende l'id nel database ed il nome del Model e ritorna l'elemento se presente
     * 
     * @param string $id
     * @param string $model
     */
    protected static function trovaIdDatabase($id){
        $risorsa = Film::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
    protected function creaCollection($film)
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
    protected function creaRisorsa($film)
    {
        if ($film !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new FilmCompletoResource($film);
            } else {
                $risorsa = new FilmResource($film);
            }
    
            return $risorsa;

        }else{
            abort (404, 'FCF_0007');
        }
    }
}
