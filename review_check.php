<?php
declare(strict_types=1);
require_once('./Db_function.php');

session_start();
$error = [];
$beans_id = $_POST['beans_id'] ?? '';
$score = $_POST['score'] ?? '';
$review = $_POST['review'] ?? '';
var_dump($beans_id, $score, $review);

// validate & エスケープ
// 0より大きい数字だけなら型を直して保存
if(preg_match('/^\d*$/', $beans_id)){
    $beans_id_int = (int)$beans_id;
}
else{
    $error['beans_id'] = true;
}
// 1~5の場合はintに直して保存
if(preg_match('/[1-5]/', $score)){
    $score_int = (int)$score;
}else{
    $error['score'] = true;
}
// 空白以外ならエスケープ
if($review === ''){
    $error['review'] = true;
}else{
    $review_e = htmlspecialchars($review);
}
//var_dump($beans_id_int);
//var_dump($score_int);
//var_dump($review_e);

if([] != $error){
    $_SESSION['flash']['form']['error'] = true;
    $_SESSION['flash']['form']['beans_id'] = $beans_id_int;
    $_SESSION['flash']['form']['score'] = $score_int;
    $_SESSION['flash']['form']['review'] = $review_e;
    $_SESSION['flash']['error'] = $error;
    
    var_dump($_SESSION['flash']['form']);
    header("Location: ./review.php?id={$beans_id}");
    exit;
}
exit;
$data = [
    'beans_name' => $beans_name_e,
    'region' => $region_e,
    'aroma' => $taist_int['aroma'],
    'acidty' => $taist_int['acidty'],
    'sweetness' => $taist_int['sweetness'],
    'body' => $taist_int['body'],
    'bitter' => $taist_int['bitter'],
    'roasting' => $roasting_e,
    'price' => $price_int,
    'memo' => $memo_e,
];
try{
    Dbclass::Create($data);
    header('Location: ./index.php');
    exit;
}catch( \PDOException $e){
    echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
    exit;
}
