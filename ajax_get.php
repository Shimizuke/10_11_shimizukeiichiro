<?php
// 関数のファイル読み込み
include('functions.php');
// DB接続
$pdo = connectToDb();
// データ表⽰SQL作成（テーブルから全件読み込み）
$sql = 'SELECT * FROM ajax_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
// データ表⽰
if ($status == false) {
    errorMsg($stmt);
} else {
    // fetchAll()で全部取れる
    echo json_encode($stmt->fetchAll());
}
