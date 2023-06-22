<?php

namespace App\adms\Models\Helper;

use Exception;
use PDO;

/**
 * Classe de conexão com o banco de dados
 */
abstract class AdmsConn
{
    //Atributos recebem constantes com os parametros para conectar com o banco de dados
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbname = DBNAME;
    private int|string $port = PORT;

    /** @var object Recebe a conexao com o banco de dados */
    private object $connect;

    protected function connectionDb(): object
    {
        try {
            //Conexão com a porta
            $this->connect = new PDO("mysql:host={$this->host};port={$this->port};dbname=" . $this->dbname, $this->user, $this->pass);
            return $this->connect;
        } catch (Exception $err) {
            die("Erro 001: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }
}
