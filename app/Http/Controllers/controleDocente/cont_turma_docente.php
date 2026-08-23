<?php
namespace App\Http\Controllers\controleDocente;
use App\Models\modelCoordenacao\tb_turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\modelCoordenacao\tb_escola;
// Controle (metodos) do modulo turma.
class cont_turma_docente extends Controller {
    private $request;
    private $validator;
    private $tb_turma;
    public function __construct(Request $dadosForm, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
    }

    
    
    
    
    
    
    
//FIM DA CLASSE CONTROLE DA TURMA 
}
