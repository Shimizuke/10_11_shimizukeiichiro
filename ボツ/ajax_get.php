<?php
include('functions.php');

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
$sql = 'SELECT * FROM uploda_table ORDER BY date DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
if ($status == false) {
    // showSqlErrorMsg($stmt);
    errorMsg($stmt);
} else {
    $res = [];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $res[] = $result; // 􃓄􀸴􄛻􀶰􄜜􄜛
    }
    echo json_encode($res); // json形式にして出力
}
