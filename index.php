<?php

require_once 'src/connection.php';
$db->query('USE '. DB_NAME);

$message = '';

function validate(string $string)
{
    $string = trim($string);
    $string = strip_tags($string);
    if (strlen($string) < 3) {
        return false;
    }
    return $string;
}

if (isset($_GET['search'])) {
    $search = validate($_GET['search']);
    if ($search === false) {
        $message = 'Search field must be at least 3 characters.';
    }
    else {
        $stmt = $db->prepare('SELECT * FROM posts JOIN comments ON posts.id = comments.postId WHERE comments.body LIKE :search');
        $stmt->execute(['search' => "%$search%"]);
        $posts = $stmt->fetchAll();
        unset($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts and comments</title>
</head>
<body style="font-family: sans-serif;">
    <div style="max-width: 1280px; margin: 0 auto;">
        <h1 style="line-height: 0.3;">Posts and comments</h1>
        <form method="GET" action="" style="margin-bottom: 5px;">
            <input type="search" name="search" placeholder="Search" style="min-width: 300px;" value="<?php echo $search ?>"/>
            <button type="submit">Search</button>
        </form>
        <?php if (isset($message)) : ?>
            <label style="font-size: small; color:lightcoral;">
                <?php echo $message ?>
            </label>
        <?php endif; ?>
        <div>
            <?php if (isset($posts) && count($posts)) : ?>
                <table cellpadding="0" cellspacing="0" style="border-collapse: collapse; border: 1px solid slategray">
                    <tbody>
                        <tr style="background-color:slategray; color:white;">
                            <th style="padding: 2px;">Post Title</th>
                            <th style="padding: 2px;">Comment Body</th>
                        </tr>
                        <?php foreach ($posts as $post) : ?>
                        <tr style="border-bottom: 1px solid slategray; font-size: small;">
                            <td style="padding: 5px;">
                                <?php echo $post['title'] ?>
                            </td>
                            <td style="padding: 5px;">
                                <?php echo $post['body'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No comments</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>