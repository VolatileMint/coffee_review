<?php
declare(strict_types=1);
$standard = ["香り"=>"aroma", "酸味"=>"acidry", "甘味"=>"sweetness", "コク"=>"body", "苦味"=>"bitter"];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>コーヒー豆の追加</title>
</head>
<body>
<h1>コーヒー豆を追加する</h1>
<h2>コーヒー豆の情報を入力</h2>
<form method="POST" action="add_bean_chech.php">
    銘柄：
    <input type="text" name="beans_name" required><br>
    生産地：
    <input type="text" name="region"><br>
    <?php foreach($standard as $k=>$v): ?>
        <?= $k ?>：
        <select name="<?= $v ?>">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br>
    <?php endforeach; ?>
    焙煎温度：
    <input type="text" name="roasting">℃<br>
    値段(200gあたり)：
    <input type="number" name="price" required>円<br>
    備考<br>
    <textarea name="memo" cols="30" rows="10"></textarea><br>
    <input type="submit" value="追加確認">
</form>
</body>
</html>