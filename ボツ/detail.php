<?php
include('functions.php');

// getで送信されたidを取得
$id = $_GET['id'];

//DB接続します
$pdo = connectToDb();

//データ登録SQL作成，指定したidのみ表示する
$sql = 'SELECT * FROM uploda_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if ($status == false) {
  // エラーのとき
  showSqlErrorMsg($stmt);
} else {
  // エラーでないとき
  $rs = $stmt->fetch();
  // fetch()で1レコードを取得して$rsに入れる
  // $rsは配列で返ってくる．$rs["id"], $rs["task"]などで値をとれる
  // var_dump()で見てみよう
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>todo更新ページ</title>
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
      <a class="navbar-brand" href="#">todo更新</a>
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

  <form method="post" action="update.php">
    <div class="form-group">
      <label for="task">Task</label>
      <!-- 受け取った値をvaluesに埋め込もう -->
      <input type="text" class="form-control" id="task" name="task" placeholder="Enter task" value="<?= $rs['task'] ?>">
    </div>
    <div class="form-group">
      <label for="deadline">Deadline</label>
      <!-- 受け取った値をvaluesに埋め込もう -->
      <input type="date" class="form-control" id="deadline" name="deadline" value="<?= $rs['deadline'] ?>">
    </div>
    <div class="form-group">
      <label for="comment">Comment</label>
      <!-- 受け取った値挿入しよう -->
      <textarea class="form-control" id="comment" name="comment" rows="3"><?= $rs['comment'] ?></textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <!-- idは変えたくない = ユーザーから見えないようにする-->
    <input type="hidden" name="id" value="<?= $rs['id'] ?>">
  </form>

</body>

</html>