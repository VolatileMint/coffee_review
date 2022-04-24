<?php
declare(strict_types=1);
session_start();
// めんどうなので配列で保持保存の際にも使う予定なので置き場所考える
$standard = ["香り"=>"aroma", "酸味"=>"acidty", "甘味"=>"sweetness", "コク"=>"body", "苦味"=>"bitter"];
$session = $_SESSION['flash'] ?? [];
unset($_SESSION['flash']); // flashデータなので速やかに削除
/*
$test = $session['error'] ?? [];
var_dump($test);
*/
// 入力エラー時に値を保持
$form = $session['form'] ?? [];
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
<!-- エラー除けの為にformデータの有無の確認を入れる -->
<?php if($form != [] && $form['error'] == true): ?>
    入力エラーが発生しました
<?php endif;?>

<form method="POST" action="add_beans_chech.php">
    銘柄：
    <input type="text" name="beans_name" value="<?= $form['beans_name'] ?? '' ?>" required><br>
    生産地：
    <input type="text" name="region" value="<?= $form['region'] ?? ''  ?>"><br>
    <!-- 評価基準配列をループで回す -->
    <?php foreach($standard as $k=>$v){
        echo $k . "：";
        echo "<select name={$v}>";
        // 評価は五段階評価
        for($i = 1; $i <=5; $i++){
            echo "<option value={$i}";
            // formデータを同じ場合は選択済みにさせる 
            if($form !== [] && $form['taist'][$v] === $i){
                echo " selected ";
            }
            echo ">{$i}</option>";
        }
        echo "</select><br>";
    } ?>
    焙煎温度：
    <input type="text" name="roasting" value="<?= $form['roasting'] ?? '' ?>" >℃<br>
    値段(200gあたり)：
    <!-- numberだが　"e" が使えるので注意!-->
    <input type="number" name="price" value="<?= $form['price'] ?? ''  ?>" required>円<br>
    備考<br>
    <textarea name="memo" cols="30" rows="10" ><?= $form['memo'] ?? ''?></textarea><br>
    <input type="submit" value="追加確認">
</form>
</body>
</html>