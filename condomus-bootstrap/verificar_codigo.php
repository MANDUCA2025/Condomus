<?php
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$novaSenha = $_POST['senha'] ?? '';

if (!$email || !$codigo || !$novaSenha) {
  echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
  exit;
}

// Verificar se o código está correto
$caminho = "codigos_recuperacao/$email.txt";
if (!file_exists($caminho) || trim(file_get_contents($caminho)) !== $codigo) {
  echo json_encode(['success' => false, 'message' => 'Código incorreto']);
  exit;
}

// Atualizar senha em usuarios.csv (exemplo: campo 2 = senha)
$usuarios = file('usuarios.csv', FILE_IGNORE_NEW_LINES);
$novos = [];

foreach ($usuarios as $linha) {
  $dados = str_getcsv($linha);
  if (strtolower($dados[1]) === strtolower($email)) {
    $dados[2] = password_hash($novaSenha, PASSWORD_DEFAULT); // Criptografar senha
  }
  $novos[] = implode(',', $dados);
}

file_put_contents('usuarios.csv', implode(PHP_EOL, $novos));
unlink($caminho); // Remover código usado

echo json_encode(['success' => true]);
