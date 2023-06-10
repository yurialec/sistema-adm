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


    public function __construct()
    {
        $this->configAdm();
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

            $this->clearUrl();

            $this->urlArray = explode("/", $this->url);

            if (isset($this->urlArray[0])) {
                $this->urlController = $this->urlArray[0];
            } else {
                $this->urlController = CONTROLLER;
            }

            if (isset($this->urlArray[1])) {
                $this->urlMetodo = $this->urlArray[1];
            } else {
                $this->urlMetodo = METODO;
            }

            if (isset($this->urlArray[2])) {
                $this->urlParameter = $this->urlArray[2];
            } else {
                $this->urlParameter = "";
            }
        } else {
            $this->urlController = CONTROLLERERRO;
            $this->urlMetodo = METODO;
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

    public function loadPage(): void
    {
        $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        $classPage = new $this->classLoad;
        $classPage->{$this->urlMetodo}();
    }
}
