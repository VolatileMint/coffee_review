<?php
declare(strict_types=1);

$beans_name = $_POST['beans_name'] ?? '';
$region = $_POST['region'] ?? '';

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
var_dump($beans_name, $region, $taist, $roasting, $price, $memo);

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