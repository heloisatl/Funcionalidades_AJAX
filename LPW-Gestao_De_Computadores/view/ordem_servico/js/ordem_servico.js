function alterarStatus(id) {
    const selectElement = document.getElementById('status_os_' + id);
    const novoStatus = selectElement.value;
    const campoData = document.getElementById('data_conclusao_' + id);
    const url = '../../api/alterar_status.php';

    if (novoStatus === 'Concluida') {

        campoData.style.display = 'block';
        campoData.focus();

        campoData.addEventListener('change', function enviarData() {

            let dataConclusao = campoData.value;
            let hoje = new Date().toISOString().split("T")[0];
            let dataEntrada = campoData.getAttribute("min");

            if (!dataConclusao) {
                alert("A data de conclusão é obrigatória.");
                return;
            }

            if (dataConclusao > hoje) {
                alert("A data de conclusão não pode ser posterior à data atual.");
                campoData.value = "";
                return;
            }

            if (dataConclusao < dataEntrada) {
                alert("A data de conclusão não pode ser anterior à data de entrada da OS.");
                campoData.value = "";
                return;
            }

            const formData = new FormData();
            formData.append('id', id);
            formData.append('status', novoStatus);
            formData.append('data_conclusao', dataConclusao);

            fetch(url, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    alert('Status atualizado com sucesso!');
                    window.location.reload();
                })
                .catch(err => {
                    alert("Erro ao atualizar: " + err.message);
                });

            campoData.removeEventListener('change', enviarData);
        });

        return;
    }

    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', novoStatus);

    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            alert('Status atualizado!');
            window.location.reload();
        })
        .catch(err => {
            alert("Erro ao atualizar: " + err.message);
            window.location.reload();
        });
}
