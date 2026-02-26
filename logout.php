<?php
session_start();

$_SESSION = [];            // limpa variáveis
session_unset();           // remove dados da sessão
session_destroy();         // destrói sessão

header("Location: auth/login.php");
exit();
