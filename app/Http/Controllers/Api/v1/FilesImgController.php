<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\ControllersApi\v1\FilesController;
use App\Http\Resources\v1\FilesResource;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FilesImgController extends Controller
{

    /**
     * Funzione per salvare file img nella cartella storage/public
     * Salva anche i dati nel database tabella files
     * 
     * @param Request $request
     */
    public function store(Request $request,$idRecord)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')){
                $files=array();
                $files['infoFiles']= array();
                if($request->hasFile('uploadImg')){
                    foreach($request->file('uploadImg') as $file){
                        $nome = time().'.'.$file->getClientOriginalName();
                        $size = $file->getSize();
                        $file -> storeAs('/files/',$nome,'public');
                        $extension = pathinfo($nome, PATHINFO_EXTENSION);
                        $pathFiles=storage_path('app\public\files');
                        // $file->move(public_path().'',$nome);
                        $dataFiles=[
                            'idRecord'=>$idRecord,
                            'nome'=>$nome,
                            'size'=>$size,
                            'posizione'=>$pathFiles,
                            'ext'=>$extension,
                        ];
                        $risorsa = Files::create($dataFiles);
                        $ritorno = new FilesResource($risorsa);
                        $files['infoFiles'][] = ['id' => $ritorno->idFile, 'nome' => $ritorno->nome];
                    }
                    $files['data']=true;
                }else{
                    $files['data']=false;
                }
                return json_encode($files);
            }else {
                abort(403,'UPF_0002');
            }
        } else {
            abort(404,'UPF_0001');
        }
    }
}
