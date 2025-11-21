<?php include_once(__DIR__ . "/../include/header.php"); ?>
<link rel="stylesheet" href="../estilo/style.css">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-card p-4">
                <div class="form-tabs d-flex mb-4">
                    <div class="form-tab flex-fill text-center active" style="color:#000;border-radius:16px 16px 0 0; font-weight:bold;">
                        Nova Ordem de Serviço
                    </div>
                </div>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <textarea class="form-control" name="descricao_problema" placeholder="Descrição do Problema"><?= htmlspecialchars($descricaoProblema) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="id_cliente">
                            <option value="">Selecione o Cliente</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c->getId() ?>" <?= ($idCliente == $c->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c->getNome()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="id_tipo_servico">
                            <option value="">Selecione o Tipo de Serviço</option>
                            <?php foreach ($tiposServico as $tipo): ?>
                                <option value="<?= $tipo->getId() ?>" <?= ($idTipoServico == $tipo->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tipo->getNome()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p>Data de entrada</p>
                        <input type="date" class="form-control" name="data_entrada" value="<?= htmlspecialchars($dataEntrada) ?>">
                    </div>
                    <div class="mb-3">
                        <p>Prazo estimado para a saída</p>
                        <input type="date" class="form-control" name="prazo_estimado_saida" value="<?= htmlspecialchars($prazoEstimado) ?>">
                    </div>
                    <div class="mb-3">
                        <select class="form-control" id="status" name="status">
                            <option value="">Selecione</option>
                            <option value="Aberta" <?= ($status == "Aberta") ? "selected" : "" ?>>Aberta</option>
                            <option value="Em andamento" <?= ($status == "Em andamento") ? "selected" : "" ?>>Em andamento</option>
                            <option value="Concluída" <?= ($status == "Concluída") ? "selected" : "" ?>>Concluída</option>
                            <option value="Cancelada" <?= ($status == "Cancelada") ? "selected" : "" ?>>Cancelada</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Salvar</button>
                </form>
                
                <?php if (!empty($msgErro)): ?>
                    <div class="alert alert-danger mt-3 text-center"><?= $msgErro ?></div>
                <?php endif; ?>
                
                <div class="form-footer mt-3 text-center">
                    <a href="listar.php">Voltar para listagem</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . "/../include/footer.php"); ?>