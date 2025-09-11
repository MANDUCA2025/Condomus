// Função global para alternar o modo escuro
function toggleDarkMode() {
  document.body.classList.toggle("dark-mode");
  // Salva a preferência do usuário no localStorage
  localStorage.setItem("modoEscuro", document.body.classList.contains("dark-mode"));
}

// Aguarda o conteúdo da página ser carregado para executar os scripts
window.addEventListener("DOMContentLoaded", () => {
  // Aplica o modo escuro se já estiver salvo no localStorage
  if (localStorage.getItem("modoEscuro") === "true") {
    document.body.classList.add("dark-mode");
  }

  // Adiciona o evento de clique ao botão de modo escuro
  const darkToggleButton = document.querySelector('.dark-toggle-btn');
  if (darkToggleButton) {
    darkToggleButton.addEventListener('click', toggleDarkMode);
  }

  // --- LÓGICA ESPECÍFICA DA PÁGINA DE LOGIN ---
  const formLogin = document.getElementById("formLogin");

  // Este bloco de código só será executado se o formulário de login existir na página
  if (formLogin) {
    const senha = document.getElementById("senha");
    const togglePasswordButton = document.querySelector(".toggle-password");
    const iconEye = togglePasswordButton.querySelector("i");

    // Função para alternar a visibilidade da senha
    function togglePasswordVisibility() {
      const isPassword = senha.type === "password";
      senha.type = isPassword ? "text" : "password";
      iconEye.classList.toggle("bi-eye");
      iconEye.classList.toggle("bi-eye-slash");
    }

    // Adiciona o evento de clique ao botão de mostrar/ocultar senha
    if (togglePasswordButton) {
      togglePasswordButton.addEventListener('click', togglePasswordVisibility);
    }
    
    // Adiciona o evento de submissão do formulário
    formLogin.addEventListener("submit", function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      this.classList.add("was-validated"); // Ativa a validação do Bootstrap

      // Se o formulário não for válido, interrompe a execução
      if (!this.checkValidity()) {
        return;
      }

      // Lógica de login (simulação)
      // No futuro, aqui você faria uma chamada para o backend para validar o usuário
      console.log("Formulário válido. Redirecionando...");
      window.location.href = "dashboard_morador.html";
    });
  }
});