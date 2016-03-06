<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDB();

$sql = 'select * from posts order by updated_at desc';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog</title>
</head>
<body>
    <h1>Blog</h1>
    <a href="add.php">新規記事投稿</a>
    <?php foreach ($posts as $post) :?>
        <p>
            <a href="show.php?id=<?=$post["id"] ?>">
            <?= h($post["title"]); ?></a><br>
            <?= h($post["body"]); ?><br>
            "投稿日時:"<?php echo h($post["updated_at"]); ?>
            <hr>
        </p>
    <?php endforeach; ?>
</body>
</html>