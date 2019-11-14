<?php
include('functions.php');
// 入力チェック
if (
    !isset($_FILES['image']) || $_FILES['image'] == '' ||
    !isset($_POST['date']) || $_POST['date'] == ''

) {
    exit('ParamError');
}

//imageのエラーチェック
// if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

//     // ファイルをアップロードしたときの処理
//     //アップロードしたファイルの情報取得
//     $uploadedFileName = $_FILES['image']['name'];
//     $tempPathName = $_FILES['image']['tmp_name'];
//     $fileDirectoryPath = 'upload/';
//     //File名の変更
//     $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
//     $uniqueName = date('YmdHis') . md5(session_id()) . "." . $extension;
//     $fileNameToSave = $fileDirectoryPath . $uniqueName;
//     // var_dump($fileNameToSave);
//     // exit();
//     if (is_uploaded_file($tempPathName)) {
//         if (move_uploaded_file($tempPathName, $fileNameToSave)) {
//             chmod($fileNameToSave, 0644); //権限の変更
//             $img = '<img src="' . $fileNameToSave . '" >'; //
//         } else {
//             exit("ファイルの保存に失敗しました");
//         }
//     } else {
//         exit("ファイルがアップロードされていません");
//     }
//     // FileUpload開始
//     // FileUpload終了
// } else {
//     // ファイルをアップしていないときの処理
//     $img = '画像が送信されていません';
// }

//POSTデータ取得
// $id = $_POST['id'];
$dwn_pw = $_POST['dwn_pw'];
$del_pw = $_POST['del_pw'];
$image = $_FILES['image'];
$date = $_POST['date'];
$comment = $_POST['comment'];

//DB接続
$pdo = connectToDb();

$sql = 'INSERT INTO uploda_table(id, date, dwn_pw, del_pw,image, comment, indate)
 VALUES(NULL, :a1, :a2, :a3,:image,:a4, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $date, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $dwn_pw, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $del_pw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
$stmt->bindValue(':a4', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

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
