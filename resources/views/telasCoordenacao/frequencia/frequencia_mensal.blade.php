<html>
    <head>
        <title>{{$titulo}}</title>
        <style media="print">
            .botao {
                display: none !important;
            }
        </style>
        <!-- CSS Personalizado para o Painel -->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS para Reset de Estilos -->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    </head>
    <body>
        <!-- Controles de Tela (Ocultados ao Imprimir) -->
        <div class="botao" style="margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
            <button type="button" value="Imprimir" onClick="window.print()" class="btn-imprimir"> Imprimir Ficha Mensal</button>
            
            @php
                $mesNumSelect = $mesNum ?? date('m');
                $anoNumSelect = $anoNum ?? date('Y');
                $turmaIdSelect = $turma->idTurmas ?? 0;
            @endphp
            <div style="display: flex; items-center; gap: 8px; font-family: sans-serif; font-size: 13px;">
                <label>Mês:</label>
                <select onchange="window.location.href='{{ url('/coordenacao/frequencia_mensal') }}/{{ $turmaIdSelect }}?mes='+this.value+'&ano={{ $anoNumSelect }}'" style="padding: 4px 8px; border-radius: 6px; border: 1px solid #ccc;">
                    @foreach(['01'=>'01 - Janeiro', '02'=>'02 - Fevereiro', '03'=>'03 - Março', '04'=>'04 - Abril', '05'=>'05 - Maio', '06'=>'06 - Junho', '07'=>'07 - Julho', '08'=>'08 - Agosto', '09'=>'09 - Setembro', '10'=>'10 - Outubro', '11'=>'11 - Novembro', '12'=>'12 - Dezembro'] as $mK => $mV)
                        <option value="{{ $mK }}" {{ $mesNumSelect == $mK ? 'selected' : '' }}>{{ $mV }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <table class="timbre-horizontal">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                </td>
                <td>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}
                </td>
            </tr>         
        </table>
        @empty
        @endforelse
        <div class="mapa-titulo"> FREQUÊNCIA MÊS: {{$mes}}   -    TURMA - {{$turma->NomeTurma}}</div>   
            
        <hr class="linha">   
        
       <table class="table-striped table-bordered mapa" >    
            <thead>
                <tr>        
                    <th width="40"><center>Nº</center></th>
                    <th width="70"><center>RA</center></th>
                    <th>ALUNO</th>
                    @for($d = 1; $d <= 31; $d++)
                        <th width="21" style="text-align: center; font-size: 11px;">{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}</th>
                    @endfor
                </tr>
            </thead> 
            
            @php
            $contando = 0;
            $frequenciaMatriz = $frequenciaMatriz ?? [];
            @endphp
            
            @forelse($Alunos as $Aluno)      
            <tr>
                 @if (isset ($Aluno))
                    @php
                    $contando++;
                    @endphp
                <td><center>{{$contando }}</center></td>
                
                <td><center>{{$Aluno->RA}}</center></td>
                <td>{{ mb_strtoupper($Aluno->NomeAluno) }}</td>
                
                <!-- Colunas Consolidadas dos Dias 01 a 31 -->
                @for($d = 1; $d <= 31; $d++)
                    @php
                        $sigla = $frequenciaMatriz[$Aluno->idAluno][$d] ?? '';
                    @endphp
                    <td style="text-align: center; font-size: 11px; font-weight: bold; font-family: monospace;">
                        @if($sigla === 'P')
                            <span style="color: #008a4b;">P</span>
                        @elseif($sigla === 'F')
                            <span style="color: #e11d48;">F</span>
                        @elseif($sigla === 'J')
                            <span style="color: #d97706;">J</span>
                        @elseif($sigla === 'A')
                            <span style="color: #0284c7;">A</span>
                        @endif
                    </td>
                @endfor
            </tr>
            @endif
            @empty
                <tr>
                    <td colspan="34" style="text-align: center; padding: 20px; color: #888;">
                        Nenhum aluno cadastrado nesta turma.
                    </td>
                </tr>
            @endforelse
        </table>

        <!-- Legenda -->
        <div style="margin-top: 15px; font-family: sans-serif; font-size: 11px; color: #555; display: flex; gap: 15px;">
            <span><strong style="color: #008a4b;">P</strong>: Presente</span>
            <span><strong style="color: #e11d48;">F</strong>: Falta</span>
            <span><strong style="color: #d97706;">J</strong>: Justificado</span>
            <span><strong style="color: #0284c7;">A</strong>: Atestado</span>
        </div>
    </body>
</html>