<?php

require_once __DIR__ . '/functions.php';

// データベースに接続
$dbh = connect_db();

// SQL文の組み立て
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $keyword = $_GET['keyword'];
    $sql = "SELECT * FROM animals WHERE description LIKE '%{$keyword}%'";
}

// プリペアドステートメントの準備
// $dbh->query($sql) でも良い
$stmt = $dbh->prepare($sql);

// プリペアドステートメントの実行
$stmt->execute();

// 結果の受け取り
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pet_shop</title>
</head>

<body>
    <h2>本日のご紹介ペット!</h2>
    <form action="" method="get">
        キーワード<input type="text" name="keyword">
        <input type="submit" value="送信">
    </form>
    <?php foreach ($animals as $animal) : ?>
        <p><?= h($animal['type']) ?>の<?= h($animal['classification']) ?>ちゃん<br><?= h($animal['description']) ?><br><?= h($animal['birthday']) ?><br>出身地:<?= h($animal['birthplace']) ?></p>
        <hr>
    <?php endforeach; ?>
</body>

</html>