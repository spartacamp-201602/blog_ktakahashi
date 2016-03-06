<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (empty($_SESSION['id']))
{
    header('Location: login.php');
    exit;
}

$dbh = connectDB();

$sql = 'select * from users where id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'select * from posts order by updated_at desc';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>会員制Blog</title>
</head>
<body>
    <h1>会員制Blog</h1>
    <h3>
        ようこそ<?= $user['name'] ?>さん
    </h3>
    <p>
        <a href="add.php">新規記事投稿</a>
    </p>
    <p>
        <a href="edit_profile.php">ユーザー情報編集</a>
    </p>
    <p>
        <a href="logout.php">ログアウト</a>
    </p>
    <hr>
    <?php foreach ($posts as $post) :?>
        <p>
            <a href="show.php?id=<?=$post["id"] ?>">
            <?= h($post["title"]); ?></a><br>
            <?= mb_strimwidth(h($post["body"]), 0, 20, '...'); ?><br>
            "投稿日時:"<?php echo h($post["updated_at"]); ?>
            <hr>
        </p>
    <?php endforeach; ?>
</body>
</html>