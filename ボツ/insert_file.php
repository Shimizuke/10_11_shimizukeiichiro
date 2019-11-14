<?php
//index.phpから送られてきたデータをtmp領域に一時保管する処理

include('functions.php');
// 入力チェック
if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('ParamError');
}
//POSTデータ取得
$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];

// var_dump($_FILES);
// exit();
//Fileアップロードチェック
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {

  // ファイルをアップロードしたときの処理
  //アップロードしたファイルの情報取得(upfileはindex.phpのimage―input―name由来)
  $uploadedFileName = $_FILES['upfile']['name'];
  $tempPathName = $_FILES['upfile']['tmp_name'];
  $fileDirectoryPath = 'upload/';
  //File名の変更 ($extension→ファイル名取得（ファイル名＋拡張子）)
  //$uniqueName→日付＋セッションid 
  $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
  $uniqueName = date('YmdHis') . md5(session_id()) . "." . $extension;
  $fileNameToSave = $fileDirectoryPath . $uniqueName;
  // var_dump($fileNameToSave);
  // exit();
  if (is_uploaded_file($tempPathName)) {
    if (move_uploaded_file($tempPathName, $fileNameToSave)) {
      chmod($fileNameToSave, 0644); //権限の変更
      $img = '<img src="' . $fileNameToSave . '" >'; //
    } else {
      exit("ファイルの保存に失敗しました");
    }
  } else {
    exit("ファイルがアップロードされていません");
  }
  // FileUpload開始
  // FileUpload終了
} else {
  // ファイルをアップしていないときの処理
  $img = '画像が送信されていません';
}

//POSTデータ取得

// Fileアップロードチェック
// FileUpload終了
// } else {
//   // ファイルをアップしていないときの処理
//   exit('画像が送信されていません');
// }
//DB接続
$pdo = connectToDb();

//データ登録SQL作成
$sql = 'INSERT INTO php02_table (id, task,deadline, comment, image, indate) VALUES (NULL,:a1,:a2,:a3,:image,sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
$status = $stmt->execute();


//データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //index.phpへリダイレクト
  header('Location: index.php');
}
