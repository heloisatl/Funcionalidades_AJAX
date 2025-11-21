<?php
require_once __DIR__ . "/../../controller/OrdemServicoController.php";
require_once __DIR__ . "/../../model/OrdemServico.php";
require_once __DIR__ . "/../../model/Cliente.php";
require_once __DIR__ . "/../../model/TipoServico.php";

$msgErro = "";

$ordemServicoCont = new OrdemServicoController();

$clientes = $ordemServicoCont->listarClientes();
$tiposServico = $ordemServicoCont->listarTiposServico();

// Inicializar variáveis para manter dados no form
$descricaoProblema = '';
$dataEntrada = '';
$prazoEstimado = '';
$status = '';
$idCliente = '';
$idTipoServico = '';

// Verificar o método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $descricaoProblema = $_POST['descricao_problema'] ?? '';
    $dataEntrada = $_POST['data_entrada'] ?? '';
    $prazoEstimado = $_POST['prazo_estimado_saida'] ?? '';
    $status = $_POST['status'] ?? '';
    $idCliente = $_POST['id_cliente'] ?? '';
    $idTipoServico = $_POST['id_tipo_servico'] ?? '';

    $ordemServico = new OrdemServico();
    $ordemServico->setDescricaoProblema($descricaoProblema);
    $ordemServico->setDataEntrada($dataEntrada);
    $ordemServico->setPrazoEstimadoSaida($prazoEstimado);
    $ordemServico->setStatus($status);

    $cliente = new Cliente();
    $cliente->setId((int)$idCliente);
    $ordemServico->setCliente($cliente);

    $tipoServico = new TipoServico();
    $tipoServico->setId((int)$idTipoServico);
    $ordemServico->setTipoServico($tipoServico);

    $resultado = $ordemServicoCont->cadastrar($ordemServico);

    if ($resultado === null) {
       
        header("location: listar.php?msg=Ordem cadastrada com sucesso!");
        exit;
    } else {
        if (is_array($resultado)) {
            $msgErro = implode("<br>", $resultado);
        } else {
            $msgErro = "Erro desconhecido";
        }
    }
}

include_once(__DIR__ . "/form.php");