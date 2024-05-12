<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Models\Accessi;
use App\Models\Configurazioni;
use App\Models\ContattiAuth;
use App\Models\Password;
use App\Models\Sessioni;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AccediController extends Controller
{

//!-------------------------------------- TEST --------------------------------------------------------------
    public static function testLogin($hashUsername,$hashEmail, $hashSalePsw)
    {

        print_r(AccediController::controlloPassword($hashUsername,$hashEmail, $hashSalePsw));
    }

//!-------------------------------------- TEST --------------------------------------------------------------

    /**
     * Cerca l'hash dello email nel DB
     */
    public function searchMail($contatto){
        $tmp = (ContattiAuth::esisteUtente($contatto)) ? true:false;
        return AppHelpers::rispostaCustom($tmp);

    }

    /**
     * Display the specified resource.
     */
    public function accedi($username,$email, $hash = null)
    {
        if ($hash == null){
            return AccediController::controlloUtente($username,$email);

        }else{
            return AccediController::controlloPassword($username,$email,$hash);
        }
    }

    /**
     * Funzione di hash di una stringa
     * @param string
     * @return string \hash
     */
    public static function hash($stringa)
    {
        return hash("sha512", $stringa);
    }
    /**
     * Verifica il token ad ogni chiamata
     *
     * @param string $token
     * @return object
     */
    public static function verificaToken($token) {
        $rit = null;
        $sessione = Sessioni::datiSessione($token);
        if ($sessione != null){
            $inizioSessione = $sessione->inizioSessione;
            $durataSessione = Configurazioni::leggiValori('durataSessione');
            $scadenzaSessione = $inizioSessione + $durataSessione;
            //echo ("PUNTO 1<br>");
            if (time() < $scadenzaSessione){
                //echo ("PUNNTO 2<br>");
                $auth = ContattiAuth::where('idContatto', $sessione->idContatto)->first();
                if ($auth != null){
                    //echo ("POINT 3 <br>");
                    $secretJWT = $auth->secretJWT;
                    $payload = AppHelpers::validaToken($token, $secretJWT, $sessione);
                    if($payload != null){
                        //echo ("PUNTO 4 <br>");
                        $rit = $payload;
                    }else{
                        abort(403,'TK_0006');
                    }
                }else{
                    abort(403,'TK_0005');
                }
            }else{
                abort(403,'TK_0004');
            }
        }else{
            abort(404,'TK_0003');
        }
        return $rit;
    }

//-------------------------------------------------PROTECTED-----------------------------------
    protected static function controlloUtente($username,$email){
        $sale = hash("sha512",trim(Str::random(200)));
        if(ContattiAuth::esisteUtenteValidoLog($email)){
            //se esiste
            $auth = ContattiAuth::where('email',$email)->where('username',$username)->first();
            //$auth->sfida = $sfida;
            $auth->secretJWT = hash("sha512", trim(Str::random(200)));
            $auth->inizioSfida = time();
            $auth->save();//scriviamo nel database
            //controlliamo l'ultima password
            $recordPassword = Password::passwordAttuale($auth->idContatto);
            $recordPassword->sale = $sale;
            $recordPassword->save();
        }else{
            //non esiste quindi invento sfida e sale per confondere i malintenzionati
        }
        $dati = array("sale"=>$sale);
        return AppHelpers::rispostaCustom($dati);
    }

    protected static function controlloPassword($username,$email, $hashClient){
        if (ContattiAuth::esisteUtenteValidoLog($email)){
            $auth = ContattiAuth::where('email',$email)->where('username',$username)->firstOrFail();
            $secretJWT = $auth->secretJWT;
            $inizioSfida = $auth->inizioSfida;
            $durataSfida = Configurazioni::leggiValori('durataSfida');
            $maxTentativi = Configurazioni::leggiValori('maxLogErrati');
            $scadenzaSfida = $inizioSfida + $durataSfida;
            if (time() < $scadenzaSfida){
                $tentativi = Accessi::contaTentativi($auth->idContatto);
                if ($tentativi < $maxTentativi - 1){
                    $recordPassword = Password::passwordAttuale($auth->idContatto);
                    $password = $recordPassword->psw;
                    $sale = $recordPassword->sale;
                    //$hashFinaleDB = AppHelper::creaPswCifrata($password, $sale, $sfida);
                    $passwordNascostaDB = AppHelpers::nascondiPassword($password, $sale);
                    //$passwordClient = AppHelper::decifra($hashClient, $secretJWT);
                    if ($hashClient == $passwordNascostaDB){
                        $tk = AppHelpers::creaTokenSessione($auth->idContatto, $secretJWT);
                        Accessi::eliminaTentativi($auth->idContatto);
                        Accessi::aggiungiAccesso($auth->idContatto);

                        Sessioni::eliminaSessione($auth->idContatto);
                        Sessioni::aggiornaSessione($auth->idContatto, $tk);

                        $dati = array('tk'=>$tk);
                        return AppHelpers::rispostaCustom($dati);
                    }else{
                        // echo $hashClient . '-----------------1------';
                        // echo $sale. '------------2-----------';
                        // echo $password. '-----------3------------';
                        Accessi::aggiungiTentativoFallito($auth->idContatto);
                        abort(403,'ERR L004');
                    }
                }else{
                    abort(403,'ERR L003');
                }
            }else{
                Accessi::aggiungiTentativoFallito($auth->idContatto);
                // echo $inizioSfida . '-----------------1------';
                // echo $durataSfida. '------------2-----------';
                // echo $scadenzaSfida. '-----------3------------';

                abort(403, 'ERR L002');
            }
        }else{
            abort(403,'ERR L001');
        }
    }
}
