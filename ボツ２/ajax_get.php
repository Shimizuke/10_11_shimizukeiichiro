
<?php
include('functions.php');

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
$sql = 'SELECT * FROM uploda_table2';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ表⽰
if ($status == false) {
errorMsg($stmt);
} else {
// fetchAll()で全部取れる
echo json_encode($stmt->fetchAll());
}