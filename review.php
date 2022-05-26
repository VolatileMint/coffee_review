<?php
declare(strict_types=1);
require_once('./Db_function.php');

$date = $_GET['date'] ?? '';

// 送られた日付が正しくない場合は今日の日付に直す
if (!strtotime($date)) {
    $date = date('Y-m-d');
}

try {
    $dbh = DBclass::gethandle();
    $table_name = 'beans';
    $sql = "SELECT * FROM {$table_name};";
    $pre = $dbh->prepare($sql);
    $pre->execute();
    $arr = $pre->fetchAll(PDO::FETCH_ASSOC);
}catch( \PDOException $e){
    echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
    exit;
}

// 豆情報dbからとってくる
$beans_list = array_column($arr, 'beans_name','beans_id');
var_dump($beans_list);
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