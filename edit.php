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
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $title = $_POST['title'];
    $body = $_POST['body'];

    if ($title == '')
    {
        $errors['title'] = 'タイトルを入力して下さい';
    }
    if ($body == '')
    {
        $errors['body'] = '本文を入力して下さい';
    }
    if ($post['title'] == $title &&
        $post['body'] == $body)
    {
        $errors[] = 'タイトルか本文どちらかを編集してください';
    }
    if (count($errors) == 0)
    {
        $sql = 'update posts ';
        $sql.= 'set title = :title, ';
        $sql.= 'body = :body, ';
        $sql.= 'updated_at = now() ';
        $sql.= 'where id = :id ';

        $stmt = $dbh->prepare($sql);
        $stmt->bindparam(':title', $title);
        $stmt->bindparam(':body', $body);
        $stmt->bindparam(':id', $id);
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
    <title>投稿内容を編集</title>
</head>
<body>
    <h1>投稿内容を編集</h1>
    <a href="index.php">戻る</a>
    <form action="" method="post">
        <?php if (isset($erros)): ?>
        <?php foreach ($errors as $error) :?>
        <li>
            <span style="color: red;">
                <?php echo error ?>
            </span>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
        <p>タイトル<br>
            <input type="text" name="title"
            value="<?php echo h($post['title']) ?>">
            </input>
        </p>
        <p>
            <span style="color: red;">
                <?php echo h($errors['title']); ?>
            </span>
        </p>
        <p>本文<br>
            <textarea name="body" cols="50" rows="5"><?php echo $post['body'] ?>
            </textarea>
        </p>
        <p>
            <span style="color: red;">
                <?php echo h($errors['body']); ?>
            </span>
        </p>
        <p>
            <input type="submit" value="編集する"></input>
        </p>
    </form>
</body>
</html>