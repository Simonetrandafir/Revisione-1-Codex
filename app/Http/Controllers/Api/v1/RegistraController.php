<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\RegistraRequest;
use App\Http\Resources\v1\ContattiResource;
use App\Models\ComuniItaliani;
use App\Models\Contatti;
use App\Models\ContattiAuth;
use App\Models\Crediti;
use App\Models\Indirizzi;
use App\Models\Password;
use Illuminate\Http\Request;

class RegistraController extends Controller
{
    public function registra(RegistraRequest $request){
        $data = $request->validated();
        if($data){
            $newContatto = RegistraController::aggiungiContatto($data);
            if($newContatto){
                return new ContattiResource($newContatto);
            }else{
                abort(500,'Errore creazione contatto');
            }
        }else{
            abort(500,"Errore dati input");
        }

    }
    protected static function aggiungiContatto($data){
        $contatto = RegistraController::nuovoContatto($data);
        $auth = RegistraController::nuovoAuth($data,$contatto->idContatto);
        $psw =RegistraController::nuovaPsw($data,$contatto->idContatto);
        $indirizzo =RegistraController::nuovoIndirizzo($data,$contatto->idContatto);
        $ruolo =RegistraController::nuovoRuolo($contatto->idContatto);
        $credito =RegistraController::crediti($contatto->idContatto);
        if($contatto&&$auth&&$psw&&$indirizzo&&$ruolo&&$credito){
            return $contatto;

        }else{
            abort(500,'RC-AC');
        }
    }

    protected static function nuovoContatto($data){
        $comune= ComuniItaliani::trovaComune($data['citta']);
        return Contatti::create([
            'idStato'=>1,
            'nome'=>$data['nome'],
            'cognome'=>$data['cognome'],
            'sesso'=>$data['sesso'],
            'codFiscale'=>$data['codFiscale'],
            'cittadinanza'=>$data['cittadinanza'],
            'idNazione'=>$data['nazione'],
            'citta'=>$comune->nome,
            'provincia'=>$data['provincia'],
            'dataNascita'=>$data['dataNascita'],
        ]);
    }
    
    protected static function nuovoAuth($data,$idContatto){
        $userHash = AppHelpers::hash($data['username']);
        $emailHash = AppHelpers::hash($data['email']);
        return ContattiAuth::create([
            'idContatto'=> $idContatto,
            'username'=>$userHash,
            'email'=>$emailHash,
            'secretJWT'=>'',
        ]);
    }
    
    protected static function nuovaPsw($data,$idContatto){
        $pswHash = AppHelpers::hash($data['psw']);
        return Password::create([
            'idContatto'=> $idContatto,
            'psw'=>$pswHash,
            'sale'=>'',
        ]);
    }
    
    protected static function nuovoIndirizzo($data,$idContatto){
        $comune = ComuniItaliani::trovaComune(($data['citta']));
        return Indirizzi::create([
            'idTipoIndirizzo'=>1,
            'idContatto'=>$idContatto,
            'idNazione'=>1,
            'idComuneItalia'=>$data['citta'],
            'preferito'=>$data['preferito'],
            'cap'=>$comune->cap,
            'indirizzo'=>$data['indirizzo'],
            'civico'=>$data['civico'],
            'citta'=>$comune->nome,
        ]);
    }
    

    protected static function nuovoRuolo($idContatto,){
        $aggiungi=Contatti::aggiungiUtenteRuolo($idContatto,2);
        $sincronizza=Contatti::sincronizzaContattoRuoli($idContatto,2);
        if($aggiungi&&$sincronizza){
            return true;
        }else{
            return false;
        }
    }

    protected static function crediti($idContatto){
        return Crediti::create([
            'idContatto'=> $idContatto,
            'crediti'=> 500,
        ]);
    }

}
