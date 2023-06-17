<?php

namespace Core;

use Adms\Controllers\Login;
use Adms\Controllers\Users;

class ConfigController extends Config
{
    private string $url;
    private array $urlArray;
    private string $urlController;
    private string $urlMetodo;
    private string $urlParameter;
    private string $classLoad;
    private array $format;
    private string $urlSlugController;
    private string $urlSlugMetodo;

    public function __construct()
    {
        $this->configAdm();
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

            $this->clearUrl();

            $this->urlArray = explode("/", $this->url);

            if (isset($this->urlArray[0])) {
                $this->urlController = $this->slugController($this->urlArray[0]);
            } else {
                $this->urlController = $this->slugController(CONTROLLER);
            }

            if (isset($this->urlArray[1])) {
                $this->urlMetodo = $this->slugMetodo($this->urlArray[1]);
            } else {
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            if (isset($this->urlArray[2])) {
                $this->urlParameter = $this->urlArray[2];
            } else {
                $this->urlParameter = "";
            }
        } else {
            $this->urlController = $this->slugController(CONTROLLERERRO);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParameter = "";
        }
        echo "Controller: {$this->urlController} <br>";
        echo "Metodo: {$this->urlMetodo} <br>";
        echo "Paramentro: {$this->urlParameter} <br>";
    }

    private function clearUrl(): void
    {
        //Eliminar tags
        $this->url = strip_tags($this->url);

        //Eliminar espaçoes em branco
        $this->url = trim($this->url);

        //Eliminar barra no final da url
        $this->url = rtrim($this->url, "/");

        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']);
    }

    private function slugController($slugController): string
    {
        $this->urlSlugController = $slugController;
        $this->urlSlugController = strtolower($this->urlSlugController);
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        $this->urlSlugController = ucwords($this->urlSlugController);
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);
        return $this->urlSlugController;
    }

    private function slugMetodo($urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        var_dump($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }

    public function loadPage(): void
    {
        $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        $classPage = new $this->classLoad();
        $classPage->{$this->urlMetodo}();
    }
}
