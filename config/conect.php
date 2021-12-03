<?php
/** Endereco*/
$hostname="51.38.121.199";
/**Usuario */
$user="lifelife_balango";
/**Senha */
$password="Balango@dev1";
/**Banco de dados */
$banco="lifelife_dbgame";
/**Verifiando o erro de conexao */
$mysqli = new mysqli($hostname, $user, $password, $banco);
if ($mysqli ->connect_errno){
echo "Falha ao connectar: (" .$mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>