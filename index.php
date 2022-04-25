<?php
declare(strict_types=1);
require_once('./Db_function.php');

try {
    $dbh = DBclass::gethandle();
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
    <link rel="stylesheet" type="text/css" href="test.css">
</head>
<body>
<h1>トップページ</h1>
<h2>コーヒー評価</h2>
<a href="add_beans.php">コーヒー豆を追加する</a>
<a href="review.php">評価する</a>
<hr>
<?php foreach($arr as $v): ?>
    <div class="wrapper">
        <div class="left">
            <h2><?= $v['beans_name'];?></h2>
            <p>200g 当たり <?= $v['price'];?>円</p>
            <p>産地：<?= $v['region'];?><p>
            <p><?= $v['memo'];?></p><br>
            <a href="review.php?id=<?= $v['beans_id']?>">レビューを書く</a>
        </div>
        <div class="right">
            <table border="1">
                <tr><th>香り</th><td><?= $v['aroma'];?></td></tr>
                <tr><th>酸味</th><td><?= $v['acidty'];?></td>
                <tr><th>甘さ</th><td><?= $v['sweetness'];?></td>
                <tr><th>コク</th><td><?= $v['body'];?></td>
                <tr><th>苦味</th><td><?= $v['bitter'];?></td>
                <tr><th>焙煎</th><td><?= $v['roasting'];?></td>
            </table>
        </div>
        
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>