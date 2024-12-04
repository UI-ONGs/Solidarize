<?php

$host = 'sql204.infinityfree.com';
$db   = 'if0_37518337_solidarize';
$user = 'if0_37518337';
$pass = 'kIHOlFSMoi';

$mysqli = new mysqli($host, $user, $pass, $db);

if (!$mysqli) {
    die("Erro de conexão: " . mysqli_connect_error());
}
?>