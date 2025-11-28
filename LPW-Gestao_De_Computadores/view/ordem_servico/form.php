<?php include_once(__DIR__ . "/../include/header.php"); ?>

<div class="my-5">
    <div>
        <div>
            Nova Ordem de Serviço
        </div>
    </div>

    <form id="formOrdemServico">

        <div class="mb-3">
            <textarea class="form-control" name="descricao_problema" placeholder="Descrição do Problema"><?= htmlspecialchars($descricaoProblema) ?></textarea>
        </div>

        <div class="mb-3">
            <select class="form-control" name="id_cliente" required>
                <option value="">Selecione o Cliente</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?= $c->getId() ?>" <?= ($idCliente == $c->getId()) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c->getNome()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <select class="form-control" name="id_tipo_servico" required>
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
            <input type="date" class="form-control" name="data_entrada" value="<?= htmlspecialchars($dataEntrada) ?>" required>
        </div>

        <div class="mb-3">
            <p>Prazo estimado para a saída</p>
            <input type="date" class="form-control" name="prazo_estimado_saida" value="<?= htmlspecialchars($prazoEstimado) ?>" required>
        </div>

        <div class="mb-3">
            <select class="form-control" id="status" name="status" required>
                <option value="">Selecione</option>

                <option value="Aberta">Aberta</option>
                <option value="Em andamento">Em andamento</option>

                <option value="Concluida" disabled>Concluída</option>
                <option value="Cancelada" disabled>Cancelada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Salvar</button>

    </form>

    <div id="msgAjax" class="mt-3 text-center"></div>

    <div>
        <a href="listar.php">Voltar para listagem</a>
    </div>
</div>

<script src="js/ordem_servico_inserir.js"></script>

