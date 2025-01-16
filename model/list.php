<?php
function getPersons(PDO $pdo, int $page = 1, int $itemPerPage): array | string
{
    $offset = (($page - 1) * $itemPerPage);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query="SELECT id, last_name, first_name, type  FROM persons 
          LIMIT $itemPerPage OFFSET $offset";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $persons = $prep->fetchAll(PDO::FETCH_ASSOC);
    $prep->closeCursor();

    // on renvoi le compteur global (pour la pagination)
    $query="SELECT COUNT(*) AS total  FROM persons";
    $prep = $pdo->prepare($query);
    try
    {
        $prep->execute();
    }
    catch (PDOException $e)
    {
        return " erreur : ".$e->getCode() .' :</b> '. $e->getMessage();
    }

    $count = $prep->fetch(PDO::FETCH_ASSOC);
    $prep->closeCursor();

    return [$persons, $count];
}