<?php
header('Content-Type: application/json; charset=utf-8');

require_once(__DIR__ . "/../controller/OrdemServicoController.php");

function enviarRespostaAJAX($data, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    enviarRespostaAJAX(["error" => "Método não permitido. Use POST."], 405);
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$status = $_POST['status'] ?? null;
$dataConclusao = $_POST['data_conclusao'] ?? null;


if (empty($id) || empty($status)) {
    enviarRespostaAJAX(["error" => "ID e Status são campos obrigatórios."], 400);
}

$controller = new OrdemServicoController();
$resultado = $controller->atualizarStatus($id, $status, $dataConclusao);

if (isset($resultado['error'])) {
    enviarRespostaAJAX(["success" => false, "message" => $resultado['error']], 500);
} else {
    $osAtualizada = $controller->buscarPorId($id);

    $StatusSalvo = $osAtualizada ? $osAtualizada->getStatus() : null;
    $PrazoSalvo = $osAtualizada ? $osAtualizada->getPrazoEstimadoSaida() : null;


    enviarRespostaAJAX([
        "success" => true,
        "message" => "Status da OS #{$id} atualizado.",
        "statusRecebido" => $status,
        "statusSalvo" => $StatusSalvo,
        "prazoEstimadoSalvo" => $PrazoSalvo
    ], 200);
}
