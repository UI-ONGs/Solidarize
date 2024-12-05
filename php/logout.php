<?php
//destrói a sessão atual e redireciona o usuário para login.php
session_start();
session_destroy();
header('Location: ../Login.php');
exit;