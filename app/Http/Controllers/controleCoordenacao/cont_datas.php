<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_pais;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class cont_datas extends Controller {

    // Convertendo o mes do inglês para portugues
        public static function mes (){
            switch (date("m")) {
        case "01":    $mes = "Janeiro";     break;
        case "02":    $mes = "Fevereiro";   break;
        case "03":    $mes = "Março";       break;
        case "04":    $mes = "Abril";       break;
        case "05":    $mes = "Maio";        break;
        case "06":    $mes = "Junho";       break;
        case "07":    $mes = "Julho";       break;
        case "08":    $mes = "Agosto";      break;
        case "09":    $mes = "Setembro";    break;
        case "10":    $mes = "Outubro";     break;
        case "11":    $mes = "Novembro";    break;
        case "12":    $mes = "Dezembro";    break; 
 }
 return $mes;
}
    
    
    
    
    
    
    
    
// Chava da class principal  
}
