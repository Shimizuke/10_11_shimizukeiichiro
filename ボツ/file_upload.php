<?php

var_dump($_FILES);
// exit();
//Fileアップロードチェック
// isset関数は、この変数に値がはいっているかどうかをチェックする関数
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

  // ファイルをアップロードしたときの処理
  //アップロードしたファイルの情報取得
  $uploadedFileName = $_FILES['image']['name'];
  $tempPathName = $_FILES['image']['tmp_name'];
  $fileDirectoryPath = 'upload/';
  //File名の変更
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


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FileUploadテスト</title>
</head>

<body>
  <?= $img ?>
</body>

</html>