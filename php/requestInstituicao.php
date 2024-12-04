<?php
// Conexão com banco de dados
include_once('config.php');

try {
    // Teste de conexão
    if (!$pdo) {
        die('Falha na conexão com o banco de dados.');
    }

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        throw new Exception('ID da instituição não fornecido.');
    }

    // Query para informações da instituição
    $query = "SELECT nome, descricao, missao, visao, valores 
              FROM usuario u 
              JOIN instituicao i ON (i.usuario_id = u.id) 
              WHERE u.id = :id";

    // Prepara e executa a query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Obtém o resultado
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Define o tipo de conteúdo como JSON
    header('Content-Type: application/json; charset=utf-8');

    // Retorna o resultado como JSON
    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    // Erro no banco de dados ou na execução
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(["error" => "Erro: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

// Fechar a conexão
$pdo = null;
?>