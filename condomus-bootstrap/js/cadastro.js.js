document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('formCadastro');
  const senhaInput = document.getElementById("senha");
  const confirmarInput = document.getElementById("confirmarSenha");
  const cpfInput = document.getElementById("cpf");

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    form.classList.add("was-validated");

    const senha = senhaInput.value;
    const confirmar = confirmarInput.value;

    if (senha !== confirmar) {
      alert("As senhas não coincidem!");
      return;
    }

    if (form.checkValidity()) {
      alert("Cadastro realizado com sucesso!");
    }
  });

  cpfInput.addEventListener("input", function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = value;
    }
  });
});
