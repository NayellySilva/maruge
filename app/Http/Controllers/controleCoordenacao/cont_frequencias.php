<?php
namespace App\Http\Controllers\controleCoordenacao;
use App;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\modelCoordenacao\tb_escola;

// Controle (metodos) do modulo turma.
class cont_frequencias extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_escola;
    private $tb_aluno;
    private $tb_frequencia;

    public function __construct(Request $dadosForm,tb_aluno $tb_aluno,tb_escola $tb_escola, tb_turma $tb_turma, tb_frequencia $tb_frequencia, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_escola = $tb_escola;
        $this->tb_aluno = $tb_aluno;
        $this->tb_frequencia = $tb_frequencia;
    }
//Metodo Para Direcionar página inicial das frequencias
    public function index() {  
      $turmas = tb_turma::listandoTurmasAtivas();
      $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
      return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));   
    }
    
    
    
    
    
    
    
    
       
    
//Metodo Para Direcionar página inicial das frequencias
    public function frequencia_relatorio($idTurma) { 
        
        $titulo = 'Relatório de Frequência';
        $escolas = tb_escola::informacaoEscolar();
        $turma = $this->tb_turma->find($idTurma);
        $alunos = tb_aluno::alunosPorTurma($idTurma);
        

        
        $frequencias = tb_frequencia::buscandoFrequenciadoAluno($idTurma);
        
        
    return view('telasCoordenacao.frequencia.frequencia_relatorio', compact('titulo','escolas','turma','alunos','frequencias'));   
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      //Metodo pesquisar uma turma por palavra chave
    public function frequencias_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisar($palavrachave);
        $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
        return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));
    }

    //Metodo pesquisar frequencias da turma por filtro Turma
    public function frequencias_filtro() {
        $idTurmas = $this->request->get('idTurmas');
        if ($idTurmas == null) {
            return redirect('/coordenacao/frequencias');
        }   
        $turmas = tb_turma::filtroporidTurmas($idTurmas);
        $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
        return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));
    }
    
    // Metodo que exibe a frequencia virtual da turma no dia selecionado (padrão: data atual de hoje formatada Y-m-d)
    public function frequencia_virtual ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        date_default_timezone_set('America/Sao_Paulo');
        
        // Usa a data recebida via request/query string se informada, senão usa now()->format('Y-m-d') como padrão
        $dataSelecionada = $this->request->get('data_chamada') 
            ?? $this->request->get('data') 
            ?? ($this->request->get('dia') && $this->request->get('mes') && $this->request->get('ano') 
                ? sprintf("%04d-%02d-%02d", (int)$this->request->get('ano'), (int)$this->request->get('mes'), (int)$this->request->get('dia')) 
                : null);

        if (!$dataSelecionada) {
            $dataSelecionada = now()->format('Y-m-d');
        }

        // Extrai ano, mês e dia para compatibilidade total com o modelo e a view
        $parts = explode('-', $dataSelecionada);
        $ano = $parts[0] ?? date('Y');
        $mes = str_pad($parts[1] ?? date('m'), 2, '0', STR_PAD_LEFT);
        $dia = str_pad($parts[2] ?? date('d'), 2, '0', STR_PAD_LEFT);

        $inf_dia = "{$dia}/{$mes}/{$ano}";
        $titulo = 'Frequência Virtual';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;

        // Busca as frequências salvas para a turma no dia/mês/ano selecionados
        $registrosDia = DB::table('tb_frequencia')
            ->where('tb_turmas_idTurmas', $idTurmas)
            ->where(function($q) use ($dia) {
                $q->where('Dia', (string)$dia)->orWhere('dia', (string)$dia);
            })
            ->where(function($q) use ($mes) {
                $q->where('Mes', (string)$mes)->orWhere('mes', (string)$mes);
            })
            ->where(function($q) use ($ano) {
                $q->where('Ano', (string)$ano)->orWhere('ano', (string)$ano);
            })
            ->get();

        $frequenciasDia = [];
        foreach ($registrosDia as $reg) {
            $alunoId = $reg->tb_aluno_idAluno;
            $sit = $reg->Presenca ?? $reg->situacao ?? 'PRESENTE';
            $frequenciasDia[$alunoId] = $sit;
        }

        return view('telasCoordenacao.frequencia.frequencia_virtual', compact(
            'titulo', 'escolas', 'ano', 'mes', 'dia', 'dataSelecionada', 'inf_dia', 'turma', 'Alunos', 'alunos', 'frequenciasDia'
        ));
    }

    public function postnovafrequencia() {
        $dadosForm = $this->request->all();

        // Se for submissão de planilha matriz
        $idTurma = $this->request->input('idTurma') ?? $this->request->input('tb_turmas_idTurmas');
        $matrix = $this->request->input('matrix');
        if ($idTurma && is_array($matrix)) {
            $mes = $this->request->input('mes', date('m'));
            $ano = $this->request->input('ano', date('Y'));
            tb_frequencia::salvarMatrizFrequencia($idTurma, $mes, $ano, $matrix);
            if ($this->request->wantsJson() || $this->request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Frequência salva com sucesso!']);
            }
            return redirect()->back()->with('success', 'Frequência salva com sucesso!');
        }

        // Submissão do formulário de chamada por dia (arrays RA[], situacao[])
        $count = count($dadosForm["RA"] ?? []);
        if ($count > 0) {
            tb_frequencia::salvandoFrequencia($dadosForm);
            if ($this->request->wantsJson() || $this->request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Frequência registrada com sucesso!']);
            }
            return redirect()->back()->with('success', 'Frequência registrada com sucesso!');
        }

        return redirect()->back()->with('error', 'Nenhum dado informado.');
    }

    public function frequencia_mensal ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        date_default_timezone_set('America/Sao_Paulo');
        
        $mesNum = str_pad($this->request->get('mes', date('m')), 2, '0', STR_PAD_LEFT);
        $anoNum = (string)$this->request->get('ano', date('Y'));

        $mesesMap = [
            '01' => 'JANEIRO', '02' => 'FEVEREIRO', '03' => 'MARÇO',
            '04' => 'ABRIL', '05' => 'MAIO', '06' => 'JUNHO',
            '07' => 'JULHO', '08' => 'AGOSTO', '09' => 'SETEMBRO',
            '10' => 'OUTUBRO', '11' => 'NOVEMBRO', '12' => 'DEZEMBRO'
        ];
        $nomeMes = $mesesMap[$mesNum] ?? date('F');
        $mes = "{$nomeMes} / {$anoNum}";

        $titulo = 'Frequência Mensal';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;

        // Busca todas as frequências salvas no mês e ano para a turma
        $registrosMes = DB::table('tb_frequencia')
            ->where('tb_turmas_idTurmas', $idTurmas)
            ->where(function($q) use ($mesNum) {
                $q->where('Mes', (string)$mesNum)->orWhere('mes', (string)$mesNum);
            })
            ->where(function($q) use ($anoNum) {
                $q->where('Ano', (string)$anoNum)->orWhere('ano', (string)$anoNum);
            })
            ->get();

        $frequenciaMatriz = [];
        foreach ($registrosMes as $reg) {
            $aId = $reg->tb_aluno_idAluno;
            $dNum = (int)($reg->Dia ?? $reg->dia ?? 0);
            $sitRaw = strtoupper(trim($reg->Presenca ?? $reg->situacao ?? 'P'));
            
            $code = 'P';
            if (in_array($sitRaw, ['FALTA', 'F'])) $code = 'F';
            elseif (in_array($sitRaw, ['JUSTIFICADO', 'FJ'])) $code = 'J';
            elseif (in_array($sitRaw, ['ATESTADO', 'A'])) $code = 'A';
            elseif (in_array($sitRaw, ['PRESENTE', 'P'])) $code = 'P';
            
            if ($dNum >= 1 && $dNum <= 31) {
                $frequenciaMatriz[$aId][$dNum] = $code;
            }
        }

        return view('telasCoordenacao.frequencia.frequencia_mensal', compact(
            'titulo', 'escolas', 'mes', 'turma', 'Alunos', 'alunos', 'frequenciaMatriz', 'mesNum', 'anoNum'
        ));
    }

    public function frequencia_edfisica ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime(' %B de %Y', strtotime('today'));   
        $mes = date('m /y');
        $titulo = 'Frequencia Ed.Física';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_edfisica', compact('titulo','dia','mes','escolas','turma','Alunos','alunos'));
    }

    public function frequencia_entrega ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%B de %Y', strtotime('today'));
        $mes = date('m /y');
        $titulo = 'Frequencia Entrega';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_entrega', compact('titulo','dia','mes','escolas','turma','Alunos','alunos'));
    }   
//FIM DA CLASSE CONTROLE DA TURMA 
}
