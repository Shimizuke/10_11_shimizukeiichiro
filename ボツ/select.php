<?php
include('functions.php');

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
$sql = 'SELECT * FROM uploda_table ORDER BY deadline DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  $view = '';
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<li class="list-group-item">';
    $view .= '<p>' . $result['file_name'] . '-' . $result['date'] . '</p>';
    $view .= '<p>' . $result['comment'] . '</p>';
    // imgタグで出力しよう！
    // $view .= '<img src="' . $result['image'] . '" alt="" height="150px">';
    $view .= '<div><a href="detail.php?id=' . $result['id'] . '" class="badge badge-primary">download</a>';
    $view .= '<a href="delete.php?id='
      . $result['id'] . '" class="badge badge-danger">Delete</a></div>';
    $view .= '</li>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>todoリスト表示</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <style>
    div {
      padding: 10px;
      font-size: 16px;
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">todo一覧</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">todo登録</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="select.php">todo一覧</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div>
    <ul class="list-group">
      <?= $view ?>
    </ul>
  </div>

</body>

</html>