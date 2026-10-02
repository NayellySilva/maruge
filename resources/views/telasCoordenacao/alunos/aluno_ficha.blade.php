@extends('layouts.app')  
@section('content')

@php
    // Helper para formatar datas no padrao DD/MM/YYYY
    $formatDate = function($val) {
        if (empty($val)) return '-';
        $val = trim($val);
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})/', $val, $m)) {
            return "{$m[3]}/{$m[2]}/{$m[1]}";
        }
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})/', $val, $m)) {
            $d = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $mo = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            return "{$d}/{$mo}/{$m[3]}";
        }
        return $val;
    };
@endphp

<!-- Barra Superior de Acoes na Tela -->
<div class="no-print-bar no-print">
    <div>
        <h1 class="text-xl font-bold text-[#0a241e]">Ficha Cadastral do Aluno</h1>
        <p class="text-xs text-[#64748b]">Visualização completa e impressão da ficha individual</p>
    </div>
    <button type="button" onclick="window.print()" class="btn-imprimir-ficha">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Imprimir Ficha
    </button>
</div>

<!-- Card da Ficha Cadastral do Aluno -->
<div class="ficha-card">

    <!-- Timbre da Escola -->
    <div class="school-header-ficha">
        <img src="{{ \App\Support\LogoColegio::src() }}" class="school-logo-ficha" alt="Logo Escola">
        @forelse($escolas as $escola)
            <div class="school-info-ficha">
                {{ $escola->Rua }} , {{ $escola->Numero }} - {{ $escola->Bairro }} - CEP: {{ $escola->CEP }}<br>
                {{ $escola->Cidade }} - {{ $escola->Estado }} | Tel: {{ $escola->Fone1 }} / {{ $escola->Fone2 }}<br>
                E-mail: {{ $escola->EmailColegio }} | CNPJ: {{ $escola->CNPJ }} - INEP: {{ $escola->NumeroInep }}
            </div>
        @empty
            <div class="school-info-ficha">COLÉGIO MARUGE</div>
        @endforelse
    </div>

    <!-- 1. Sobre o Aluno -->
    <div class="ficha-section-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        Informações do Aluno
    </div>
    
    <div class="info-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="info-item" style="grid-column: span 2;">
            <span>Nome do Aluno(a):</span>
            <strong>{{ $aluno->NomeAluno }}</strong>
        </div>
        <div class="info-item">
            <span>Nº Matrícula / RA:</span>
            <strong>{{ $matricula->RA ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Nº MAC / ID:</span>
            <strong>{{ $aluno->NumeroMac ?? '-' }}</strong>
        </div>

        <div class="info-item">
            <span>Data de Nascimento:</span>
            <strong>{{ $formatDate($aluno->DataNascimento) }}</strong>
        </div>
        <div class="info-item">
            <span>Sexo:</span>
            <strong>{{ $aluno->Sexo ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Turma:</span>
            <strong>{{ $turma->NomeTurma ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Situação:</span>
            <span class="badge-situacao">{{ $matricula->SituacaoAluno ?? 'ATIVO' }}</span>
        </div>

        <div class="info-item">
            <span>Aluno Novato:</span>
            <strong>{{ $matricula->AlunoNV ?? 'NÃO' }}</strong>
        </div>
        <div class="info-item">
            <span>CPF Aluno:</span>
            <strong>{{ $aluno->CPFAluno ?? '-' }}</strong>
        </div>
        <div class="info-item" style="grid-column: span 2;">
            <span>Cartório:</span>
            <strong>{{ $aluno->NomeCartorio ?? '-' }}</strong>
        </div>

        <div class="info-item" style="grid-column: span 2;">
            <span>Certidão de Nascimento Nº:</span>
            <strong>{{ $aluno->NumeroRGNovo ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Estado Cartório:</span>
            <strong>{{ $aluno->EstadoCartorio ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Naturalidade:</span>
            <strong>{{ $aluno->CidadeCartorio ?? '-' }}</strong>
        </div>

        <div class="info-item">
            <span>Data de Emissão:</span>
            <strong>{{ $formatDate($aluno->DataEmissao) }}</strong>
        </div>
        <div class="info-item">
            <span>Data da Matrícula:</span>
            <strong>{{ $formatDate($matricula->DataMatricula) }}</strong>
        </div>
        <div class="info-item">
            <span>Forma de Pagamento:</span>
            <strong>{{ $matricula->FormaPGTO ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Valor Mensalidade:</span>
            <strong>R$ {{ number_format($matricula->ValorPGTO ?? 0, 2, ',', '.') }}</strong>
        </div>

        <div class="info-item">
            <span>Bônus / Desconto:</span>
            <strong>{{ $matricula->Bonus ?? 0 }}%</strong>
        </div>
        <div class="info-item">
            <span>Registro:</span>
            <strong>{{ $matricula->Registro ?? 'NÃO' }}</strong>
        </div>
        <div class="info-item">
            <span>Pasta:</span>
            <strong>{{ $matricula->Pasta ?? 'NÃO' }}</strong>
        </div>
        <div class="info-item">
            <span>Foto:</span>
            <strong>{{ $matricula->Foto ?? 'NÃO' }}</strong>
        </div>

        <div class="info-item" style="grid-column: span 4;">
            <span>Acompanhamento:</span>
            <strong>{{ $aluno->Acompanhamento ?? 'Nenhum' }}</strong>
        </div>
    </div>

    <!-- 2. Sobre os Pais / Responsável -->
    <div class="ficha-section-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        Filiação e Responsável Legal
    </div>

    <div class="info-grid" style="grid-template-columns: repeat(4, 1fr);">
        <!-- Filiação 1 -->
        <div class="info-item" style="grid-column: span 2;">
            <span>Filiação 1 (Pai/Mãe):</span>
            <strong>{{ $pais->NomePai ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>WhatsApp / Fone 1:</span>
            <strong>{{ $pais->FonePai1 ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Telefone 2:</span>
            <strong>{{ $pais->FonePai2 ?? '-' }}</strong>
        </div>

        <div class="info-item">
            <span>Profissão:</span>
            <strong>{{ $pais->ProfPai ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>CPF:</span>
            <strong>{{ $pais->CPFPai ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>RG:</span>
            <strong>{{ $pais->RGPai ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Data de Nasc.:</span>
            <strong>{{ $formatDate($pais->Nas_Pai ?? '') }}</strong>
        </div>

        <!-- Filiação 2 -->
        <div class="info-item" style="grid-column: span 2; border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>Filiação 2 (Pai/Mãe):</span>
            <strong>{{ $pais->NomeMae ?? '-' }}</strong>
        </div>
        <div class="info-item" style="border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>WhatsApp / Fone 1:</span>
            <strong>{{ $pais->FoneMae1 ?? '-' }}</strong>
        </div>
        <div class="info-item" style="border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>Telefone 2:</span>
            <strong>{{ $pais->FoneMae2 ?? '-' }}</strong>
        </div>

        <div class="info-item">
            <span>Profissão:</span>
            <strong>{{ $pais->ProfMae ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>CPF:</span>
            <strong>{{ $pais->CPFMae ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>RG:</span>
            <strong>{{ $pais->RGMae ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Data de Nasc.:</span>
            <strong>{{ $formatDate($pais->Nas_Mae ?? '') }}</strong>
        </div>

        <!-- Responsavel Legal -->
        <div class="info-item" style="grid-column: span 2; border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>Responsável Financeiro/Legal:</span>
            <strong>{{ $pais->Responsavel ?? '-' }}</strong>
        </div>
        <div class="info-item" style="border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>CPF Responsável:</span>
            <strong>{{ $pais->CPFResponsavel ?? '-' }}</strong>
        </div>
        <div class="info-item" style="border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
            <span>RG Responsável:</span>
            <strong>{{ $pais->RGResponsavel ?? '-' }}</strong>
        </div>
    </div>

    <!-- 3. Endereco do Aluno -->
    <div class="ficha-section-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        Endereço Residencial
    </div>

    <div class="info-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="info-item" style="grid-column: span 2;">
            <span>Logradouro / Rua:</span>
            <strong>{{ $endereco->Rua ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Número:</span>
            <strong>{{ $endereco->Numero ?? 'S/N' }}</strong>
        </div>
        <div class="info-item">
            <span>Telefone Fixo:</span>
            <strong>{{ $endereco->Fone1 ?? '-' }}</strong>
        </div>

        <div class="info-item">
            <span>CEP:</span>
            <strong>{{ $endereco->CEP ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Bairro:</span>
            <strong>{{ $endereco->Bairro ?? '-' }}</strong>
        </div>
        <div class="info-item">
            <span>Cidade:</span>
            <strong>{{ $endereco->Cidade ?? 'JUAZEIRO DO NORTE' }}</strong>
        </div>
        <div class="info-item">
            <span>Referência:</span>
            <strong>{{ $endereco->Referencia ?? '-' }}</strong>
        </div>
    </div>

    <!-- 4. Observacoes -->
    @if(!empty($aluno->ObsAluno))
        <div class="ficha-section-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            Observações
        </div>
        <div style="background: #f8fafc; border: 1px solid #f1f5f9; padding: 12px 16px; border-radius: 10px; font-size: 11.5px; color: #334155;">
            {{ $aluno->ObsAluno }}
        </div>
    @endif

    <!-- Assinaturas -->
    <div class="signatures-row">
        <div class="signature-line">Assinatura Pai / Mãe ou Responsável</div>
        <div class="signature-line">Assinatura Funcionário(a)</div>
    </div>

</div>

@endsection
