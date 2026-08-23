<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_carne;
use App\Models\modelCoordenacao\tb_pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\modelCoordenacao\tb_escola;
use Carbon\Carbon;

// Controle (metodos) do modulo turma.
class cont_recibos extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_escola;
    private $tb_aluno;
    private $tb_carne;
    private $tb_pais;

    public function __construct(Request $dadosForm, tb_aluno $tb_aluno, tb_escola $tb_escola, tb_turma $tb_turma, tb_carne $tb_carne, tb_pais $tb_pais, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_escola = $tb_escola;
        $this->tb_aluno = $tb_aluno;
        $this->tb_carne = $tb_carne;
        $this->tb_pais = $tb_pais;
    }

//Metodo Para Direcionar página inicial de recibos
    public function index() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAlunoComBoletosRegistrados();
       // $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.recibos.recibos', compact('Alunos', 'turmas'));
    }

   
    //Metodo pesquisar aluno por palavra chave
    public function recibo_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisarAlunoBoleto($palavrachave);
        return view('telasCoordenacao.recibos.recibo_pesq', compact('Alunos', 'turmas'));
    }

    
//Metodo pesquisar carnê por filtro de turma
    public function recibo_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.recibos.recibos', compact('Alunos', 'turmas'));
    }

    //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function carner($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        abort_if(!$aluno, 404);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        // Gerando o desconto caso exista.
        $Desconto = $matricula["Bonus"] ?? 0;
        if ($Desconto == 0) {
            $Mensalidade = $turma["Mensalidade"] ?? 0;
        } else {
            $MensalidadeSemDesconto = (float)($turma["Mensalidade"] ?? 0);
            $percentualDeDesconto = (float)$Desconto / 100.00;
            $Mensalidade = $MensalidadeSemDesconto - ( $percentualDeDesconto * $MensalidadeSemDesconto );
        }
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Carnê de Pagamento';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('telasCoordenacao.recibos.recibo_carner', compact('aluno', 'matricula', 'titulo', 'turma', 'escolas', 'Mensalidade'));
        return $pdf->setPaper('a4', 'portrait')->stream('carne_'.$idAluno.'.pdf');
    }

    //Metodo que busca os dados para gerar o recibo de uma mensalidade já paga
    public function recibo_mensalidade($idcarne) {
        $boleto_unico = tb_carne::busca_boleto_especifico($idcarne);
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Comprovante de Pagamento';
        return view('telasCoordenacao.recibos.recibo_mensalidade', compact('titulo', 'escolas', 'boleto_unico'));
    }

//Metodo que busca os dados para gerar o recibo de um acordo já pago
    public function recibo_acordo($idcarne) {
        $boleto_unico = tb_carne::busca_boleto_especifico($idcarne);
        // dd($boleto_unico);  
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Comprovante de Pagamento';
        return view('telasCoordenacao.recibos.recibo_acordo', compact('titulo', 'escolas', 'boleto_unico'));
    }

    //Metodo que GERA O CARNER COM CODIGO DE BARRAS
    public function carner_codigo_de_barras($idAluno) {
        $boletos = tb_carne::busca_dados_boletos($idAluno);
        $cabecarios = tb_carne::busca_cabecario_boletos($idAluno);
        $titulo = 'Boletos';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.recibos.recibo_boleto', compact('titulo', 'boletos', 'cabecarios')));
        return $pdf->stream();
        //return view('telasCoordenacao.recibos.recibo_boleto', compact('aluno', 'matricula','titulo','turma','escolas','boletos','pais'));  
    }

    //Metodo que GERA O CARNER COM CODIGO DE BARRAS de uma acordo
    public function acordo_codigo_de_barras($idAluno) {
        $boletos = tb_carne::busca_dados_boletos_Acordo($idAluno);
        $cabecarios = tb_carne::busca_cabecario_boletos_acordo($idAluno);
        //   dd($cabecarios);    
        // dd($cabecarios);
        $titulo = 'Boletos';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML( view('telasCoordenacao.recibos.recibo_boleto_acordo', compact('titulo', 'boletos', 'cabecarios')));
        return $pdf->stream();
        //return view('telasCoordenacao.recibos.recibo_boleto', compact('aluno', 'matricula','titulo','turma','escolas','boletos','pais'));  
  // tem que desbloquear esse aqui para funcionar, pois o pdf stream não funciona mais: 
           //                return view('telasCoordenacao.recibos.recibo_boleto_acordo', compact('titulo', 'boletos', 'cabecarios'));

        
        
        
    }
    

//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function matricula($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
      
        
        

        /* UMA PARTE DO CODIGO FOI BLOQUEADO PQ NAS MATRICULAS PROMOCIONAIS NÃO HÁ DESCONTO A OFERTAR, APOS O PERÍODO PROMOCIONAL TEM QUE ATIVAR NOVAMETE O DESCONTO DA MATRICULA. */
        
// Codigo de Desconto de mensalidade.
  //      $Desconto = $matricula["Bonus"];
 //       if ($Desconto == 0) {
            $ValorPGTO = $matricula["ValorPGTO"];
 //       } else {
 //           $ValorPGTOIntegral = $matricula["ValorPGTO"];
  //          $Desconto = $matricula["Bonus"];
  //          $percentualDeDesconto = $Desconto / 100.00;
   //         $ValorPGTO = $ValorPGTOIntegral - ( $percentualDeDesconto * $ValorPGTOIntegral );
   //     }
               
        //Fim Condigo de porcentagem
            
            
            
         $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Carner de Pagamento';
        return view('telasCoordenacao.recibos.recibo_matricula', compact('aluno', 'matricula', 'pais', 'titulo','turma', 'escolas', 'ValorPGTO'));
        // Gerando o PDF 
        /* $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML(view('telasCoordenacao.recibos.recibo_carner', compact('aluno', 'matricula','pais','titulo','turma','escolas')));
          return $pdf->stream();
         */
    }
//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function matricula_acompanhamento($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $mes = cont_datas::mes();
        $dia = ' ' . Carbon::now()->format('d') . ' de '. $mes .' de ' . Carbon::now()->format('Y'); 
        
        

        /* UMA PARTE DO CODIGO FOI BLOQUEADO PQ NAS MATRICULAS PROMOCIONAIS NÃO HÁ DESCONTO A OFERTAR, APOS O PERÍODO PROMOCIONAL TEM QUE ATIVAR NOVAMETE O DESCONTO DA MATRICULA. */
        
// Codigo de Desconto de mensalidade.
  //      $Desconto = $matricula["Bonus"];
 //       if ($Desconto == 0) {
            $ValorPGTO = $matricula["ValorPGTO"];
 //       } else {
 //           $ValorPGTOIntegral = $matricula["ValorPGTO"];
  //          $Desconto = $matricula["Bonus"];
  //          $percentualDeDesconto = $Desconto / 100.00;
   //         $ValorPGTO = $ValorPGTOIntegral - ( $percentualDeDesconto * $ValorPGTOIntegral );
   //     }
               
        //Fim Condigo de porcentagem
            
            
            
         $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Carner de Pagamento';
        return view('telasCoordenacao.recibos.recibo_matricula_acompanhamento', compact('aluno', 'matricula', 'pais', 'titulo','dia', 'turma', 'escolas', 'ValorPGTO'));
        // Gerando o PDF 
        /* $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML(view('telasCoordenacao.recibos.recibo_carner', compact('aluno', 'matricula','pais','titulo','turma','escolas')));
          return $pdf->stream();
         */
    }
    
    
    
//Metodo que busca os dados para elaborar o contrato
    public function contrato($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
     
   /*     ACHO QUE NÃO VOU USAR, POIS QUERO OS DADOS DO FINANCEIRO JA SALVOS

        // Codigo de Desconto de mensalidade.
                        $Desconto = $matricula["Bonus"];
                        if ($Desconto == 0) {
                            $ValorPGTO = $matricula["ValorPGTO"];
                        } else {
                            $ValorPGTOIntegral = $matricula["ValorPGTO"];
                            $Desconto = $matricula["Bonus"];
                            $percentualDeDesconto = $Desconto / 100.00;
                            $ValorPGTO = $ValorPGTOIntegral - ( $percentualDeDesconto * $ValorPGTOIntegral );
                        }
                        //Fim Condigo de porcentagem
                        
         */               
                        
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Contrato';
        $AnoLetivo = $turma["AnoLetivo"];
        $RA = $matricula["RA"];
        $valor_contrato = tb_carne::ValorDoContrato($AnoLetivo,$RA);
        $valor_mensal = tb_carne::ValorMensal($AnoLetivo,$RA);
        
        $quantidadeParcelasContrato = tb_carne::QuantidadeParcelasContrato($AnoLetivo, $RA);
        
     //  dd($matricula);        
     // dd($valor_contrato);
        
        return view('telasCoordenacao.recibos.recibo_contrato', compact('aluno', 'matricula', 'pais', 'titulo', 'turma', 'escolas', 'valor_contrato', 'quantidadeParcelasContrato','valor_mensal'));
        // Gerando o PDF 
        /* $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML(view('telasCoordenacao.recibos.recibo_carner', compact('aluno', 'matricula','pais','titulo','turma','escolas')));
          return $pdf->stream();
         */
    }

    
    
    
    
    /*
     * ABAIXO APENAS REFERENTE A CARNÊR COM CODIGOS DE BARRAS
     */

    //Metodo Para Direcionar ao cadastro de um Carnê
    public function novoCarne() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.carne.carne_cad', compact('turmas', 'Alunos'));
    }

    //Metodo Para Direcionar ao cadastro de um Acordo
    public function novoAcordo() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::todosAlunos();
        return view('telasCoordenacao.acordo.acordo_cad', compact('turmas', 'Alunos'));
    }

    //Metodo que apenas busca o dados para criar o carnê.
    public function criarCarne($idAluno) {
        
        
        
        $aluno = $this->tb_aluno->find($idAluno);
        $endereco = $aluno->endAluno;
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $Desconto = $matricula["Bonus"];
        if ($Desconto == 0) {
            $Mensalidade = $turma["Mensalidade"];
        } else {
            $MensalidadeSemDesconto = floatval($turma["Mensalidade"]); // foi adicionado o metodo floatval para converte a string em numero
            $Desconto = floatval($matricula["Bonus"]);
            $percentualDeDesconto = floatval($Desconto / 100.00);
            $Mensalidade = $MensalidadeSemDesconto - ($percentualDeDesconto * $MensalidadeSemDesconto );
           //dd($Mensalidade);    
        }
        $titulo = 'Novo Carnê';
        return view('telasCoordenacao.carne.carne_criar', compact('aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma', 'Mensalidade'));
    }

//Metodo que cria o carnê  
    public function criando() {
// recebendo dados informados
        $dadosForm = $this->request->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_carne::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        /*
          $salvando = tb_carne::SalveCarne($dadosForm);
          if ($salvando == 1) {
          return 'carnerjaexistente';
          } else {
          //  $salvando = tb_carne::salvandoCarner($dadosForm);
          return 'carnecadastrado';
          }
          Modelo que salva antigo, ccoloquei tudo em um so metodo chamado SalveCarnê, vou deixar tanto esse codigo
          sALVANDO Quanto o outro
         *   */
        //  $teste = tb_carne::verificarCarne($dadosForm);
        //  dd($teste);
        if (tb_carne::verificarCarne($dadosForm)) {
            return 'carnerjaexistente';
        } else {
            $salvando = tb_carne::salvandoCarner($dadosForm);
            return 'carnecadastrado';
        }
    }

    //Metodo que direciona ao formulario da criação de um acordo
    public function criarAcordo($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $endereco = $aluno->endAluno;
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Novo Acordo';
        return view('telasCoordenacao.acordo.acordo_criar', compact('aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma'));
    }

//Metodo que cria o acordo
    public function criando_acordo() {
// recebendo dados informados
        $dadosForm = $this->request->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_carne::$camposObgAcordo);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        if (tb_carne::verificaraAcordo($dadosForm)) {
            return 'acordojaexistente';
        } else {
            $salvando = tb_carne::salvandoAcordo($dadosForm);
            return 'acordocadastrado';
        }
    }

    //Metodo que faz um filtro por turma para gerar carne
    public function carne_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.carne.carne_filtro', compact('Alunos', 'turmas'));
    }
    //Metodo que faz um filtro por turma para gerar acordo
    public function acordo_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.acordo.acordo_filtro', compact('Alunos', 'turmas'));
    }

    //Metodo pesquisar aluno por palavra chave
    public function carne_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.carne.carne_pesq', compact('Alunos', 'turmas'));
    }
    //Metodo pesquisar aluno por palavra chave
    public function acordo_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisarAlunoAcordo($palavrachave);
        return view('telasCoordenacao.acordo.acordo_pesq', compact('Alunos', 'turmas'));
    }

//FIM DA CLASSE CONTROLE Ddo recidos e carnes
}
