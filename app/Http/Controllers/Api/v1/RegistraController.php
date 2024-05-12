<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\RegistraRequest;
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
                return response()->noContent();
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
        RegistraController::nuovaPsw($data,$contatto->idContatto);
        RegistraController::nuovoIndirizzo($data,$contatto->idContatto);
        RegistraController::nuovoRuolo($contatto->idContatto, $auth->idAuth);
        RegistraController::crediti($contatto->idContatto);
        return $contatto;
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
            'cittaNascita'=>$comune->nome,
            'provinciaNascita'=>$data['provinciaNascita'],
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
            'idNazione'=>$data['nazione'],
            'idComuneItalia'=>$data['citta'],
            'preferito'=>$data['preferito'],
            'cap'=>$comune->cap,
            'indirizzo'=>$data['indirizzo'],
            'civico'=>$data['civico'],
            'citta'=>$comune->nome,
        ]);
    }
    

    protected static function nuovoRuolo($idContatto,$idAuth){
        Contatti::aggiungiUtenteRuolo($idContatto,2);
        Contatti::sincronizzaContattoRuoli($idContatto,$idAuth);
    }

    protected static function crediti($idContatto){
        return Crediti::create([
            'idContatto'=> $idContatto,
            'crediti'=> 100,
        ]);
    }

}
