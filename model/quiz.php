<?php
function getUsers(PDO $pdo): array|string
{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT *  FROM users ORDER BY username LIMIT 10";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return "Error: ".$e->getCode() .' : '. $e->getMessage();
    }

    $res = $prep->fetchAll();
    $prep->closeCursor();

    return $res;
}


?> 