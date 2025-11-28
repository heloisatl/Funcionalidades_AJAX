function alterarStatus(id) {
    const selectElement = document.getElementById('status_os_' + id);
    const novoStatus = selectElement.value; // agora usa valores sem acento para o DB, ex: 'Concluida'
    const url = '../../api/alterar_status.php';
    let dataConclusao = null;


    // Se o valor armazenado que representa conclusão for usado
    if (novoStatus === 'Concluida') {
        const data = prompt("Status 'Concluída' selecionado. Por favor, informe a data de conclusão (Formato YYYY-MM-DD):");
        if (data === null || data.trim() === '') {
            alert("A data de conclusão é obrigatória para o status 'Concluída'. A alteração foi cancelada.");
            window.location.reload();
            return;
        }
        dataConclusao = data.trim();
    }


    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', novoStatus);
    if (dataConclusao) formData.append('data_conclusao', dataConclusao);


    fetch(url, { method: 'POST', body: formData })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.message || data.error || 'Erro desconhecido'); });
            }
            return response.json();
        })
        .then(data => {
            alert('Sucesso! ' + (data.message || 'Atualizado.'));
            window.location.reload();
        })
        .catch(err => {
            console.error('Erro:', err.message);
            alert('Falha ao alterar o status: ' + err.message);
            window.location.reload();
        });
}