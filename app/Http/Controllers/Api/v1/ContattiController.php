<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Models\Contatti;
use App\Models\ContattiRuoli;
use App\Models\Crediti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ContattoStoreRequest;
use App\Http\Requests\v1\ContattoUpdateRequest;
use App\Http\Resources\v1\ContattiCollection;
use App\Http\Resources\v1\ContattiCompletaCollection;
use App\Http\Resources\v1\ContattiCompletaResource;
use App\Http\Resources\v1\ContattiResource;
use App\Models\ContattiAuth;
use App\Models\Indirizzi;
use App\Models\Password;
use App\Models\Sessioni;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ContattiController extends Controller
{

    //--------------------------Funzioni Base--------------------------------
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Contatti::all();
                return $this->creaCollection($risorsa);
            } else {
                abort(403, 'CON-C_0002');
            }
        } else {
            abort(404, 'CON-C_0001');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, $idContatto)
    {
        
        if (Gate::allows('leggere')) {
            $contatto = $this->trovaIdDatabase($idContatto);
            if (Gate::allows('admin')) {
                return $this->creaRisorsa($contatto);
            } else {
                //se la richiesta viene dall'utente prendo token
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKM_0001');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        return new ContattiCompletaResource($contatto);
                    }else{
                        abort(403,'TKM_0000');
                    }
                }
            }
        } else {
            abort(403, 'CON-CS_0004');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContattoUpdateRequest $request, $idContatto)
    {
        
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            $contatto = $this->trovaIdDatabase($idContatto);
            if (Gate::allows('admin')){
                $contatto->fill($data);
                $contatto->save();
                return new ContattiResource($contatto);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKM_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $contatto->fill($data);
                        $contatto->save();
                    }else{
                        abort(403,'TKM_0005');
                    }
                    return new ContattiResource($contatto);
                }
            }
        } else {
            abort(403, 'CON-C_0007');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idContatto)
    {
        if (Gate::allows('eliminare')) {
            $contatto = $this->trovaIdDatabase($idContatto);
            $contatto->deleteOrFail();
            $this->aggiornaIdTabella('contatti','idContatto','Contatti');

            $passwords = Password::where('idContatto',$idContatto);
            foreach ($passwords as $password){
                $password->deleteOrFail();
                $this->aggiornaIdTabella('passwords','idPassword','Password');
            }

            $auth = ContattiAuth::where('idContatto',$idContatto)->firstOrFail();
            $auth->deleteOrFail();
            $this->aggiornaIdTabella('contatti_auths','idAuth','ContattiAuth');

            $indirizzi = Indirizzi::where('idContatto',$idContatto);
            foreach ($indirizzi as $indirizzo){
                $indirizzo->deleteOrFail();
                $this->aggiornaIdTabella('indirizzi','idIndirizzo','Indirizzi');
            }

            $sessioni = Sessioni::where('idContatto',$idContatto);
            foreach ($sessioni as $session) {
                $session->deleteOrFail();
                $this->aggiornaIdTabella('sessioni','idSessione','Sessioni');
            }

            $contattiRuoli = ContattiRuoli::where('idContatto',$idContatto)->firstOrFail();
            $contattiRuoli->deleteOrFail();
            $this->aggiornaIdTabella('contatti_ruoli','id','ContattiRuoli');

            $crediti = Crediti::where('idContatto',$idContatto)->firstOrFail();
            $crediti->deleteOrFail();
            $this->aggiornaIdTabella('crediti','idCredito','Crediti');

            return response()->noContent();
        } else {
            abort(403, 'CON-C_0008');
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
    protected static function aggiornaIdDatabase ($tabella,$id,$model){
        if($tabella!==null&&$id!==null){
            $maxId = $model::max($id);
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
        $risorsa = Contatti::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
    protected function creaCollection($risorsa)
    {
        $tipo = request("tipo");
        if ($tipo == "completo") {
            $ritorno = new ContattiCompletaCollection($risorsa);
        } else {
            $ritorno = new ContattiCollection($risorsa);
        }

        return $ritorno;
    }

    protected function creaRisorsa($contatto)
    {
        if ($contatto !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                return new ContattiCompletaResource($contatto);
            } else {
                return new ContattiResource($contatto);
            }

        }else{
            abort (404, 'CGF_0007');
        }
    }
    protected function controlloId ($idContatto,$token){
        $payload = AccediController::verificaToken($token);
        if($payload !== null){
            $contattoDB = Contatti::where('idContatto', $payload->data->idContatto)->firstOrFail();
            if ($contattoDB->idContatto == $idContatto){
                return true;
            }else{
                abort(404, 'TKM_0003');
            }
        }else{
            abort(404, 'TKM_0002');
        }
    }
}
