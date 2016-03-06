<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = 'select * from posts where id = :id';
$id = $_GET['id'];

$stmt = $dbh->prepare($sql);
$stmt->bindparam(':id', $id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <h1><?php echo h($post['title']) ?></h1>
    <p>
        <a href="index.php">戻る</a>
        [#<?php echo $post['id'] ?>]
        @<?php echo $post['title'] ?><br>
        <a href="edit.php?id=<?php echo $post['id'] ?>">[編集]</a>
        <a href="delete.php?id=<?php echo $post['id'] ?>">[削除]</a>
        投稿日時：<?php echo $post['updated_at'] ?>
        <hr>
    </p>
</body>
</html>