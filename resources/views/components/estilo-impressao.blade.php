{{--
    Estilos dos documentos impressos (relatórios, boletins, mapas, declarações...).

    O CSS fica em resources/css/impressao/*.css e é embutido aqui porque esses
    documentos abrem fora do layout principal e alguns viram PDF (dompdf),
    que não carrega o CSS do Vite.

    Uso:
        <x-estilo-impressao />                    → só a base
        <x-estilo-impressao arquivo="mapa" />     → base + mapa.css
--}}
@props(['arquivo' => null])
@php
    $arquivos = array_filter(['base', $arquivo]);
    $css = '';
    foreach ($arquivos as $nome) {
        $caminho = resource_path('css/impressao/' . basename($nome) . '.css');
        if (is_file($caminho)) {
            $css .= file_get_contents($caminho) . "\n";
        }
    }
@endphp
<style>
{!! $css !!}
</style>
