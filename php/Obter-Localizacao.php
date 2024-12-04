<?php
require_once 'config.php';
require_once 'functions.php';

// ID GENERALIZADO - MUDAR PARA MÉTODO NECESSÁRIO
$idInstituicao = 1;

try {
    // Buscar informações da instituição
    $stmt = $pdo->prepare("SELECT i.*, u.nome, u.username, ip.base64_data AS imagem_perfil, ic.base64_data AS imagem_capa 
                           FROM INSTITUICAO i 
                           JOIN USUARIO u ON i.usuario_id = u.id
                           LEFT JOIN IMAGEM ip ON u.imagem_perfil_id = ip.id
                           LEFT JOIN IMAGEM ic ON u.imagem_capa_id = ic.id
                           WHERE u.id = ?");
    $stmt->execute([$idInstituicao]);
    $instituicao = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($instituicao) {
        echo json_encode(['localizacao' => $instituicao['localizacao']]);
    } else {
        echo json_encode(['error' => 'Instituição não encontrada']);
    }
} catch (PDOException $e) {
    // Tratar erro de conexão com o banco de dados
    echo json_encode(['error' => 'Erro na conexão com o banco de dados: ' . $e->getMessage()]);
}
?>
