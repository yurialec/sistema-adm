<?php

namespace App\adms\Models\Helper;

use PDO;
use PDOException;

/**
 * Classe genérica para editar registro do banco de dados
 */
class AdmsUpdate extends AdmsConn
{
    private string $table;
    private string|null $terms;
    private array $data;
    private array $value = [];
    private string|null|bool $result;
    private object $update;
    private string $query;
    private object $conn;

    public function getResult(): string|null|bool
    {
        return $this->result;
    }

    public function exeUpdate(string $table, array $data, string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        $this->data = $data;
        $this->terms = $terms;

        parse_str($parseString, $this->value);

        $this->exeReplaceValues();
    }

    /**
     * Recebe os valores do atributo $data
     *
     * @return void
     */
    private function exeReplaceValues(): void
    {
        foreach ($this->data as $key => $value) {
            $values[] = $key . "=:" . $key;
        }

        $values = implode(', ', $values);

        $this->query = "UPDATE {$this->table} SET {$values} {$this->terms}";

        $this->exeInstrunction();
    }

    /**
     * Executa o update
     *
     * @return void
     */
    private function exeInstrunction(): void
    {
        $this->connection();
        try {
            $this->update->execute(array_merge($this->data, $this->value));
            $this->result = true;
        } catch (PDO $err) {
            $this->result = null;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectionDb();
        $this->update = $this->conn->prepare($this->query);
    }
}
