<?php
require_once __DIR__ . '/../model/OrdemServico.php';
require_once __DIR__ . '/../service/OrdemServicoService.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
require_once __DIR__ . '/../dao/TipoServicoDAO.php';
require_once __DIR__ . '/../dao/OrdemServicoDAO.php';

class OrdemServicoController
{
    private OrdemServicoService $ordemServicoService;
    private OrdemServicoDAO $ordemServicoDAO;
    private ClienteDAO $clienteDAO;
    private TipoServicoDAO $tipoServicoDAO;

    public function __construct()
    {
        $this->ordemServicoService = new OrdemServicoService();
        $this->ordemServicoDAO = new OrdemServicoDAO();
        $this->clienteDAO = new ClienteDAO();
        $this->tipoServicoDAO = new TipoServicoDAO();
    }

    public function listar(): array
    {
        return $this->ordemServicoDAO->listar();
    }

    public function listarClientes(): array
    {
        return $this->clienteDAO->listar();
    }

    public function listarTiposServico(): array
    {
        return $this->tipoServicoDAO->listar();
    }


    public function cadastrar(OrdemServico $ordemServico): ?array
    {
        // Validação
        $erros = $this->ordemServicoService->validarOrdemServico($ordemServico);

        if (!empty($erros)) {
            return $erros;
        }

        // Inserção no banco
        try {
            $erro = $this->ordemServicoDAO->inserir($ordemServico);

            if ($erro !== null) {
                return ["Erro no banco de dados: " . $erro->getMessage()];
            }

            return null;
        } catch (Exception $e) {
            return ["Erro inesperado: " . $e->getMessage()];
        }
    }


    public function alterar(OrdemServico $ordemServico): array
    {
        $erros = $this->ordemServicoService->validarOrdemServico($ordemServico);

        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->ordemServicoDAO->alterar($ordemServico);
        if ($erro !== null) {
            $erros[] = "Erro ao atualizar: " . $erro->getMessage();
        }

        return $erros;
    }

    public function buscarPorId(int $id): ?OrdemServico
    {
        return $this->ordemServicoDAO->buscarPorId($id);
    }

    public function excluir($id): ?PDOException
    {
        return $this->ordemServicoDAO->excluirPorId($id);
    }



    public function atualizarStatus(int $id, string $status, ?string $dataConclusao = null): array
    {
        try {
            $ordem = $this->ordemServicoDAO->buscarPorId($id);

            if (!$ordem) {
                return ["error" => "Ordem de serviço não encontrada."];
            }

            // Normaliza o status recebido, para lidar com variações de acentuação
            $map = [
                'Aberta' => 'Aberta',
                'Em andamento' => 'Em andamento',
                'Em andamento' => 'Em andamento',
                'Concluída' => 'Concluida',
                'Concluida' => 'Concluida',
                'Cancelada' => 'Cancelada'
            ];

            $normalizado = $status;
            if (isset($map[$status])) {
                $normalizado = $map[$status];
            } else {
                // Tenta remover acentuação simples
                $normalizado = str_replace(['ú', 'í', 'á', 'é', 'ã', 'õ', 'ç'], ['u', 'i', 'a', 'e', 'a', 'o', 'c'], $status);
            }

            // Tive que fazer assim pq por algum motivo não estava salvando o stuatus concluída com acento

            $ordem->setStatus($normalizado);

            if ($normalizado === 'Concluida') {
                if (!empty($dataConclusao)) {
                    $ordem->setPrazoEstimadoSaida($dataConclusao);
                }
            } else {
                if ($dataConclusao !== null) {
                    $ordem->setPrazoEstimadoSaida($dataConclusao);
                }
            }

            $erro = $this->ordemServicoDAO->alterarStatus($ordem);

            if ($erro !== null) {
                return ["error" => "Erro ao atualizar no banco de dados: " . $erro->getMessage()];
            }
            return ["success" => true, "message" => "Status e data atualizados com sucesso."];
        } catch (\Exception $e) {
            return ["error" => "Erro inesperado: " . $e->getMessage()];
        }
    }
}
