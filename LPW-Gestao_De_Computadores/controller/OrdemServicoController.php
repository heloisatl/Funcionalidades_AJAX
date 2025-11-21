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
}