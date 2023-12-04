<?php
class BancoDeDados {
    // Atributos
    private $conexao;
    private $host = 'localhost';
    private $porta = '3307';
    private $db_nome = 'db_epi_control';
    private $usuario = 'root';
    private $senha = '';

    // Métodos
    public function __construct() {
        try {
            $str_connection = "mysql:host=$this->host;port=$this->porta;dbname=$this->db_nome;charset=utf8";
            $this->conexao = new PDO($str_connection, $this->usuario, $this->senha);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    // insert, update e delete
    public function executarComando($sql, $parametros = []) {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    public function executarNoParams($sql) {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    // select de apenas um registro/linha
    public function selecionarRegistro($sql, $parametros = []) {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    // select de vários registros/linhas
    public function selecionarRegistros($sql, $parametros = []) {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($parametros);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }

    //select sem parametros
    public function selecionarTudo($sql) {
        try {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            throw new Exception($erro->getMessage());
        }
    }


}