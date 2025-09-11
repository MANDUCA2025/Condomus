<?php
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['success' => false, 'message' => 'E-mail inválido']);
  exit;
}

// Simulação de verificação se o e-mail existe
$usuarios = file('usuarios.csv', FILE_IGNORE_NEW_LINES);
$existe = false;
foreach ($usuarios as $linha) {
  $dados = str_getcsv($linha);
  if (strtolower($dados[1]) === strtolower($email)) { // posição 1 = e-mail
    $existe = true;
    break;
  }
}

if (!$existe) {
  echo json_encode(['success' => false, 'message' => 'E-mail não encontrado']);
  exit;
}

// Gerar código e salvar
$codigo = rand(100000, 999999);
file_put_contents("codigos_recuperacao/$email.txt", $codigo);

// Enviar e-mail
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.seudominio.com';      // 🔁 Altere aqui
  $mail->SMTPAuth = true;
  $mail->Username = 'seuemail@seudominio.com'; // 🔁 Altere aqui
  $mail->Password = 'SENHA_DO_EMAIL';          // 🔁 Altere aqui
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('seuemail@seudominio.com', 'CONDOMUS');
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = 'Código de recuperação de senha - CONDOMUS';
  $mail->Body    = "<p>Seu código de verificação é: <strong>$codigo</strong></p><p>Use esse código para redefinir sua senha.</p>";

  $mail->send();
  echo json_encode(['success' => true]);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => 'Erro ao enviar e-mail: ' . $mail->ErrorInfo]);
}
