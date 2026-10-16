<?php

namespace App\Models\modelCoordenacao;

// Adiciona outras tabelas quandpo for fazer as buscas e os metodos
use Illuminate\Database\Eloquent\Model;
// usando o carbom para converter as datas que estão em string para data
use Carbon\Carbon;

class tb_carne extends Model {

    protected $table = 'tb_carne';
    protected $guard = ['idcarne'];
    protected $primaryKey = 'idcarne';
    public $timestamps = false;
    protected $fillable = [
        
                
        'tb_turmas_idTurmas', 'tb_aluno_idAluno', 'RA', 'parcelas', 'Ano_Letivo', 'ValorPGTO', 'codbarras',
        'data_pagamento', 'status_pagamento', 'MesPgto', 'obs_pagamento', 'Digito_verificador', 'Carteira', 'Acardo', 'Data_venc'];
    
   
    
// Campos Obrigatorios para edita o nome da disciplina
    static $camposObg = [
        'Meses' => 'required',
        'Data_venc' => 'required',
    ];
    static $camposObgAcordo = [
        'Data_venc' => 'required',
        'valor_prestacao' => 'required',
        'quantidade_parcelas' => 'required',
        'obs_do_acordo' => 'required',
        'valor_Acordo' => 'required',
    ];
    static $status_pagamento = [
        'status_pagamento' => 'required',
        'forma_pgto' => 'required',
    ];
    static $CodigoBarrasObrigatorio = [
        'codbarras' => 'required',
    ];

//Relacionamento com a tabela turma
    public function turmaAlunoBoleto() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turma', 'idTurmas', 'tb_turmas_idTurmas');
    }

// Metodo que verificar se o aluno ja tem o seu carnê gerado.
    public static function verificarCarne($dadosForm) {
        $count = count($dadosForm["Meses"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        $RA = $dadosForm["RA"];
        $idAluno = $dadosForm["idAluno"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $idTurma = $dadosForm["idTurma"];
        $parcelas_numero = 0;
        $Mensalidade = $dadosForm["Mensalidade"];
        $Meses = $dadosForm["Meses"];
        $Carteira = $dadosForm["Carteira"];
        $Data_venc = $dadosForm["Data_venc"];
        $Digito_verificador = 0;

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $parcelas_numero = $parcelas_numero + 1;
                $novoCarne = new tb_carne($dadosForm);
                $novoCarne->tb_turmas_idTurmas = $idTurma;
                $novoCarne->tb_turmas_Mensalidade = $Mensalidade;
                $novoCarne->tb_aluno_idAluno = $idAluno;
                $novoCarne->RA = $RA;
                $novoCarne->status_pagamento = "ABERTO";
                $novoCarne->Carteira = $Carteira;
                $novoCarne->Acordo = "N";
                $novoCarne->parcelas = $parcelas_numero . '/' . $count;
                $novoCarne->Meses = $Meses[$i];
// Criando um codigo verificador no boleto. pegando o mes do ciclo do for e colocando o digito diagordo com o mÊs
                switch ($Meses[$i]) {
                    case "JANEIRO": $Digito_verificador = "01";  break;
                    case "FEVEREIRO": $Digito_verificador = "02";break;
                    case "MARÇO": $Digito_verificador = "03";    break;
                    case "ABRIL": $Digito_verificador = "04";    break;
                    case "MAIO": $Digito_verificador = "05";     break;
                    case "JUNHO": $Digito_verificador = "06";    break;
                    case "JULHO": $Digito_verificador = "07";    break;
                    case "AGOSTO": $Digito_verificador = "08";   break;
                    case "SETEMBRO": $Digito_verificador = "09"; break;
                    case "OUTUBRO": $Digito_verificador = "10";  break;
                    case "NOVEMBRO": $Digito_verificador = "11"; break;
                    case "DEZEMBRO": $Digito_verificador = "12"; break;
                }
                // Codigo que salva o barras antigo, o novo nõ tem o numero da parcela pois tava difcultando a verificação do codigo.
                //$novoCarne-> codbarras = ($idAluno.'.'.$RA.'.'.$Ano_Letivo.'.'.$idTurma.'.'.$parcelas_numero.'.'.$Mensalidade.'.'.$Carteira.'.'.$Digito_verificador);
                // Codigo antigo sem  numero da parcela
                //$codbarras = ($idAluno.'.'.$RA.'.'.$Ano_Letivo.'.'.$idTurma.'.'.$parcelas_numero.'.'.$Mensalidade.'.'.$Carteira.'.'.$Digito_verificador);
                $novoCarne->codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                $codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                return $verificar = tb_carne::select()
                        ->where('codbarras', '=', $codbarras)
                        ->count();
            }
        } // Fim do for  
    }
    // Metodo que verificar e salva carne 
    //
    // Não estou usando este medoto abaixo
    //
    //
    public static function SalveCarne($dadosForm) {
      
        $count = count($dadosForm["Meses"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE de meses
        $RA = $dadosForm["RA"];
        $idAluno = $dadosForm["idAluno"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $idTurma = $dadosForm["idTurma"];
        $parcelas_numero = 0;
        $Mensalidade = $dadosForm["Mensalidade"];
        $Meses = $dadosForm["Meses"];
        $Carteira = $dadosForm["Carteira"];
        $Data_venc = $dadosForm["Data_venc"];
        $Digito_verificador = 0;
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $parcelas_numero = $parcelas_numero + 1;
                $novoCarne = new tb_carne($dadosForm);
                $novoCarne->tb_turmas_idTurmas = $idTurma;
                $novoCarne->tb_turmas_Mensalidade = $Mensalidade;
                $novoCarne->tb_aluno_idAluno = $idAluno;
                $novoCarne->RA = $RA;
                $novoCarne->status_pagamento = "ABERTO";
                $novoCarne->Carteira = $Carteira;
                $novoCarne->Acordo = "N";
                $novoCarne->parcelas = $parcelas_numero . '/' . $count;
                $novoCarne->Meses = $Meses[$i];
// Criando um codigo verificador no boleto. pegando o mes do ciclo do for e colocando o digito diagordo com o mÊs
                switch ($Meses[$i]) {
                    case "JANEIRO": $Digito_verificador = "01";  break;
                    case "FEVEREIRO": $Digito_verificador = "02";break;
                    case "MARÇO": $Digito_verificador = "03";    break;
                    case "ABRIL": $Digito_verificador = "04";    break;
                    case "MAIO": $Digito_verificador = "05";     break;
                    case "JUNHO": $Digito_verificador = "06";    break;
                    case "JULHO": $Digito_verificador = "07";    break;
                    case "AGOSTO": $Digito_verificador = "08";   break;
                    case "SETEMBRO": $Digito_verificador = "09"; break;
                    case "OUTUBRO": $Digito_verificador = "10";  break;
                    case "NOVEMBRO": $Digito_verificador = "11"; break;
                    case "DEZEMBRO": $Digito_verificador = "12"; break;
                }
                $novoCarne->codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                $codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                //return
                $verificar = tb_carne::select()
                        ->where('codbarras', '=', $codbarras)
                        ->count();
                if ($verificar == 1) {
                    return $verificar;
                } else {
                    //Codigo que salva o codigo de barras antigo
                    //      
                    //      $novoCarne->codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $Mensalidade . '.' . $Carteira . '.' . $Digito_verificador);
                    //      $codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $Mensalidade . '.' . $Carteira . '.' . $Digito_verificador);
                    $novoCarne->Digito_verificador = $Digito_verificador;
                    $novoCarne->Data_venc = ($Data_venc . '/' . $Digito_verificador . '/' . $Ano_Letivo);
                    $novoCarne->codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                    $codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $Mensalidade);
                    $novoCarne->save();
                }
            }return $verificar;
        } // Fim do for  
    }

// Fim Metodo que verificar se o aluno ja tem o seu carnê gerado. 
// Criando o carner no banco de dados.
    public static function salvandoCarner($dadosForm) {
        $count = count($dadosForm["Meses"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        $RA = $dadosForm["RA"];
        $idAluno = $dadosForm["idAluno"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $idTurma = $dadosForm["idTurma"];
        $parcelas_numero = 0;
        $Mensalidade = $dadosForm["Mensalidade"];
        $Meses = $dadosForm["Meses"];
        $Data_venc = $dadosForm["Data_venc"];
        $Carteira = $dadosForm["Carteira"];
        $Digito_verificador = 0;
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $parcelas_numero = $parcelas_numero + 1;
                $novoCarne = new tb_carne($dadosForm);
                $novoCarne->tb_turmas_idTurmas = $idTurma;
                $novoCarne->tb_turmas_Mensalidade = $Mensalidade;
                $novoCarne->tb_aluno_idAluno = $idAluno;
                $novoCarne->RA = $RA;
                $novoCarne->status_pagamento = "ABERTO";
                $novoCarne->Carteira = $Carteira;
                $novoCarne->Acordo = "N";
                $novoCarne->parcelas = $parcelas_numero . '/' . $count;
                $novoCarne->Meses = $Meses[$i];
// Criando um codigo verificador no boleto. pegando o mes do ciclo do for e colocando o digito diagordo com o mÊs
                switch ($Meses[$i]) {
                    case "JANEIRO": $Digito_verificador = "01";  break;
                    case "FEVEREIRO": $Digito_verificador = "02";break;
                    case "MARÇO": $Digito_verificador = "03";    break;
                    case "ABRIL": $Digito_verificador = "04";    break;
                    case "MAIO": $Digito_verificador = "05";     break;
                    case "JUNHO": $Digito_verificador = "06";    break;
                    case "JULHO": $Digito_verificador = "07";    break;
                    case "AGOSTO": $Digito_verificador = "08";   break;
                    case "SETEMBRO": $Digito_verificador = "09"; break;
                    case "OUTUBRO": $Digito_verificador = "10";  break;
                    case "NOVEMBRO": $Digito_verificador = "11"; break;
                    case "DEZEMBRO": $Digito_verificador = "12"; break;
                }
                //Codigo que salva o codigo de barras antigo
                //      
                //      $novoCarne->codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $Mensalidade . '.' . $Carteira . '.' . $Digito_verificador);
                //      $codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $Mensalidade . '.' . $Carteira . '.' . $Digito_verificador);

                $novoCarne->Digito_verificador = $Digito_verificador;
                $novoCarne->Data_venc = ($Data_venc . '/' . $Digito_verificador . '/' . $Ano_Letivo);
                $novoCarne-> codbarras = ($RA.'.'.$idAluno.'.'.$Ano_Letivo.'.'.$Carteira.'.'.$idTurma.'.'.$Digito_verificador.'.'.$Mensalidade);
                $codbarras = ($RA.'.'.$idAluno.'.'.$Ano_Letivo.'.'.$Carteira.'.'.$idTurma.'.'.$Digito_verificador.'.'.$Mensalidade);
                $novoCarne->save();
            }
        } // Fim do for  
        return 1;
    }

// Criando o carner no banco de dados.
    public static function salvandoAcordo($dadosForm) {
        $quantidade_parcelas = $dadosForm["quantidade_parcelas"];
        $RA = $dadosForm["RA"];
        $idAluno = $dadosForm["idAluno"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $idTurma = $dadosForm["idTurma"];
        $valor_Acordo = $dadosForm["valor_Acordo"];
        $valor_prestacao = $dadosForm["valor_prestacao"];
        $Data_venc = $dadosForm["Data_venc"];
        $obs_do_acordo = $dadosForm["obs_do_acordo"];
        $Carteira = $dadosForm["Carteira"];
        $Digito_verificador = 0;
        $parcelas_numero = 0;
        $mes = 0;
        if ($quantidade_parcelas > 0) {
            for ($i = 0; $i < $quantidade_parcelas; $i++) {
                $parcelas_numero = $parcelas_numero + 1;
                $novoAcordo = new tb_carne($dadosForm);
                $novoAcordo->tb_turmas_idTurmas = $idTurma;
                $novoAcordo->tb_aluno_idAluno = $idAluno;
                $novoAcordo->RA = $RA;
                $novoAcordo->obs_do_acordo = $obs_do_acordo;
                $novoAcordo->valor_Acordo = $valor_Acordo;
                $novoAcordo->valor_prestacao = $valor_prestacao;
                $novoAcordo->status_pagamento = "ABERTO";
                $novoAcordo->Carteira = $Carteira;
                $novoAcordo->Acordo = "S";
                $novoAcordo->parcelas = $parcelas_numero . '/' . $quantidade_parcelas;
                $mes = date("m", strtotime(" + $i month"));
                $Digito_verificador = date('m', strtotime(" + $i month"));
                $mesAno = date('m/y', strtotime(" + $i month"));
                switch ($mes) {
                    case "01": $mes = "JANEIRO";   break;
                    case "02": $mes = "FEVEREIRO"; break;
                    case "03": $mes = "MARÇO";     break;
                    case "04": $mes = "ABRIL";     break;
                    case "05": $mes = "MAIO";      break;
                    case "06": $mes = "JUNHO";     break;
                    case "07": $mes = "JULHO";     break;
                    case "08": $mes = "AGOSTO";    break;
                    case "09": $mes = "SETEMBRO";  break;
                    case "10": $mes = "OUTUBRO";   break;
                    case "11": $mes = "NOVEMBRO";  break;
                    case "12": $mes = "DEZEMBRO";  break;
                }
                $novoAcordo->Meses = $mes;
                $novoAcordo->Digito_verificador = $Digito_verificador;
                $novoAcordo->Data_venc = ($Data_venc . '/' . $mesAno);
                $novoAcordo->codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $valor_prestacao);
                $codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $valor_prestacao);
                //Codigo Antigo sem a informação do numero da parcela, fi trocado pq dava problema para verificar ue ja existia.
                // $novoAcordo->codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $valor_prestacao . '.' . $Carteira . '.' . $Digito_verificador);
                //  $codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $valor_prestacao . '.' . $Carteira . '.' . $Digito_verificador);
                $novoAcordo->save();
            }
        } // Fim do for  
        return 1;
    }

    // Metodo que verificar se o aluno ja tem ACORDO.
    public static function verificaraAcordo($dadosForm) {
        $quantidade_parcelas = $dadosForm["quantidade_parcelas"];
        $RA = $dadosForm["RA"];
        $idAluno = $dadosForm["idAluno"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $idTurma = $dadosForm["idTurma"];
        $valor_Acordo = $dadosForm["valor_Acordo"];
        $valor_prestacao = $dadosForm["valor_prestacao"];
        $Data_venc = $dadosForm["Data_venc"];
        $obs_do_acordo = $dadosForm["obs_do_acordo"];
        $Carteira = $dadosForm["Carteira"];
        $Digito_verificador = 0;
        $parcelas_numero = 0;
        $mes = 0;
        if ($quantidade_parcelas > 0) {
            for ($i = 0; $i < $quantidade_parcelas; $i++) {
                $parcelas_numero = $parcelas_numero + 1;
                $novoAcordo = new tb_carne($dadosForm);
                $novoAcordo->tb_turmas_idTurmas = $idTurma;
                $novoAcordo->tb_aluno_idAluno = $idAluno;
                $novoAcordo->valor_Acordo = $valor_Acordo;
                $novoAcordo->valor_prestacao = $valor_prestacao;
                $novoAcordo->RA = $RA;
                $novoAcordo->status_pagamento = "ABERTO";
                $novoAcordo->Carteira = $Carteira;
                $novoAcordo->Acordo = "S";
                $novoAcordo->parcelas = $parcelas_numero . '/' . $quantidade_parcelas;
                $mes = date("m", strtotime(" + $i month"));
                $Digito_verificador = date('m', strtotime(" + $i month"));
                $mesAno = date('m/y', strtotime(" + $i month"));
                switch ($mes) {
                    case "01": $mes = "JANEIRO";   break;
                    case "02": $mes = "FEVEREIRO"; break;
                    case "03": $mes = "MARÇO";     break;
                    case "04": $mes = "ABRIL";     break;
                    case "05": $mes = "MAIO";      break;
                    case "06": $mes = "JUNHO";     break;
                    case "07": $mes = "JULHO";     break;
                    case "08": $mes = "AGOSTO";    break;
                    case "09": $mes = "SETEMBRO";  break;
                    case "10": $mes = "OUTUBRO";   break;
                    case "11": $mes = "NOVEMBRO";  break;
                    case "12": $mes = "DEZEMBRO";  break;
                }               
                $novoAcordo->codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $valor_prestacao);
                $codbarras = ($RA . '.' . $idAluno . '.' . $Ano_Letivo . '.' . $Carteira . '.' . $idTurma . '.' . $Digito_verificador . '.' . $valor_prestacao);
                //Codigo antigo, neste tem uma vearavel a mais que o numero de parcela, removi pq tinha falha, estava salvando mais de 1 ves dependendo de quando o mes iniciava.
                // $novoAcordo->codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $valor_prestacao . '.' . $Carteira . '.' . $Digito_verificador);
                // $codbarras = ($idAluno . '.' . $RA . '.' . $Ano_Letivo . '.' . $idTurma . '.' . $parcelas_numero . '.' . $valor_prestacao . '.' . $Carteira . '.' . $Digito_verificador);
                return $verificar = tb_carne::select()
                        ->where('codbarras', '=', $codbarras)
                        ->count();
            }
        } // Fim do for  
    }

// Fim Metodo que verificar se o aluno ja tem acordo na escola
    // Buscando dados do aluno para gerar o carner com codigo de barras
    public static function busca_dados_boletos($idAluno) {
        return tb_carne::select()
                        ->select('tb_carne.*')
                        ->where('tb_carne.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_carne.Carteira', '=', '1')
                        ->get();
    }

    // Buscando dados DO CABECARIO DO BOLETO DE MENSALIDADE
    public static function busca_cabecario_boletos($idAluno) {
        return tb_carne::select()
                        ->where('tb_carne.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_carne.Carteira', '=', '1')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_carne.RA', 'tb_carne.Acordo', 'tb_carne.Carteira', 'tb_carne.ValorPGTO', 'tb_carne.Ano_Letivo', 'tb_carne.tb_turmas_Mensalidade', 'tb_turmas.NomeTurma', 'tb_turmas.Mensalidade', 'tb_pais.Responsavel', 'tb_pais.CPFResponsavel', 'tb_pais.RGResponsavel', 'tb_pais.FonePai1', 'tb_pais.FonePai2', 'tb_pais.FoneMae1', 'tb_pais.FoneMae2')
                        ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        ->groupBy('tb_carne.tb_turmas_idTurmas')
                        //   ->groupBy('tb_aluno.tb_aluno.NomeAluno')
                        ->get();
    }

    // Buscando UM BOLETO ESPEFIFICO 
    public static function busca_boleto_especifico($idcarne) {
        return tb_carne::select()
                        ->where('tb_carne.idcarne', '=', $idcarne)
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        //->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_carne.*', 'tb_turmas.NomeTurma', 'tb_turmas.Mensalidade')
                        ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        ->groupBy('tb_carne.tb_turmas_idTurmas')
                        //   ->groupBy('tb_aluno.tb_aluno.NomeAluno')
                        ->get();
    }
    // Buscando prestação id ESPEFIFICO 
    public static function busca_Valor_Prestação($idcarne) {
        return tb_carne::select()
                        ->where('tb_carne.idcarne', '=', $idcarne)
                 //       ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                   //     ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        //->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                      //  ->select('tb_aluno.NomeAluno', 'tb_carne.*', 'tb_turmas.NomeTurma', 'tb_turmas.Mensalidade')
                     //   ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                      //  ->groupBy('tb_carne.tb_turmas_idTurmas')
                        //   ->groupBy('tb_aluno.tb_aluno.NomeAluno')
                
                ->select( 'tb_carne.valor_prestacao')
                        ->get();
    }
    
    
    
    
    
    

    // Buscando dados do aluno para gerar o carner com codigo de barras DOS ACORDOS
    public static function busca_dados_boletos_Acordo($idAluno) {
        return tb_carne::select()
                        ->select('tb_carne.*')
                        ->where('tb_carne.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_carne.Carteira', '=', '2')
                        ->get();
    }

    // Buscando dados DO CABECARIO DO BOLETO de um acordo
    public static function busca_cabecario_boletos_acordo($idAluno) {
        return tb_carne::select()
                        ->where('tb_carne.tb_aluno_idAluno', '=', $idAluno)
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_carne.RA', 'tb_carne.obs_do_acordo', 'tb_carne.Acordo', 'tb_carne.Carteira', 'tb_carne.ValorPGTO', 'tb_carne.valor_prestacao', 'tb_carne.Ano_Letivo', 'tb_turmas.NomeTurma', 'tb_carne.valor_Acordo', 'tb_pais.Responsavel', 'tb_pais.CPFResponsavel', 'tb_pais.RGResponsavel', 'tb_pais.FonePai1', 'tb_pais.FonePai2', 'tb_pais.FoneMae1', 'tb_pais.FoneMae2')
                        ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        ->groupBy('tb_carne.tb_turmas_idTurmas')
                        //   ->groupBy('tb_aluno.tb_aluno.NomeAluno')
                        ->get();
    }

    // Selecionando todos os boletos em aberto  
      public static function boletosAbertos() {
        return tb_carne::select()
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->where('status_pagamento', 'ABERTO')
                        ->get();
    }
    
    
    
    // verificando quantos boletos tem no total
      public static function quantosBoletos() {
        return tb_carne::select()
                        ->count();
    }
    // verificando quantos boletos tem Abertos
      public static function quantosBoletosAberto() {
        return tb_carne::select()
                ->where('tb_carne.status_pagamento', "ABERTO" )
                        ->count();
    }
    // verificando quantos boletos tem Pagos
      public static function quantosBoletosPagos() {
        return tb_carne::select()
                ->where('tb_carne.status_pagamento', "PAGO" )
                        ->count();
    }
    // verificando quantos boletos tem Parcial
      public static function quantosBoletosParcial() {
        return tb_carne::select()
                ->where('tb_carne.status_pagamento', "Parcial" )
     ->count();
    }

    
    
    
    
    
    
    // somando quanto tem para receber
      public static function quantoTemPraReceber() {
       $receber = tb_carne::select()
        ->select('tb_carne.tb_turmas_Mensalidade')
        ->get();
        $receber = $receber->sum('tb_turmas_Mensalidade');
        return $receber;
}



    // somando quanto tem para receber
      public static function quantoTemEmAtrazo($Mes,$Turma) {
         $atrasados = tb_carne::select()
        ->select('tb_carne.tb_turmas_Mensalidade')
            
        ->where('tb_carne.Meses','=', $Mes)
        ->where('tb_carne.tb_turmas_idTurmas', '=', $Turma)
        ->where('tb_carne.status_pagamento','=', "ABERTO" )
      
        ->get();
        $atrasados = $atrasados->sum('tb_turmas_Mensalidade');
        return $atrasados;
}









    // somando quanto tem para receber de uma turma por mes
      public static function quantoTemEmAtrazoTurmaMes($Mes,$Turma) {
         $atrasados = tb_carne::select()
        ->select('tb_carne.tb_turmas_Mensalidade')
                 
        ->where('tb_carne.Meses','=', $Mes)
        ->where('tb_carne.tb_turmas_idTurmas', '=', $Turma)
        ->where('tb_carne.status_pagamento','=', "ABERTO" )
      
        ->get();
        $atrasados = $atrasados->sum('tb_turmas_Mensalidade');
        return $atrasados;
}





    // verificando quantos tem em atraso
      public static function quantosEmAtraso($data) {
  $atrasados = tb_carne::select()
  ->select  ('Data_venc')
  ->orderBy('Data_venc', 'asc')
  ->where('Data_venc', "<" ,"$data")
  ->get();
  return $atrasados;
}
    




    // somando quanto tem para receber 
      public static function FiltroRelatoriosFinanceiroMesalidades($dadosForm) {
 
                $Boletos = tb_carne::select()
                ->where('tb_carne.status_pagamento', '=', $dadosForm["status_pagamento"])
                ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
                ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
               
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
          
                        
                        
                        
                            ->select(
                                'tb_carne.idcarne',
                                'tb_turmas.NomeTurma',
                                'tb_turmas.Mensalidade',
                                'tb_aluno.NomeAluno',
                                'tb_carne.RA',
                                'tb_carne.Meses',
                                'tb_carne.parcelas',
                                'tb_carne.Ano_Letivo',
                                'tb_carne.tb_turmas_Mensalidade',
                                'tb_carne.ValorPGTO',
                                'tb_carne.valor_prestacao',
                                'tb_carne.Carteira',
                                'tb_carne.Data_venc',
                                'tb_carne.data_pagamento',
                                'tb_carne.status_pagamento',
                                'tb_pais.FonePai1',
                                'tb_pais.Responsavel',
                                'tb_pais.CPFResponsavel',
                                'tb_pais.RGResponsavel',
                                'tb_pais.FoneMae1',
                                'tb_matriculas.Bonus'
                                    ) 
                ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                ->whereRaw('tb_pais_idPais = tb_aluno.tb_pais_idPais')
             //   ->groupBy('tb_carne.tb_turmas_idTurmas')
                ->groupBy('tb_carne.tb_aluno_idAluno')
                        ->orderBy('tb_aluno.NomeAluno')                    
  ->get();
  return $Boletos;
}
    // somando quanto tem para receber de um determinado ano
      public static function FiltroRelatoriosFinanceiroBalanco($Ano) {
                $Balanco = tb_carne::select()
                ->where('tb_carne.Ano_Letivo', '=', $Ano)
             //   ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
          //      ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
                 ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
            //    ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
            //    ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                            ->select(
                         //       'tb_carne.idcarne',
                                'tb_turmas.NomeTurma',
                           //     'tb_aluno.NomeAluno',
                       //         'tb_carne.RA',
                        //        'tb_carne.Meses',
                        //        'tb_carne.parcelas',
                        //        'tb_carne.Ano_Letivo',
                         //       'tb_carne.tb_turmas_Mensalidade',
                         //       'tb_carne.ValorPGTO',
                          //      'tb_carne.valor_prestacao',
                          //      'tb_carne.Carteira',
                           ////     'tb_carne.Data_venc',
                           //     'tb_carne.data_pagamento',
                                'tb_carne.status_pagamento')

            //    ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
             //   ->whereRaw('tb_pais_idPais = tb_aluno.tb_pais_idPais')
             //   ->groupBy('tb_carne.tb_turmas_idTurmas')
              //  ->groupBy('tb_carne.tb_aluno_idAluno')
                    //    ->orderBy('tb_aluno.NomeAluno')                    
  ->get();
  return $Balanco;
}

  // somando quanto tem para receber de uma turma
      public static function FiltroRelatoriosFinanceiroMesalidadesTurma($dadosForm) {
 
                $Boletos = tb_carne::select()
                
                ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
                ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
                 ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        
                        
             //   ->select('tb_aluno.NomeAluno', 'tb_carne.*', 'tb_turmas.NomeTurma', 'tb_turmas.Mensalidade')
                        
                            ->select(
                                'tb_carne.idcarne',
                                'tb_turmas.NomeTurma',
                                'tb_aluno.NomeAluno',
                                'tb_carne.RA',
                                'tb_carne.Meses',
                                'tb_carne.parcelas',
                                'tb_carne.Ano_Letivo',
                                'tb_carne.tb_turmas_Mensalidade',
                                'tb_carne.ValorPGTO',
                                'tb_carne.valor_prestacao',
                                'tb_carne.Carteira',
                                'tb_carne.Data_venc',
                                'tb_carne.data_pagamento',
                                'tb_carne.status_pagamento',
                                'tb_pais.FonePai1',
                                'tb_pais.FoneMae1') 
                ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                ->whereRaw('tb_pais_idPais = tb_aluno.tb_pais_idPais')
             //   ->groupBy('tb_carne.tb_turmas_idTurmas')
                ->groupBy('tb_carne.tb_aluno_idAluno')
                        ->orderBy('tb_aluno.NomeAluno')
                        
                       
  ->get();
  return $Boletos;

}






    // somando quanto tem para receber balanco
      public static function TotalAbertosBalanco($dadosForm) {
         $atrasados = tb_carne::select()
        ->select('tb_carne.tb_turmas_Mensalidade')  
        ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
        ->where('tb_carne.status_pagamento','=', "ABERTO" )
        ->get();
        $atrasados = $atrasados->sum('tb_turmas_Mensalidade');
        return $atrasados;
}



    // somando quanto já foi recebido quando filtrado em pesquisa Turma e Mes
      public static function TotalRecebidoBalanco($dadosForm) {
  $recebido = tb_carne::select()
        ->select('tb_carne.ValorPGTO')
        ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
        ->get();
        $recebido = $recebido->sum('ValorPGTO');
        return $recebido;
}


       // somando quanto tem para receber
      public static function TotalParaReceberBalanco($dadosForm) {
       $receber = tb_carne::select()
        ->select('tb_carne.tb_turmas_Mensalidade')
        ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
        ->get();
        $receber = $receber->sum('tb_turmas_Mensalidade');
        return $receber;
}




    // verificando quantos boletos tem Abertos
      public static function quantosBoletosAbertoBalanco($dadosForm) {
        return tb_carne::select()
                
                ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
                ->where('tb_carne.status_pagamento', "ABERTO" )
                ->count();
    }
    // verificando quantos boletos tem Pagos
      public static function quantosBoletosPagosBalanco($dadosForm) {
        return tb_carne::select()
                ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
                ->where('tb_carne.status_pagamento', "PAGO" )
                        ->count();
    }
    // verificando quantos boletos tem Parcial
      public static function quantosBoletosParcialBalanco($dadosForm) {
        return tb_carne::select()
                ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
                ->where('tb_carne.status_pagamento', "PARCIAL" )
     ->count();
    }

        // verificando quantos boletos tem no total filtrado no campo pesquisa
      public static function quantosBoletosFiltradosBalanco($dadosForm) {
        return tb_carne::select()
               ->where('tb_carne.Ano_Letivo', '=', $dadosForm["Ano"])
                ->count();
    }









    // verificando quantos boletos tem no total filtrado no campo pesquisa
      public static function quantosBoletosFiltrados($dadosForm) {
        return tb_carne::select()
                
                ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
                ->where('tb_carne.status_pagamento', '=', $dadosForm["status_pagamento"])
                ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
                ->count();
    }
    // verificando quantos boletos tem no total filtrado no campo pesquisa por turma e mes
      public static function quantosBoletosFiltradosTurmaMes($dadosForm) {
        return tb_carne::select()
                
                ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
                ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
                ->count();
    }


   
    // somando quanto já foi recebido quando filtrado em pesquisa
      public static function quantoTemRecebidoFiltrado($dadosForm) {
  $recebido = tb_carne::select()
        ->select('tb_carne.ValorPGTO')
          ->where('tb_carne.status_pagamento', '=', $dadosForm["status_pagamento"])
          ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
          ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
        ->get();
        $recebido = $recebido->sum('ValorPGTO');
        return $recebido;
}
    // somando quanto já foi recebido quando filtrado em pesquisa Turma e Mes
      public static function quantoTemRecebidoFiltradoTurmaeMes($dadosForm) {
  $recebido = tb_carne::select()
        ->select('tb_carne.ValorPGTO')
            ->where('tb_carne.Meses', '=', $dadosForm["Meses"])
          ->where('tb_carne.tb_turmas_idTurmas', '=', $dadosForm["idTurmas"])
        ->get();
        $recebido = $recebido->sum('ValorPGTO');
        return $recebido;
}







    // somando quanto já foi recebido
      public static function quantoTemRecebido() {
  $recebido = tb_carne::select()
        ->select('tb_carne.ValorPGTO')
        ->get();
        $recebido = $recebido->sum('ValorPGTO');
        return $recebido;
}

    
    
    
    
    
    
    // Selecionando todos os boletos
    public static function boletosTodos() {
        return tb_carne::select()
                      ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                      ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                      ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                      ->whereRaw('tb_turmas.idTurmas = tb_carne.tb_turmas_idTurmas')
                      ->whereRaw('tb_aluno_idAluno = tb_carne.tb_aluno_idAluno')
                      ->whereRaw('tb_pais_idPais = tb_aluno.tb_pais_idPais')
                    
                      ->select(
                                'tb_carne.idcarne',
                                'tb_turmas.NomeTurma',
                                'tb_aluno.NomeAluno',
                                'tb_carne.RA',
                                'tb_carne.Meses',
                                'tb_carne.parcelas',
                                'tb_carne.Ano_Letivo',
                                'tb_carne.tb_turmas_Mensalidade',
                                'tb_carne.ValorPGTO',
                                'tb_carne.valor_prestacao',
                                'tb_carne.Carteira',
                                'tb_carne.Data_venc',
                                'tb_carne.data_pagamento',
                                'tb_carne.status_pagamento',
                                'tb_pais.FonePai1',
                                'tb_pais.FoneMae1')
                
                 
                
      //  ->where('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
      //->where('tb_aluno_idAluno = tb_carne.tb_aluno_idAluno' and 'tb_turmas.idTurmas = tb_carne.tb_turmas_idTurmas')
      //  where comprados.usuarios_id = usuarios.cpf  and  comprados.cursos_id = cursos.id;
      
          //   ->where('status_pagamento','PAGO')
          //  (condição1 AND condição2) OR condição3
          //   ->where('tb_carne.status_pagamento', "PARCIAL" or 'tb_carne.status_pagamento', "ABERTO") 
          //   ->where('tb_carne.status_pagamento', "ABERTO" )
          //   ->where('tb_carne.status_pagamento', "PAGO")
          
         ->groupBy('tb_carne.idcarne','tb_carne.tb_aluno_idAluno')
   //  ->groupBy('tb_carne.tb_aluno_idAluno')
          //  ->groupBy('tb_aluno_idAluno')
       ->groupBy('tb_aluno.NomeAluno')
          //  ->groupBy('tb_turmas.NomeTurma')
       ->orderBy('idcarne')
                
                         
                        ->paginate(20);
    }
    
    
                              
    
    
    

    // Metodo que pesquisa o boleto informado pelo codigo de barras
    public static function pesqBoletoInformado($CodigoBarrasInformado,$AnoLetivo) {
        return tb_carne::select()
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->select('tb_aluno.NomeAluno', "tb_carne.*", 'tb_turmas.NomeTurma')
                        ->where('tb_carne.codbarras', 'LIKE', "%$CodigoBarrasInformado%")
                        ->where('tb_carne.Ano_Letivo',  $AnoLetivo)
                        // Condição entre duas tabelas
                       ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        //->groupBy('tb_carne.tb_turmas_idTurmas')
                        ->get();
    }
    
    
    
    // Metodo que pesquisa boletos diacordo com o ano
    public static function pesqBoletoInformadoComAno($CodigoBarrasInformado, $AnoLetivo) {
        return tb_carne::select()
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->select('tb_aluno.NomeAluno', "tb_carne.*", 'tb_turmas.NomeTurma')
                        ->where('tb_carne.codbarras', 'LIKE', "%$CodigoBarrasInformado%")
                        // Condição entre duas tabelas
                       ->where('tb_carne.Ano_Letivo', '!=' , $AnoLetivo)
                    //  ->where('tb_carne.Meses','=', $Mes)
                      ->where('tb_carne.status_pagamento','!=', "PAGO" )
                      ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        //->groupBy('tb_carne.tb_turmas_idTurmas')
                        ->get();
    }
    // Metodo que pesquisa boletos diacordo com o ano
    public static function SegundaViaAnosAnteriores($CodigoBarrasInformado, $AnoLetivo) {
        return tb_carne::select()
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_carne.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->select('tb_aluno.NomeAluno', "tb_carne.*", 'tb_turmas.NomeTurma')
                        ->where('tb_carne.codbarras', 'LIKE', "%$CodigoBarrasInformado%")
                        // Condição entre duas tabelas
                       ->where('tb_carne.Ano_Letivo', '<>' , $AnoLetivo)
                    //  ->where('tb_carne.Meses','=', $Mes)
                      ->where('tb_carne.status_pagamento','!=', "ABERTO" )
                      ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        //->groupBy('tb_carne.tb_turmas_idTurmas')
                      ->get();
    }

    
    
    
    
    
    public static function AlunoBoleto($CodigoBarrasInformado) {
        return tb_carne::select()
                        ->join('tb_aluno', 'tb_aluno_idAluno', '=', 'tb_carne.tb_aluno_idAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_pais.NomePai', 'tb_pais.NomeMae','tb_turmas.AnoLetivo')
                        ->where('tb_carne.codbarras', 'LIKE', "%$CodigoBarrasInformado%")
                        // Condição entre duas tabelas
                        ->whereRaw('tb_aluno.idAluno = tb_carne.tb_aluno_idAluno')
                        ->groupBy('tb_aluno.NomeAluno')
                        //->groupBy('tb_carne.tb_turmas_idTurmas')
                        ->get();
    }

    
    
    public static function DadosContrato($AnoLetivo,$RA) {
        return tb_carne::select()
                                
                       ->select('tb_carne.*')
                       ->where('tb_carne.RA', $RA)
                       ->where('tb_carne.Ano_Letivo', $AnoLetivo)
                       ->get();
    }
    // Valor do Contrato
    public static function ValorDoContrato($AnoLetivo,$RA) {
       $valorMesalidades = tb_carne::select()        
                       ->select('tb_carne.tb_turmas_Mensalidade')
                       ->where('tb_carne.RA', $RA)
                       ->where('tb_carne.Ano_Letivo', $AnoLetivo)
                       ->get();
      $valor_contrato = $valorMesalidades ->sum('tb_turmas_Mensalidade');
      return   $valor_contrato;        
    }
    
    
    //Valor Mensal
    public static function ValorMensal($AnoLetivo,$RA) {
       $valorMensal = tb_carne::select()        
                       ->select('tb_carne.tb_turmas_Mensalidade','tb_carne.codbarras','tb_carne.parcelas')
               
               
                       ->where('tb_carne.RA', $RA)
                       ->where('tb_carne.Ano_Letivo', $AnoLetivo)
                       ->get();
       return   $valorMensal;        
    }
    
    //Quantidade de Parcelas
    public static function QuantidadeParcelasContrato($AnoLetivo,$RA) {
       $quantidadeParcelas = tb_carne::select()        
                       ->select('tb_carne.tb_turmas_Mensalidade')
                       ->where('tb_carne.RA', $RA)
                       ->where('tb_carne.Ano_Letivo', $AnoLetivo)
                       ->count();
      return   $quantidadeParcelas;        
    }
    
    
    
    
    
    
    
    
    
    
    

    // Metodo que pesquisa o valor total recebido de mensalidades no dia atual
    public static function ValorPGTO_Dia($data_pagamento) {
        $ValorPGTO = tb_carne::select()
                ->select('tb_carne.ValorPGTO')
                ->where('tb_carne.data_pagamento', "$data_pagamento")
                ->get();
        $ValorPGTO_Dia = $ValorPGTO->sum('ValorPGTO');
        return $ValorPGTO_Dia;
    }

    
    
    
    
// Metodo que atualiza os dados de um recebimento que ja foi realizado de forma parcial.
    public static function AtualizarPagamento($dadosForm) {
        $idcarne = $dadosForm["idcarne"];
        $Entrada = $dadosForm["ValorPGTO"];
        $porconta = $dadosForm["porconta"];
//    dd("Valor Total Pago:","fdgsdfgsdf", "Valor Pago: ", $Entrada,  "Por Conta: ", $porconta);
       if ($porconta == 0) {
        $ValorTotalPGTO = $dadosForm["ValorPGTO"];
            // dd($ValorPGTO,$Entrada,$porconta);
        } else {
            $ValorTotalPGTO = $Entrada + $porconta;
//  dd("Valor Total Pago:",$ValorTotalPGTO, "Valor Pago: ", $Entrada,  "Por Conta: ", $porconta);
} 
         $Atualizar = [
            'ValorPGTO' => $ValorTotalPGTO,
            'obs_pagamento' => $obs_pagamento = $dadosForm["obs_pagamento"],
            'data_pagamento' => $data_pagamento = $dadosForm["data_pagamento"],
            'status_pagamento' => $status_pagamento = $dadosForm["status_pagamento"],
            'forma_pgto' => $forma_pgto = $dadosForm["forma_pgto"],
        ];
        $AtualizarDados = tb_carne::select()
                ->select('tb_carne.*')
                ->where('tb_carne.idcarne', "$idcarne")
                ->update($Atualizar);
        return $AtualizarDados;
    }
    
    
    
    
    
    

// Metodo que atualiza os dados de um recebimento que ja foi realizado de forma parcial.
    public static function AtualizarPagamentoAcordo($dadosForm) {

        $idcarne = $dadosForm["idcarne"];
        $Entrada = $dadosForm["ValorPGTO"];
        $porconta = $dadosForm["porconta"];

        if ($porconta == '') {
            $ValorTotalPGTO = $dadosForm["ValorPGTO"];
            // dd($ValorPGTO,$Entrada,$porconta);
        } else {
            $ValorTotalPGTO = $Entrada + $porconta;
            //   dd("Valor Total Pago:",$ValorPGTO, "Valor Pago: ", $Entrada,  "Por Conta: ", $porconta);
        }
        $Atualizar = [
            'ValorPGTO' => $ValorTotalPGTO,
            'obs_pagamento' => $obs_pagamento = $dadosForm["obs_pagamento"],
            'data_pagamento' => $data_pagamento = $dadosForm["data_pagamento"],
            'status_pagamento' => $status_pagamento = $dadosForm["status_pagamento"]
        ];
        $AtualizarDados = tb_carne::select()
                ->select('tb_carne.*')
                ->where('tb_carne.idcarne', "$idcarne")
                ->update($Atualizar);
        return $AtualizarDados;
    }

// Metodo que pesquisa a quantidade de mensalidades pagare no dia atual
    public static function Quant_Dia($data_pagamento) {
        $Quant_Dia = tb_carne::select()
                ->select('tb_carne.ValorPGTO')
                ->where('tb_carne.data_pagamento', "$data_pagamento")
                ->count();
        return $Quant_Dia;
    }

}

// Fim do Criando o carner no banco de dados.

