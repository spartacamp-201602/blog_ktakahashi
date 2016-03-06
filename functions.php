<?php

function connectDb()
{
    try {
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
        return $dbh;
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}