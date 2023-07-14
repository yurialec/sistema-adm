<?php

namespace App\adms\Models\Helper;

/**
 * Classe genérica para converter o SLUG 
 */
class AdmsSlug
{
    /** Recebe o texto que deve ser convertido @var string */
    private string $text;

    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;

    public function slug(string $text): string|null
    {
        $this->text = $text;

        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýý
        þÿRr"!@#$%&*()_-+={[}]?;:,\\\'<>°ºª';

        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyy
        byRr-----------------------------------------------------------------------------
        ------------------';

        $this->text = strtr(utf8_decode($this->text), utf8_decode($this->format['a']), $this->format['b']);
        $this->text = str_replace(" ", "-", $this->text);
        $this->text = str_replace(array('-----', '----', '---', '--'), '-', $this->text);
        $this->text = strtolower($this->text);

        return $this->text;
    }
}
