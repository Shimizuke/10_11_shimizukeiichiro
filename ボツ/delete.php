<?php
//1. GETデータ取得
$id   = $_GET['id'];

//2. DB接続します(エラー処理追加)
include('functions.php');
$pdo = connectToDb();

//3．データ登録SQL作成
$sql = 'DELETE FROM uploda_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //select.phpへリダイレクト
  header('Location: select.php');
  exit;
}
