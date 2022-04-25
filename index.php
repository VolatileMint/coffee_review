<?php
declare(strict_types=1);
require_once('./Db_function.php');
/*
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
];*/
try {
    $dbh = DBhandle();
    //$dbh = new \PDO($dsn, $user, $pass, $options);
    $table_name = 'beans';
    $sql = "SELECT * FROM {$table_name} WHERE 1";
    $pre = $dbh->prepare($sql);
    $pre->execute();
    $arr = $pre->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($arr);
}catch( \PDOException $e){
    echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
    exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>トップ</title>
</head>
<body>
<h1>トップページ</h1>
<h2>コーヒー評価</h2>
<a href="add_beans.php">コーヒー豆を追加する</a>
<a href="review.php">評価する</a>

<?php foreach($arr as $v): ?>
    <ul>
        <li>名前：<?= $v['beans_name'];?></li>
        <li>産地：<?= $v['region'];?></li>
        <li>香り：<?= $v['aroma'];?></li>
        <li>酸味：<?= $v['acidty'];?></li>
        <li>甘さ：<?= $v['sweetness'];?></li>
        <li>コク：<?= $v['body'];?></li>
        <li>苦味：<?= $v['bitter'];?></li>
        <li>焙煎：<?= $v['roasting'];?></li>
        <p>紹介文：<?= $v['memo'];?></p><br>
    </ul>
<?php endforeach; ?>

</body>
</html>