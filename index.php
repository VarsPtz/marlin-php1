<?php
    session_start();
    require_once 'db.php';
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
    </style>
</head>
<body>    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.html">Register</a>
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
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">

                              <?php if (isset($_SESSION['flash']['add_comment']) && $_SESSION['flash']['add_comment'] === 1) { ?>
                                  <div class="alert alert-success" role="alert">
                                      Комментарий успешно добавлен
                                  </div>
                              <?php unset($_SESSION['flash']['add_comment']); } ?>


                               <?php foreach ($array_comments as $comment) { ?>
                                <div class="media">
<!--                                  <img src="--><?php //echo $comment['user_img'];
//                                            ?><!--" class="mr-3" alt="..." width="64" height="64">-->
                                  <div class="media-body">
                                    <h5 class="mt-0">
                                     <?=$comment['name'];?>
                                    </h5>
                                    <span><small><?php echo date('d/m/Y', strtotime($comment['date'])); ?></small></span>
                                    <p>
                                       <?=$comment['comment']; ?>
                                    </p>
                                  </div>
                                </div>
                               <?php } ?>

                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="/add_comment.php" method="post">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="name" class="form-control" id="exampleFormControlTextarea1" />
                                    <?php if (!empty($_SESSION['error']['name'])) {
                                        echo '<p class="error-message">'.$_SESSION['error']['name'].'</p>';
                                    }; ?>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <?php if (!empty($_SESSION['error']['comment'])) {
                                      echo '<p class="error-message">'.$_SESSION['error']['comment'].'</p>';
                                    }; ?>
                                  </div>
                                  <button name="btn-add-comment" type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

//<?php
//    echo '<pre>';
//    var_dump($_SESSION['error']);
//    echo '</pre>';
//    echo '<pre>';
//    var_dump($_POST);
//    echo '</pre>';
//    echo '<pre>';
//    var_dump($array_comments);
//    echo '</pre>';
//?>