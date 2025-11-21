<?php
require_once(__DIR__ . "/../../controller/OrdemServicoController.php");

$ordemServicoCont = new OrdemServicoController();
$lista = $ordemServicoCont->listar();
include_once(__DIR__ . "/../include/header.php");
?>

<link rel="stylesheet" href="../estilo/style.css">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h5 class="text-center mb-4" style="color:#fff; background: linear-gradient(-45deg, var(--bg-dark), var(--bg-darker),   var(--bg-dark))">Listagem de Ordens de Serviço</h5>
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Descrição do Problema</th>
                        <th>Tipo Serviço</th>
                        <th>Cliente</th>
                        <th style="width: 140px;">Data Entrada</th>
                        <th style="width: 160px;">Prazo Estimado</th>
                        <th>Status</th>
                        <th style="width:140px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $ordem): ?>
                        <tr class="text-center">
                            <td><?= $ordem->getId() ?></td>
                            <td><?= $ordem->getDescricaoProblema() ?></td>
                            <td><?= $ordem->getTipoServico() ? $ordem->getTipoServico()->getNome() : '' ?></td>
                            <td><?= $ordem->getCliente()->getNome() ?></td>
                            <td><?= date("d/m/Y", strtotime($ordem->getDataEntrada())) ?></td>
                            <td><?= date("d/m/Y", strtotime($ordem->getPrazoEstimadoSaida())) ?></td>
                            <td><?= $ordem->getStatus() ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="alterar.php?id=<?= $ordem->getId() ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                                    <a href="excluir.php?id=<?= $ordem->getId() ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Confirma a exclusão?');">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4 text-center">
                <a href="inserir.php" class="btn btn-primary btn-sm">Nova Ordem</a>
                <a href="../ordem_servico/home.php" class="btn btn-secondary btn-sm ms-2">Voltar</a>
            </div>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . "/../include/footer.php"); ?>