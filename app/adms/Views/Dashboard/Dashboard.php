<?php

echo "VIEW - Dashboard<br>";
echo "Bem vindo " . "<strong>" . $_SESSION['user_name'] . "</strong>" . "<br>";

echo "<a href='" . URLADM . "logout/index'>Sair</a>";
