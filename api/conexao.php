<?php

class Conexao {
    public static function conexao(): PDO {
        try{
            return new PDO(
                'mysql:host=localhost;dbname=monitor_glp;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
            } catch (PDOException $e) {
                http_response_code(500);
                die('Erro ao conectar no banco: ' . $e->getMessage());
            }
    }
}

?>