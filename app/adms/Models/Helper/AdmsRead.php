<?php

namespace App\adms\Models\Helper;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PDO;
use PDOException;

/**
 * Classe genérica para selecionar registro do banco de dados
 */
class AdmsRead extends AdmsConn
{
    private string $select;
    private array $values = [];
    private array|null $result;
    private object $query;
    private object $conn;

    public function getResult(): array|null
    {
        return $this->result;
    }

    public function exeRead(string $table, string|null $terms = null, string|null $parseString = null): void
    {
        if (!empty($parseString)) {
            parse_str($parseString, $this->values);
        }

        $this->select = "SELECT * FROM {$table} {$terms}";
        $this->execInstruction();
    }

    public function fullRead(string $query, string|null $parseString = null): void
    {
        $this->select = $query;
        if (!empty($parseString)) {
            parse_str($parseString, $this->values);
        }
        $this->execInstruction();
    }

    private function execInstruction(): void
    {
        $this->connection();

        try {
            $this->execParameter();
            $this->query->execute();
            $this->result = $this->query->fetchAll();
        } catch (PDOException $err) {
            $this->result = null;
        }
    }

    private function connection(): void
    {
        $this->conn = $this->connectionDb();
        $this->query = $this->conn->prepare($this->select);
        $this->query->setFetchMode(PDO::FETCH_ASSOC);
    }

    private function execParameter(): void
    {
        if ($this->values) {
            foreach ($this->values as $link => $value) {
                if (($link == 'limit') or ($link == 'offset') or ($link == 'id')) {
                    $value = (int) $value;
                }
                $this->query->bindValue(":{$link}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
    }
}
