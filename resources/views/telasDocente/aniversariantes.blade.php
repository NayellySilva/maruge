<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aniversariantes de {{ $nomeMes }} - {{ $ano }}</title>
    <style>
        body { color: #17231f; font-family: Arial, sans-serif; margin: 32px auto; max-width: 850px; padding: 0 24px; }
        header { border-bottom: 2px solid #008a4b; margin-bottom: 24px; padding-bottom: 16px; }
        h1 { font-size: 24px; margin: 0 0 8px; }
        p { color: #53645d; margin: 4px 0; }
        button { background: #008a4b; border: 0; border-radius: 6px; color: white; cursor: pointer; font-size: 14px; margin-bottom: 20px; padding: 10px 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #d8e2dc; padding: 10px 12px; text-align: left; }
        th { background: #f1f7f3; }
        .empty { color: #53645d; padding: 18px 0; }
        @media print {
            body { margin: 0; max-width: none; padding: 0; }
            button { display: none; }
            th { background: #f1f7f3 !important; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <button type="button" onclick="window.print()">Imprimir</button>
    <header>
        <h1>Aniversariantes de {{ $nomeMes }} de {{ $ano }}</h1>
        <p>Professor(a): {{ $nomeProfessor }}</p>
    </header>

    @if($aniversariantes === [])
        <p class="empty">Nenhum aniversariante registrado neste mês em suas turmas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Aluno(a)</th>
                    <th>Turma</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aniversariantes as $aniversariante)
                    <tr>
                        <td>{{ sprintf('%02d', $aniversariante->dia) }}</td>
                        <td>{{ $aniversariante->nome }}</td>
                        <td>{{ $aniversariante->turma }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
