<?php

function DBhandle(){
    $type = 'mysql';
    $user = 'root';
    $pass = '';
    $host = 'localhost';
    $dbname = 'study';
    $charset = 'utf8mb4';

    $dsn = "mysql:dbname={$dbname};host={$host};charset={$charset}";
    $options = [
        \PDO::ATTR_EMULATE_PREPARES => false, // エミュレート無効
        \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, // 複文無効
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // エラー時に例外を投げる(好み)
    ];
    try {
        $dbh = new \PDO($dsn, $user, $pass, $options);
        return $dbh;
    }catch( \PDOException $e){
        echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
        exit;
    }
}