<?php
require_once '../../sql/connect.php';

//Função para abreviar o metódo $conn->query.
function query($conn, $sql) 
{
    if (($query = $conn->query($sql)) === false) {
        die("Erro: " . $conn->error . "<br>");
    }
    return $query;
}

