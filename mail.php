<?php

// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("classes/email/class.phpmailer.php");
require("classes/email/class.smtp.php");

// Inicia a classe PHPMailer
$mail = new PHPMailer();

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "10.52.132.28";//"smtpcentro.ccarj.intraer"; // Endereço do servidor SMTP
$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
//$mail->SMTPSecure = 'ssl';
//$mail->Username = 'stibacg'; // Usuário do servidor SMTP
//$mail->Password = '@dmin$t1#'; // Senha do servidor SMTP 
//$mail->Port = 587;

$mail->Username = 'same_consultas'; // Usuário do servidor SMTP
$mail->Password = '@dmin$t1#'; // Senha do servidor SMTP 
$mail->Port = 25;


// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->From = "same_consultas@bacg.aer.mil.br"; // Seu e-mail
$mail->FromName = utf8_decode("AGENDAMENTO MÉDICO"); // Seu nome

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAddress('massariolmc@gmail.com', 'Fulano da Silva');
$mail->AddAddress($email_paciente);
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->Subject  = utf8_decode("Agendamento Médico"); // Assunto da mensagem
$mail->Body = $conteudo_email;//"Este é o corpo da mensagem de teste, em <b>HTML</b>! <br /> :)";
$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

// Envia o e-mail
$enviado = $mail->Send();

// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

// Exibe uma mensagem de resultado
if ($enviado) {
echo "E-mail enviado com sucesso!";
} else {
echo "Não foi possível enviar o e-mail.<br /><br />";
echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
}

?>

