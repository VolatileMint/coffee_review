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
</head>
<body>
<h1>トップページ</h1>

<?php
//表示させる年月を設定　↓これは現在の月
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    $ym = date('Y-m');	
}
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}
$today = date('Y-m-j');
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));
//月末日を取得
$end_month = date('t', $timestamp);
//朔日の曜日を取得
$first_week = date('w', strtotime('-1 day',$timestamp));
?>


<?php echo $ym; ?>のカレンダー
<table border=1>
    <tr>
        <th>日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
    </tr><a href=""></a>
    <tr>
    <?php for($i = 0; $i < $first_week; ++$i): ?>
        <td></td>
    <?php endfor;?>
    <?php for($day = 1; $day <= $end_month; ++$day): ?>
        <td>
            <a href="review.php?date=<?= date('Y-m-d', strtotime($ym . "-" . $day)) ?>">
            <?= date('d', strtotime($ym . "-" . $day))?>
            </a>
        </td>
        <?php if( ($first_week + $day) % 7 === 0): ?>
            </tr><tr>
        <?php endif;?>
    <?php endfor; ?>
    </tr>
</table>
<a href="add_beans.php">コーヒー豆を追加する</a>
<hr>

</body>
</html>