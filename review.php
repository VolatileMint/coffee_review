<?php
declare(strict_types=1);
require_once('./Db_function.php');

$date = $_GET['date'] ?? '';

// 送られた日付が正しくない場合は今日の日付に直す
if (!strtotime($date)) {
    $date = date('Y-m-d');
}
/* 
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
*/
// dbからとってくる
$beans_list = ["beans_id" => "beans_name", "1" => "ブラジルさくらブルボン"];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>デイリーレビュー追加</title>
</head>
<body>
    <h1>レビューを書く</h1>
    <form action="review_check.php" method="post">
        日付：<input type="date" value="<?= $date ?>"><br>
        豆の種類：
        <select name="beans_id">
            <?php foreach($beans_list as $k => $v){
                echo "<option value={$k}>{$v}</option>";
            } ?>
        </select>
        <br>点数：
        <select name="score">
            <?php for($i = 1; $i <= 5; $i++){
                echo "<option value={$i}>{$i}</option>";
            } ?>
        </select>
        <br>コメント：
        <textarea name="review" cols="30" rows="10"></textarea><br>
        <input type="submit" value="レビューを投稿する">
    </form>
</body>
</html>