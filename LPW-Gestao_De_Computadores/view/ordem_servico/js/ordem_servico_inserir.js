document.getElementById("formOrdemServico").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = document.getElementById("formOrdemServico");
    const formData = new FormData(form);
    const msgBox = document.getElementById("msgAjax");

    const status = formData.get("status");
    if (status === "Concluida" || status === "Cancelada") {
        msgBox.innerHTML = `
            <div class="alert alert-danger">Não é permitido criar uma ordem já Concluída ou Cancelada.</div>
        `;
        return;
    }

    fetch("inserir.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(resposta => {

        if (resposta.includes("Ordem cadastrada com sucesso")) {

            msgBox.innerHTML = `
                <div class="alert alert-success">Ordem cadastrada com sucesso!</div>
            `;

            setTimeout(() => {
                window.location.href = "listar.php";
            }, 1500);

        } else {
            msgBox.innerHTML = `
                <div class="alert alert-danger">${resposta}</div>
            `;
        }
    })
    .catch(err => {
        msgBox.innerHTML = `
            <div class="alert alert-danger">Erro ao enviar a ordem: ${err}</div>
        `;
    });
});
