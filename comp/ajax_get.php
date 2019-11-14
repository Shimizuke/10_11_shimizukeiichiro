<?php
// 関数のファイル読み込み
include('functions.php');

// DB接続
$pdo = connectToDb();

// データ表示SQL作成
$sql = 'SELECT * FROM ajax_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ表示
if ($status == false) {
  errorMsg($stmt);
} else {
  echo json_encode($stmt->fetchAll());
}
