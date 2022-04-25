<?php
declare(strict_types=1);
require_once('./Db_function.php');

session_start();
$error = [];
$beans_name = $_POST['beans_name'] ?? '';
$region = $_POST['region'] ?? '';

// 長いので、$standardでループにすべき？
$taist = [];
$taist_int = [];
$taist['aroma'] = $_POST['aroma'] ?? '';
$taist['acidty'] = $_POST['acidty'] ?? '';
$taist['sweetness'] = $_POST['sweetness'] ?? '';
$taist['body'] = $_POST['body'] ?? '';
$taist['bitter'] = $_POST['bitter'] ?? '';

$roasting = $_POST['roasting'] ?? '';
$price = $_POST['price'] ?? '';
$memo = $_POST['memo'] ?? '';
//var_dump($beans_name, $region, $taist, $roasting, $price, $memo);

// validate & エスケープ
if($beans_name === ''){ // 入力されなかった場合はエラー
    $error["beans_name"] = true;
}
else{ // 入力された場合はエスケープ
    $beans_name_e = htmlspecialchars($beans_name);
}

// エスケープのみ
$region_e = htmlspecialchars($region);

// ハッシュ配列でループさせ、1~5の場合はintに直して配列で保存
foreach( $taist as $k => $v ){
    if(preg_match('/[1-5]/', $v)){
        $taist_int[$k] = (int)$v;
    }else{
        $error[$k] = true;
    }
}

if($roasting === ''){ // 入力されなかった場合はエラー
    $error["roasting"] = true;
}
else{ // それ以外はエスケープ
    $roasting_e = htmlspecialchars($roasting);
}

// 0より大きい数字だけなら型を直して保存
if(preg_match('/^[1-9]\d*$/', $price)){
    $price_int = (int)$price;
}
else{
    $error['price'] = true;
}

// エスケープのみ
$memo_e = htmlspecialchars($memo);
/*
var_dump($beans_name_e);
var_dump($region_e);
var_dump($taist_int);
var_dump($roasting_e);
var_dump($price_int);
var_dump($memo_e);
*/
if([] != $error){
    $_SESSION['flash']['form']['error'] = true;
    $_SESSION['flash']['form']['beans_name'] = $beans_name_e;
    $_SESSION['flash']['form']['region'] = $region_e;
    $_SESSION['flash']['form']['taist'] = $taist_int;
    $_SESSION['flash']['form']['roasting'] = $roasting_e;
    $_SESSION['flash']['form']['price'] = $price_int;
    $_SESSION['flash']['form']['memo'] = $memo_e;
    $_SESSION['flash']['error'] = $error;
    
    var_dump($_SESSION['flash']['form']);
    header('Location: ./add_beans.php');
    exit;
}

try{
    $dbh = DBhandle();
    $table_name = 'beans';
    $sql = "INSERT INTO beans (`beans_name`,`region`,`aroma`,`acidty`,`sweetness`,`body`,`bitter`,`roasting`,`price`, `memo`) 
        VALUES(:beans_name, :region, :aroma, :acidty, :sweetness, :body, :bitter, :roasting, :price, :memo);";
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":beans_name", $beans_name_e);
    $pre->bindValue(":region", $region_e);
    $pre->bindValue(":aroma", $taist_int['aroma']);
    $pre->bindValue(":acidty", $taist_int['acidty']);
    $pre->bindValue(":sweetness", $taist_int['sweetness']);
    $pre->bindValue(":body", $taist_int['body']);
    $pre->bindValue(":bitter", $taist_int['bitter']);
    $pre->bindValue(":roasting", $roasting_e);
    $pre->bindValue(":price", $price_int);
    $pre->bindValue(":memo", $memo_e);

    $r = $pre->execute();
    var_dump($r);
}catch( \PDOException $e){
    echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
    exit;
}

