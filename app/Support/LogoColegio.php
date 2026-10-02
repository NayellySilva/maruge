<?php

namespace App\Support;

/**
 * Logo oficial do colégio, usado no cabeçalho dos relatórios, boletins,
 * declarações, mapas, históricos, recibos etc.
 *
 * Fonte ÚNICA: resources/img/logoempresa.png (não há upload nem outro arquivo).
 *
 * src() devolve a imagem embutida em base64 (data URI), que funciona tanto no
 * navegador quanto nos PDFs gerados pelo dompdf (que não carrega imagens por URL).
 *
 * Uso nas views:  <img src="{{ \App\Support\LogoColegio::src() }}" class="logo-colegio">
 */
class LogoColegio
{
    public const ARQUIVO = 'img/logoempresa.png';

    // GIF 1x1 transparente: mantém o layout caso o arquivo não exista.
    private const VAZIO = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    private static ?string $cacheSrc = null;

    /** Caminho absoluto do logo, ou null se o arquivo não existir. */
    public static function path(): ?string
    {
        $arquivo = resource_path(self::ARQUIVO);
        return is_file($arquivo) ? $arquivo : null;
    }

    public static function existe(): bool
    {
        return self::path() !== null;
    }

    /** Valor para o atributo src de <img> (data URI, com cache por requisição). */
    public static function src(): string
    {
        if (self::$cacheSrc !== null) {
            return self::$cacheSrc;
        }

        $arquivo = self::path();
        $conteudo = $arquivo ? @file_get_contents($arquivo) : false;
        if ($conteudo === false) {
            return self::$cacheSrc = self::VAZIO;
        }

        return self::$cacheSrc = 'data:image/png;base64,' . base64_encode($conteudo);
    }
}
