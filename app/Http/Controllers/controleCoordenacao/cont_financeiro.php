<?php

namespace App\Http\Controllers\controleCoordenacao;

//require __DIR__ . '/vendor/autoload.php';
use App\Models\modelCoordenacao\tb_categoria;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_carne;
use App\Models\modelCoordenacao\tb_escola;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Twilio\Rest\Client;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use TotalVoice\Client as TotalVoiceClient;

//Controle (metodos) principais do modulo Lanche
class cont_financeiro extends Controller {

    private $request;
    private $validator;
    private $tb_escola;
    private $tb_carne;

    public function __construct(Request $dadosForm, tb_carne $tb_carne, tb_escola $tb_escola, tb_categoria $tb_categoria, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_carne = $tb_carne;
        $this->tb_escola = $tb_escola;
        $this->tb_categoria = $tb_categoria;
    }

//Metodo que vai pra página para o recebimento do boleto
    public function financeiro_receber() {
        
        $AnosLetivos= tb_turma::AnosLetivosExistentes();
        
       // dd($AnosLetivos);
        
        
        return view('telasCoordenacao.financeiro.financeiro_receber', compact('AnosLetivos'));
    }

//Metodo que vai pra página do relatório geral
    public function financeiro_relatorios() {      
       $QuantidadeDeBoletos = tb_carne::quantosBoletos();
       $Abertos = tb_carne::quantosBoletosAberto();
       $Parcial = tb_carne::quantosBoletosParcial();
       $Pagos = tb_carne::quantosBoletosPagos();
       $escolas = tb_escola::informacaoEscolar();
       $receber = tb_carne::quantoTemPraReceber();
       $recebido = tb_carne::quantoTemRecebido();
       $data = Carbon::now()->format('d/m/Y');
       $atrasados = tb_carne::quantosEmAtraso($data);
       $Boletos = tb_carne::boletosTodos();
       $turmas = tb_turma::turmasAtivasRelatorioFinaceiro();
         
       return view('telasCoordenacao.financeiro.financeiro_relatorios', compact('Boletos','QuantidadeDeBoletos','receber','recebido','atrasados','Abertos','Parcial','Pagos','turmas','escolas'));
    }
    
    
    
    
    
//Metodo que vai pra página para filtrar o tipo de relatorio
    public function financeiro_relatorios_2() {      
       $QuantidadeDeBoletos = tb_carne::quantosBoletos();
       $Abertos = tb_carne::quantosBoletosAberto();
       $Parcial = tb_carne::quantosBoletosParcial();
       $Pagos = tb_carne::quantosBoletosPagos();
       $escolas = tb_escola::informacaoEscolar();
       $receber = tb_carne::quantoTemPraReceber();
       $recebido = tb_carne::quantoTemRecebido();
       $data = Carbon::now()->format('d/m/Y');
       $atrasados = tb_carne::quantosEmAtraso($data);
     //  $Boletos = tb_carne::boletosTodos();
       $turmas = tb_turma::turmasAtivasRelatorioFinaceiro();
         
       return view('telasCoordenacao.financeiro.financeiro_relatorios_2', compact('QuantidadeDeBoletos','receber','recebido','atrasados','Abertos','Parcial','Pagos','turmas','escolas'));
    }

//Metodo pesquisa o titulo a ser pago
    public function financeiro_pesq() {
       // $CodigoBarrasInformado = $this->request->get('codbarras');
       $dadosForm = $this->request->all(); 
       $CodigoBarrasInformado= $dadosForm["codbarras"];
       $Aluno = tb_carne::AlunoBoleto($CodigoBarrasInformado);
      
       $AnoLetivo = $dadosForm["AnoLetivo"];
                            
       $TodosBoletos = tb_carne::pesqBoletoInformado($CodigoBarrasInformado,$AnoLetivo);
     
      
       //$OutrosBoletosAbertos = tb_carne::pesqBoletoInformadoComAno($CodigoBarrasInformado, $AnoLetivo);
       $OutrosBoletosAbertos = tb_carne::pesqBoletoInformadoComAno($CodigoBarrasInformado, $AnoLetivo);
       $SegundaViaAnosAnteriores = tb_carne::SegundaViaAnosAnteriores($CodigoBarrasInformado, $AnoLetivo);
     //  $SegundaViaAnosAnteriores = tb_carne::SegundaViaAnosAnteriores($CodigoBarrasInformado, $AnoLetivo);
     
       
       
       
       $AnosLetivos  = tb_turma::AnosLetivosExistentes();
       $Aluno = tb_carne::AlunoBoleto($CodigoBarrasInformado);
        
     //   dd($Aluno);
       
       
     //  dd($Boleto);
       
   
    //   $Boletos = tb_carne::FiltroRelatoriosFinanceiroMesalidades($dadosForm);
     //  $atrasados = tb_carne::quantoTemEmAtrazo($Mes);
     //  $QuantidadeDeBoletos = tb_carne::quantosBoletosFiltrados($dadosForm);
     //  $recebido = tb_carne::quantoTemRecebidoFiltrado($dadosForm);
    ///   O codigo de validaçã oesta comentado pq esta validado via html
        //dd($CodigoBarrasInformado);
        // dd('receber');
        /*
          $dadosForm = $this->request->all();
          $validando = Validator::make($dadosForm, tb_carne::$CodigoBarrasObrigatorio);
          if ($validando->fails()) {
          $messages = $validando->messages();
          $displayErros = '';
          foreach ($messages->all("<p>:message</p>") as $errors) {
          $displayErros .= $errors;
          } return $displayErros;
          }
         */
       // $Boleto = tb_carne::pesqBoletoInformado($CodigoBarrasInformado);
        
        
        
        $data = Carbon::now()->format('d/m/Y');
        return view('telasCoordenacao.financeiro.financeiro_baixar', compact('TodosBoletos', 'data', 'Aluno','AnosLetivos','OutrosBoletosAbertos','SegundaViaAnosAnteriores'));
    }

//Relatorio de filtro pesquisa por turma mes e situação
    public function financeiro_pesq_relatorio() {
           
       $escolas = tb_escola::informacaoEscolar();
       
     
       
       
       $dadosForm = $this->request->all(); 
       $Turma = $dadosForm["idTurmas"];
       $Mes = $dadosForm["Meses"];
       $Situacao = $dadosForm["status_pagamento"];
       $Boletos = tb_carne::FiltroRelatoriosFinanceiroMesalidades($dadosForm);      
       $atrasados = tb_carne::quantoTemEmAtrazo($Mes,$Turma);
       $QuantidadeDeBoletos = tb_carne::quantosBoletosFiltrados($dadosForm);
       $recebido = tb_carne::quantoTemRecebidoFiltrado($dadosForm);
       $turmas = tb_turma::turmasAtivasRelatorioFinaceiro();
       
     //  dd($Boletos);
       
       return view('telasCoordenacao.financeiro.financeiro_relatorios_filtro', compact('Boletos','QuantidadeDeBoletos','recebido','escolas','Mes','Situacao','atrasados','turmas'));
    }
//Relatorio de filtro pesquisa por turma e mes
    public function financeiro_pesq_relatorio_turma() {
           
       $escolas = tb_escola::informacaoEscolar();
       $dadosForm = $this->request->all(); 
       $Turma = $dadosForm["idTurmas"];
       $Mes = $dadosForm["Meses"];
       $Boletos = tb_carne::FiltroRelatoriosFinanceiroMesalidadesTurma($dadosForm);      
       $atrasados = tb_carne::quantoTemEmAtrazoTurmaMes($Mes,$Turma);
       $QuantidadeDeBoletos = tb_carne::quantosBoletosFiltradosTurmaMes($dadosForm);
       $recebido = tb_carne::quantoTemRecebidoFiltradoTurmaeMes($dadosForm);
       $turmas = tb_turma::turmasAtivasRelatorioFinaceiro();
       $Situacao = "PAGOS / PARCIAIS / ABERTOS";
    return view('telasCoordenacao.financeiro.financeiro_relatorios_filtro', compact('Boletos','QuantidadeDeBoletos','recebido','escolas','Mes','Situacao','atrasados','turmas'));
    }
//Relatorio de filtro balano anual
    public function financeiro_pesq_relatorio_balanco() {
           
     $dadosForm = $this->request->all();  
     $Ano = $dadosForm["Ano"];
     $Balanco = tb_carne::FiltroRelatoriosFinanceiroBalanco($Ano); 
     
    // dd($Balanco);
     
     
     $escolas = tb_escola::informacaoEscolar();
     $Situacao = "PAGOS / PARCIAIS / ABERTOS";
     $turmas = tb_turma::turmasAtivasRelatorioFinaceiro(); 
     
     $QuantidadeDeBoletos = tb_carne::quantosBoletosFiltradosBalanco($dadosForm);
     $Abertos = tb_carne::quantosBoletosAbertoBalanco($dadosForm);
     $Parcial = tb_carne::quantosBoletosParcialBalanco($dadosForm);
     $Pagos = tb_carne::quantosBoletosPagosBalanco($dadosForm);   
    $receber = tb_carne::TotalParaReceberBalanco($dadosForm);
    $recebido = tb_carne::TotalRecebidoBalanco($dadosForm);
   

     

       
       
    return view('telasCoordenacao.financeiro.financeiro_relatorios_balanco', compact('Balanco','escolas','Situacao','turmas','Abertos','Parcial','Pagos','receber','recebido','QuantidadeDeBoletos'));
    }
    
    
    
    
    

//Metodo que busca o carne referente ao pagamento solicitado
    public function busqueoboleto($idcarne) {
        $boleto_unico = tb_carne::busca_boleto_especifico($idcarne);
        $data = Carbon::now()->format('d/m/Y');
        // dd($boleto_unico);
        $titulo = 'Carnê de Pagamento';
        // Gerando o PDF
        // $pdf = \App::make('dompdf.wrapper');
        //  $pdf->loadHTML(view('telasCoordenacao.recibos.recibo_mensalidade', compact('aluno', 'titulo', 'escolas')));
        // return $pdf->stream();
        return view('telasCoordenacao.financeiro.financeiro_baixando_mensalidade', compact('titulo', 'boleto_unico', 'data'));
    }

//Metodo que da baixa na mensalidade ta desativado, pq resolvi usar o sistema demodal este abrir outra tela
    public function financeiro_baixando() {
// recebendo dados informados   
        $dadosForm = $this->request->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_carne::$status_pagamento);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $atualizar = tb_carne::AtualizarPagamento($dadosForm);
        if ($atualizar == true) {
            return 'pagamento';
        } else {
            return 'pagamentoErro';
        }
    }

//Metodo que da baixa na mensalidade:
    public function financeiro_baixar() {
// recebendo dados informados   
        $dadosForm = $this->request->all();
        
        
        
        
        
        
//dd($dadosForm);



// Validando dados
        $validando = Validator::make($dadosForm, tb_carne::$status_pagamento);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $atualizar = tb_carne::AtualizarPagamento($dadosForm);
        
        
        if ($atualizar == true) {
            $NomeAluno = $dadosForm["NomeAluno"];
            $NomeTurma = $dadosForm["NomeTurma"];
            $Meses = $dadosForm["Meses"];
            $codbarras = $dadosForm["codbarras"];
            $parcelas = $dadosForm["parcelas"];
            $Ano_Letivo = $dadosForm["Ano_Letivo"];
            $Mensalidade = $dadosForm["Mensalidade"];
            $ValorPGTO = $dadosForm["ValorPGTO"];
            $Carteira = $dadosForm["Carteira"];
            $Acordo = $dadosForm["Acordo"];
            $Data_venc = $dadosForm["Data_venc"];
            $data_pagamento = $dadosForm["data_pagamento"];
            $obs_pagamento = $dadosForm["obs_pagamento"];
            $status_pagamento = $dadosForm["status_pagamento"];
            $ValorPGTO_Dia = tb_carne::ValorPGTO_Dia($data_pagamento);
            $Quant_Dia = tb_carne::Quant_Dia($data_pagamento);
            $Entrada = $dadosForm["ValorPGTO"];
            $porconta = $dadosForm["porconta"];
            $forma_pgto = $dadosForm["forma_pgto"];
            
            
            if ($porconta == '') {
                $ValorTotalPGTO = $dadosForm["ValorPGTO"];
                // dd($ValorPGTO,$Entrada,$porconta);
            } else {
                $ValorTotalPGTO = $Entrada + $porconta;
                //   dd("Valor Total Pago:",$ValorPGTO, "Valor Pago: ", $Entrada,  "Por Conta: ", $porconta);
            }
// Imprimindo na impressora    
            /*
              try {
              $data = Carbon::now()->format('d /m/Y');
              $connector = new WindowsPrintConnector("TM-20");
              $printer = new Printer($connector);
              $printer->text("-----------------------------------------------\n");
              $printer->text("            COMPROVANTE DE PAGAMENTO           \n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("ALUNO:" . $NomeAluno . "\n\n");
              $printer->text("TURMA:" . $NomeTurma . "\n\n");
              $printer->text("MÊS:" . $Meses . "   ANO LETIVO:" . $Ano_Letivo . "\n\n");
              $printer->text("VALOR DA MENSALIDADE: R$ " . $Mensalidade . "  PARCELA:" . $parcelas . "\n\n");
              $printer->text("VALOR PAGO: R$ " . $Entrada . "\n\n");
              $printer->text("TOTAL PAGO: R$ " . $ValorTotalPGTO . "\n\n");
              $printer->text("STATUS DE PAGAMENTO:" . $status_pagamento . "\n\n");
              $printer->text("VENCIMENTO:" . $Data_venc . "\n\n");
              $printer->text("PAGO EM:" . $data_pagamento . "\n\n");
              $printer->text("CARTEIRA:" . $Carteira . "\n\n");
              $printer->text("ACORDO: " . $Acordo . "\n\n");
              $printer->text("AUTENTICAÇÃO:" . $codbarras . "\n\n");
              $printer->text("\n\n");
              $printer->text("------------------OBSERVAÇÕES------------------\n");
              $printer->text("\n\n");
              $printer->text($obs_pagamento . "\n\n");
              $printer->text("\n\n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("       Não temas, crê somente. Mc 5.36         \n");
              $printer->text("-----------------------------------------------\n");
              $printer->cut();

              $printer->close();
              } catch (Exception $e) {
              echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
              }
             * 
             * /* Close printer */
            // Chaves do Twilio
            $account_sid = env('TWILIO_ACCOUNT_SID', '');
            $auth_token = env('TWILIO_AUTH_TOKEN', '');
            // Meu Numero Twilio
            $twilio_number = env('TWILIO_NUMBER', '');
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                    // Numeros de telefones de testes.
                    '+5500000000000',
                    array(
                'from' => $twilio_number,
                'body' => 'Maria,' . "\n\n" . ' FOI RECEBIDO MENSALIDADE DE:' . $NomeAluno . "\n\n" . '- A IMPORTÂNCIA DE: R$' . $ValorPGTO . "\n\n" . '- MÊS DE: '
                . $Meses . "\n\n" . '- BALANÇO DIÁRIO: R$' . $ValorPGTO_Dia . "\n\n" . '- ' . $Quant_Dia . ' PAGAMENTOS NO DIA'
                    )
            );
            
            
             * * FIM DO COMENTARIO PARA BLOQUEAR O ENVIO DO SMS
        */ 
            
            
            
            return 'pagamento';
        } else {
            return 'pagamentoErro';
        }
    }

    
    
    
    
    
    
    
    
    
//Metodo que da baixa em prestação de acordos:
    public function financeiro_baixar_Acordo() {
// recebendo dados informados   
        $dadosForm = $this->request->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_carne::$status_pagamento);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $atualizar = tb_carne::AtualizarPagamento($dadosForm);
        if ($atualizar == true) {
            $NomeAluno = $dadosForm["NomeAluno"];
            $NomeTurma = $dadosForm["NomeTurma"];
            $Meses = $dadosForm["Meses"];
            $codbarras = $dadosForm["codbarras"];
            $parcelas = $dadosForm["parcelas"];
            $Ano_Letivo = $dadosForm["Ano_Letivo"];
            $valor_prestacao = $dadosForm["valor_prestacao"];
            $ValorPGTO = $dadosForm["ValorPGTO"];
            $Carteira = $dadosForm["Carteira"];
            $Acordo = $dadosForm["Acordo"];
            $Data_venc = $dadosForm["Data_venc"];
            $data_pagamento = $dadosForm["data_pagamento"];
            $obs_pagamento = $dadosForm["obs_pagamento"];
            $status_pagamento = $dadosForm["status_pagamento"];
            $ValorPGTO_Dia = tb_carne::ValorPGTO_Dia($data_pagamento);
            $Quant_Dia = tb_carne::Quant_Dia($data_pagamento);
            $Entrada = $dadosForm["ValorPGTO"];
            $porconta = $dadosForm["porconta"];
            if ($porconta == '') {
                $ValorTotalPGTO = $dadosForm["ValorPGTO"];
                // dd($ValorPGTO,$Entrada,$porconta);
            } else {
                $ValorTotalPGTO = $Entrada + $porconta;
                //   dd("Valor Total Pago:",$ValorPGTO, "Valor Pago: ", $Entrada,  "Por Conta: ", $porconta);
            }
// Imprimindo na impressora    
            /*
              try {
              $data = Carbon::now()->format('d /m/Y');
              $connector = new WindowsPrintConnector("TM-20");
              $printer = new Printer($connector);
              $printer->text("-----------------------------------------------\n");
              $printer->text("            COMPROVANTE DE PAGAMENTO           \n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("ALUNO:" . $NomeAluno . "\n\n");
              $printer->text("TURMA:" . $NomeTurma . "\n\n");
              $printer->text("MÊS:" . $Meses . "   ANO LETIVO:" . $Ano_Letivo . "\n\n");
              $printer->text("VALOR DA PARCELA: R$ " . $valor_prestacao . "  PARCELA:" . $parcelas . "\n\n");
              $printer->text("VALOR PAGO: R$ " . $Entrada . "\n\n");
              $printer->text("TOTAL PAGO: R$ " . $ValorTotalPGTO . "\n\n");
              $printer->text("STATUS DE PAGAMENTO:" . $status_pagamento . "\n\n");
              $printer->text("VENCIMENTO:" . $Data_venc . "\n\n");
              $printer->text("PAGO EM:" . $data_pagamento . "\n\n");
              $printer->text("CARTEIRA:" . $Carteira . "\n\n");
              $printer->text("ACORDO: " . $Acordo . "\n\n");
              $printer->text("AUTENTICAÇÃO:" . $codbarras . "\n\n");
              $printer->text("\n\n");
              $printer->text("------------------OBSERVAÇÕES------------------\n");
              $printer->text("\n\n");
              $printer->text($obs_pagamento . "\n\n");
              $printer->text("\n\n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("-----------------------------------------------\n");
              $printer->text("       Não temas, crê somente. Mc 5.36         \n");
              $printer->text("-----------------------------------------------\n");
              $printer->cut();
              $printer->close();
              } catch (Exception $e) {
              echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
              }
             * 
             * /* Close printer */
// TOTAL VOICE MENSAGEM SMS BRASILEIRO
//$client = new TotalVoiceClient('8c4e3ad620708c3daa7d7d8cd9f4fc49');
//$response = $client->sms->enviar('NUMERO-DESTINO', '------------'."\n\n".'RECEBIDO MENSALIDADE DE:'.$NomeAluno."\n\n".'- A IMPORTÂNCIA DE: R$'.$ValorPGTO."\n\n".'- MÊS DE: '
//        .$Meses."\n\n".'- BALANÇO DIÁRIO: R$'.$ValorPGTO_Dia."\n\n".'- '.$Quant_Dia. ' PAGAMENTOS NO DIA');
//echo $response->getContent(); // {}
//
//
//
//
            
            // Chaves do Twilio
            $account_sid = env('TWILIO_ACCOUNT_SID', '');
            $auth_token = env('TWILIO_AUTH_TOKEN', '');
            // Meu Numero Twilio
            $twilio_number = env('TWILIO_NUMBER', '');
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                    // Numeros de telefones de testes.
                    '+5500000000000',
                    array(
                'from' => $twilio_number,
                'body' => 'Maria,' . "\n\n" . 'FOI RECEBIDO REFERENTE PARCELA DE ACORDO DE:' . $NomeAluno . "\n\n" . '- A IMPORTÂNCIA DE: R$' . $ValorPGTO . "\n\n" . '- MÊS DE: '
                . $Meses . "\n\n" . '- BALANÇO DIÁRIO: R$' . $ValorPGTO_Dia . "\n\n" . '- ' . $Quant_Dia . ' PAGAMENTOS NO DIA'
                    )
            ); 
 
            
            
            return 'pagamento';
        } else {
            return 'pagamentoErro';
        }
        
        
 
        
        
        
    }

    
    
    
    
    
    
//Metodo que imprimir segunda via
    public function financeiro_comprovante() {
        $dadosForm = $this->request->all();
        $NomeAluno = $dadosForm["NomeAluno"];
        $NomeTurma = $dadosForm["NomeTurma"];
        $Meses = $dadosForm["Meses"];
        $codbarras = $dadosForm["codbarras"];
        $parcelas = $dadosForm["parcelas"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $Mensalidade = $dadosForm["Mensalidade"];
        $ValorPGTO = $dadosForm["ValorPGTO"];
        $Carteira = $dadosForm["Carteira"];
        $Acordo = $dadosForm["Acordo"];
        $Data_venc = $dadosForm["Data_venc"];
        $data_pagamento = $dadosForm["data_pagamento"];
        $obs_pagamento = $dadosForm["obs_pagamento"];
        $status_pagamento = $dadosForm["status_pagamento"];
        try {
            $data = Carbon::now()->format('d /m/Y');
            $connector = new WindowsPrintConnector("TM-20");
            $printer = new Printer($connector);
            $printer->text("-----------------------------------------------\n");
            $printer->text("       2º VIA COMPROVANTE DE PAGAMENTO         \n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("ALUNO:" . $NomeAluno . "\n\n");
            $printer->text("TURMA:" . $NomeTurma . "\n\n");
            $printer->text("MÊS:" . $Meses . "   ANO LETIVO:" . $Ano_Letivo . "\n\n");
            $printer->text("VALOR DA MENSALIDADE: R$ " . $Mensalidade . "  PARCELA:" . $parcelas . "\n\n");
            $printer->text("VALOR PAGO: R$ " . $ValorPGTO . "\n\n");
            $printer->text("STATUS DE PAGAMENTO:" . $status_pagamento . "\n\n");
            $printer->text("VENCIMENTO:" . $Data_venc . "\n\n");
            $printer->text("PAGO EM:" . $data_pagamento . "\n\n");
            $printer->text("CARTEIRA:" . $Carteira . "\n\n");
            $printer->text("ACORDO: " . $Acordo . "\n\n");
            $printer->text("AUTENTICAÇÃO:" . $codbarras . "\n\n");
            $printer->text("\n\n");
            $printer->text("------------------OBSERVAÇÕES------------------\n");
            $printer->text("\n\n");
            $printer->text($obs_pagamento . "\n\n");
            $printer->text("\n\n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("       Não temas, crê somente. Mc 5.36         \n");
            $printer->text("-----------------------------------------------\n");
            $printer->cut();
            /* Close printer */
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
        return '2via';
    }

    
    
    
//Metodo que imprimir segunda via
    public function financeiro_comprovante_acordo() {
        $dadosForm = $this->request->all();
        $NomeAluno = $dadosForm["NomeAluno"];
        $NomeTurma = $dadosForm["NomeTurma"];
        $Meses = $dadosForm["Meses"];
        $codbarras = $dadosForm["codbarras"];
        $parcelas = $dadosForm["parcelas"];
        $Ano_Letivo = $dadosForm["Ano_Letivo"];
        $valor_prestacao = $dadosForm["valor_prestacao"];
        $ValorPGTO = $dadosForm["ValorPGTO"];
        $Carteira = $dadosForm["Carteira"];
        $Acordo = $dadosForm["Acordo"];
        $Data_venc = $dadosForm["Data_venc"];
        $data_pagamento = $dadosForm["data_pagamento"];
        $obs_pagamento = $dadosForm["obs_pagamento"];
        $status_pagamento = $dadosForm["status_pagamento"];
        try {
            $data = Carbon::now()->format('d /m/Y');
            $connector = new WindowsPrintConnector("TM-20");
            $printer = new Printer($connector);
            $printer->text("-----------------------------------------------\n");
            $printer->text("       2º VIA COMPROVANTE DE PAGAMENTO         \n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("ALUNO:" . $NomeAluno . "\n\n");
            $printer->text("TURMA:" . $NomeTurma . "\n\n");
            $printer->text("MÊS:" . $Meses . "   ANO LETIVO:" . $Ano_Letivo . "\n\n");
            $printer->text("VALOR DA MENSALIDADE: R$ " . $valor_prestacao . "  PARCELA:" . $parcelas . "\n\n");
            $printer->text("VALOR PAGO: R$ " . $ValorPGTO . "\n\n");
            $printer->text("STATUS DE PAGAMENTO:" . $status_pagamento . "\n\n");
            $printer->text("VENCIMENTO:" . $Data_venc . "\n\n");
            $printer->text("PAGO EM:" . $data_pagamento . "\n\n");
            $printer->text("CARTEIRA:" . $Carteira . "\n\n");
            $printer->text("ACORDO: " . $Acordo . "\n\n");
            $printer->text("AUTENTICAÇÃO:" . $codbarras . "\n\n");
            $printer->text("\n\n");
            $printer->text("------------------OBSERVAÇÕES------------------\n");
            $printer->text("\n\n");
            $printer->text($obs_pagamento . "\n\n");
            $printer->text("\n\n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("-----------------------------------------------\n");
            $printer->text("       Não temas, crê somente. Mc 5.36         \n");
            $printer->text("-----------------------------------------------\n");
            $printer->cut();
            /* Close printer */
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
        return '2viaAcordo';
    }

    //Metodo que vai pra página de receitas e despesas
    public function financeiro_receitas_e_despesas() {
        $categorias = tb_categoria::categorias();
        //dd($categorias);
        //  $turmas = tb_turma::turmasAtivas();
        //$Alunos = tb_aluno::listagemAluno();
        // $Boletos = tb_carne::boletosAbertos();
        return view('telasCoordenacao.financeiro.financeiro_receitas_e_despesas', compact('categorias'));
    }

    //Metodo que salva uma nova receita
    public function financeiro_nova_receitas() {
        $dadosForm = $this->request->all();
        dd($dadosForm);
        return view('telasCoordenacao.financeiro.financeiro_receitas_e_despesas');
    }

    //Metodo que salva uma nova categoria
    public function financeiro_nova_categoria() {
        $dadosForm = $this->request->all();
        $validando = Validator::make($dadosForm, tb_categoria::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
// Chama o metodo verificar se a categoria já exite. o parametro para consultar e ja verifica se esta vazio
        $verificar = tb_categoria::verificarCategoraExiste($dadosForm)->isEmpty();
        if ($verificar == true) {
            tb_categoria::create($dadosForm);
            return 1;
            // return view('telasCoordenacao.financeiro.financeiro_receitas_e_despesas');
        } else {
            return 'Desculpe, essa categoria já está cadastrada !';
        }
    }

    //Metodo que vai pra página de estatisticas
    public function financeiro_estatistica() {
        // $turmas = tb_turma::turmasAtivas();
        //$Alunos = tb_aluno::listagemAluno();
        // $Boletos = tb_carne::boletosAbertos();
        return view('telasCoordenacao.financeiro.financeiro_estatistica');
    }

}
