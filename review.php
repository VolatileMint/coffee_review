<?php
declare(strict_types=1);
require_once('./Db_function.php');

$id = $_GET['id'] ?? '';
// idの指定がなかったらindexに戻す
if($id === ''){
    header('Location: ./index.php');
    exit;
}
if($id !== ''){
    try {
        $dbh = DBclass::gethandle();
        $table_name = 'beans';
        $sql = "SELECT * FROM {$table_name} WHERE beans_id=:beans_id;";
        $pre = $dbh->prepare($sql);
        $pre->bindValue(":beans_id", $id, \PDO::PARAM_INT);
        $pre->execute();
        $arr = $pre->fetch(PDO::FETCH_ASSOC);
        var_dump($arr);
    }catch( \PDOException $e){
        echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
        exit;
    }
}

// var_dump($id);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レビュー追加</title>
</head>
<body>
    <h1>レビューを書く</h1>
    <form action="review_check.php" method="post">
        <input type="hidden" name="beans_id" value="<?= $id ?>">
        点数：
        <select name="score">
            <?php for($i = 1; $i <= 5; $i++){
                echo "<option value={$i}>{$i}</option>";
            } ?>
        </select>
        <br>コメント：
        <textarea name="review" cols="30" rows="10"></textarea>
        <input type="submit" value="レビューを投稿する">
    </form>
    <hr>
    <h2><?= $arr['beans_name'];?></h2>
    <p>200g 当たり <?= $arr['price'];?>円</p>
    <p>産地：<?= $arr['region'];?><p>
    <p><?= $arr['memo'];?></p><br>
    <table border="1">
        <tr><th>香り</th><td><?= $arr['aroma'];?></td><th>酸味</th><td><?= $arr['acidty'];?></td></tr>
        <tr><th>甘さ</th><td><?= $arr['sweetness'];?></td><th>コク</th><td><?= $arr['body'];?></td></tr>
        <tr><th>苦味</th><td><?= $arr['bitter'];?></td><th>焙煎</th><td><?= $arr['roasting'];?></td></tr>
    </table>
    <hr>
</body>
</html>