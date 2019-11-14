<?php
// 関数のファイルを読み込み
include('functions.php');

// 入力チェック，コメントは入力必須
if (!isset($_POST['comment']) || $_POST['comment'] == '') {
  exit('ParamError');
} else {
  $comment = $_POST['comment'];
}

//POSTデータ取得，名前は入力なしの場合「名無しさん」にする
if (!isset($_POST['name']) || $_POST['name'] == '') {
  $name = '名無しさん';
} else {
  $name = $_POST['name'];
}

//Fileアップロードチェック
// エラーが発生していないか条件分岐
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // ファイルをアップロードしたときの処理
  // アップロードしたファイルの情報取得
  $file_name = $_FILES['upfile']['name'];
  $tmp_path  = $_FILES['upfile']['tmp_name'];
  $file_dir_path = 'upload/';

  //File名の変更
  $extension = pathinfo($file_name, PATHINFO_EXTENSION);
  $uniq_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $file_name = $file_dir_path . $uniq_name;

  // FileUpload開始
  if (is_uploaded_file($tmp_path)) {
    if (move_uploaded_file($tmp_path, $file_name)) {
      chmod($file_name, 0644);
      // アップロードしたファイルの情報含めてdbへの登録SQL作成
      $sql = 'INSERT INTO ajax_table(id, name, comment, image, indate) VALUES(NULL, :a1, :a2, :image, sysdate())';
    } else {
      exit('Error:アップロードできませんでした．');
    }
  }
  // FileUpload終了
} else {
  // ファイルをアップしていないときはimageカラムにnullを入れる
  $sql = 'INSERT INTO ajax_table(id, name, comment, image, indate) VALUES(NULL, :a1, :a2, null, sysdate())';
}



// DB接続する関数を実行
$pdo = connectToDb();

// dbへの登録SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $comment, PDO::PARAM_STR);
// ファイルアップロードしているときのみ，:imageにファイルパスを設定する
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  $stmt->bindValue(':image', $file_name, PDO::PARAM_STR);
}
$status = $stmt->execute();


// 登録後にデータ取得
$sql = 'SELECT * FROM ajax_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データをjsonにして渡す
$view = '';
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  echo json_encode($stmt->fetchAll());
}
