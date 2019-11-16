<?php
session_start();
require_once 'db.php';
require_once 'validate.php';

if (empty($_SESSION['auth_user']['user_id']) && empty($_COOKIE['user_id'])) {

    if (!empty($_SESSION['auth_user']['user_id'])) {
        $user_id = $_SESSION['auth_user']['user_id'];
    } elseif (!empty($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }

    //Prepare data to find id in data base.
    $sql_id_in_db = "SELECT * FROM `users` WHERE user_id = :user_id";
    $sql_id_in_db_prepared = $pdo->prepare($sql_id_in_db);
    $find_id = [':user_id' => $user_id];
    $sql_id_in_db_prepared->execute($find_id);
    $find_id_result = $sql_id_in_db_prepared->fetch();

    if ($find_id_result['role'] != 'admin') {
        header('Location: /login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
    <style>
        .error-message {
            color: #ff0000;
        }
        .flash-prevention {
            border-radius: 4px;
            background-color: #AFEEEE;
            padding: 10px 20px;
        }
        .flash-prevention p {
            margin-bottom: 0px;
        }
        .submenu {
            list-style-type: none;
            padding: 5px 20px;
            position: absolute;
            z-index: 100;
            background-color: white;
            border: 1px solid gray;
            border-radius: 5px;
            left: -30px;
        }
        .submenu:hover {
            display: block;
        }
        .navbar-nav_first_item {
            position: relative;
            padding: 10px 15px;
        }
        .navbar-nav_first_item span {
            font-size: 10px;
        }
        .item-hide {
            display: none;
        }
        .form-control[type="file"] {
            padding: 4px;
        }
        form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="navbar-nav_first_item">
                            <?php
                            if (!empty($_SESSION['auth_user'])) {
                                echo $_SESSION['auth_user']['name']." <span>▼</span>";
                            } elseif (!empty($_COOKIE['user_name'])) {
                                echo $_COOKIE['user_name']." <span>▼</span>";
                            }
                            ?>
                            <ul class="submenu item-hide">
                                <li><a href="/profile.php">Профиль</a></li>
                                <li><a href="/end.php">Выход</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($array_comments as $comment) { ?>
                                        <tr>
                                            <td>
                                                <img src="img/<?=$comment['image']?>" alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?=$comment['name'];?></td>
                                            <td><?php echo date('d/m/Y', strtotime($comment['date'])); ?></td>
                                            <td> <?=$comment['comment']; ?></td>
                                            <td>
                                                <?php if ($comment['show'] == 0) { ?>
                                                    <form action="/resolve_comment.php" method="POST">
                                                        <button class="btn btn-success" type="submit" name="comment_id" value="<?=$comment['id']?>">Разрешить</button>
                                                    </form>
<!--                                                    <a href="/resolve_comment.php" class="btn btn-success">Разрешить</a>-->
                                                <?php } elseif ($comment['show'] == 1) { ?>
                                                    <form action="/forbid_comment.php" method="POST">
                                                        <button class="btn btn-warning" type="submit" name="comment_id" value="<?=$comment['id']?>">Запретить</button>
                                                    </form>
<!--                                                    <a href="/forbid_comment.php" class="btn btn-warning">Запретить</a>-->
                                                <?php } ?>
                                                <form action="/delete_comment.php" method="POST">
                                                    <button class="btn btn-danger" onclick="return confirm('are you sure?')" type="submit" name="comment_id" value="<?=$comment['id']?>">Удалить</button>
                                                </form>
<!--                                                <a href="/delete_comment.php" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>-->
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>

<?php
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<pre>";
var_dump($_COOKIE);
echo "</pre>";
?>