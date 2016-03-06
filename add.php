<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $title = $_POST['title'];
    $body = $_POST['body'];
    $errors = array();

    if (empty($title))
    {
        $errors['title'] = 'タイトルを入力して下さい';
    }
    if (empty($body))
    {
        $errors['body'] = '本文を入力して下さい';
    }
    if (empty($errors))
    {
        $sql = 'insert into posts ';
        $sql.= '(title, body, created_at, updated_at) ';
        $sql.= ' values ';
        $sql.= '(:title, :body, ';
        $sql.= 'now(), now())';

        $stmt = $dbh->prepare($sql);
        $stmt->bindparam(':title', $title);
        $stmt->bindparam(':body', $body);
        $stmt->execute();

        header('Location: index.php');
        exit;
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新規記事投稿</title>
</head>
<body>
    <h1>新規記事投稿</h1>
    <a href="index.php">戻る</a>
    <?php if (!empty($errors)) :?>
        <?php foreach ($errors as $error) :?>
            <span style="color: red;">
                <li><?php echo $error; ?></li>
            </span>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="" method="post">
        <p>タイトル<br>
            <input type="text" name="title"></input>
        </p>
        <p>
            <span style="color: red;">
                <?php echo h($errors['title']); ?>
            </span>
        </p>
        <p>本文<br>
            <textarea name="body" cols="50" rows="5"></textarea>
        </p>
        <p>
            <span style="color: red;">
                <?php echo h($errors['body']); ?>
            </span>
        </p>
        <p>
            <input type="submit" value="投稿する"></input>
        </p>
    </form>
</body>
</html>