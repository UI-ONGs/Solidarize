<?php

//função pra mandar email (não funciona no inifinity free)
$to = "guilhermesouza3278@exemplo.com";
$subject = "Teste Envio de E-mail Via PHP";
$message = "Este é um teste de email enviado via PHP";
$headers = "From: guilhermesouza3278@gmail.com\r\n";
$headers .= "Reply-To: guilhermesouza3278@gmail.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if(mail($to, $subject, $message, $headers)) {
    echo "E-mail enviado com sucesso.";
} else {
    echo "Falha ao enviar o e-mail.";
}
?>