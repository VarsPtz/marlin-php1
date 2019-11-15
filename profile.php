<?php
    session_start();
    if (empty($_SESSION['auth_user']) && empty($_COOKIE['user_email'])) {
        header('Location: /login.php');
    }
?>

<!DOCTYPE html>
<html lang="ru">
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

                    <ul class="navbar-nav ml-auto" <?php //hide if user hasn't auth
                    if (empty($_SESSION['auth_user']) && empty($_COOKIE['user_name'])) {
                        echo 'style="display: none;"';
                    }
                    ?> >
                        <li class="navbar-nav_first_item">
                            <?php
                            if (!empty($_SESSION['auth_user'])) {
                                echo $_SESSION['auth_user']['name']." <span>▼</span>";
                            } elseif (!empty($_COOKIE['user_name'])) {
                                echo $_COOKIE['user_name']." <span>▼</span>";
                            }
                            ?>
                            <ul class="submenu item-hide">
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
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                          <?php if (isset($_SESSION['flash']['change_user']) && $_SESSION['flash']['change_user'] === 1) { ?>
                          <div class="alert alert-success" role="alert">
                            Профиль успешно обновлен
                          </div>
                          <?php unset($_SESSION['flash']['change_user']); } ?>

                            <form action="/edit_user.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control <?php if (isset($_SESSION['error']['name'])) {echo 'is-invalid';} ?> @enderror" name="name" id="exampleFormControlInput1" value="<?php
                                            if (!empty($_SESSION['auth_user'])) {
                                                echo $_SESSION['auth_user']['name'];
                                            } elseif (!empty($_COOKIE['user_name'])) {
                                                echo $_COOKIE['user_name'];
                                            }
                                            ?>">
                                            <?php if (isset($_SESSION['error']['name'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['name']?></strong>
                                                </span>
                                            <?php } ?>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" class="form-control <?php if (isset($_SESSION['error']['name'])) {echo 'is-invalid';} ?> @enderror" name="email" id="exampleFormControlInput1" value="<?php
                                            if (!empty($_SESSION['auth_user'])) {
                                                echo $_SESSION['auth_user']['email'];
                                            } elseif (!empty($_COOKIE['user_name'])) {
                                                echo $_COOKIE['user_email'];
                                            }
                                            ?>">
                                            <?php if (isset($_SESSION['error']['email'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['email']?></strong>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control <?php if (isset($_SESSION['error']['image_type']) || isset($_SESSION['error']['image_size'])) {echo 'is-invalid';} ?> @enderror" name="image" id="exampleFormControlInput1">
                                            <?php if (!empty($_SESSION['error']['image_type'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['image_type']?></strong>
                                                </span>
                                            <?php } ?>
                                            <?php if (!empty($_SESSION['error']['image_size'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['image_size']?></strong>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="img/<?php
                                        if (!empty($_SESSION['auth_user'])) {
                                            echo $_SESSION['auth_user']['image'];
                                        } elseif (!empty($_COOKIE['user_name'])) {
                                            echo $_COOKIE['user_image'];
                                        }
                                        ?>" alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning" name="btn-user-edit">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                          <?php if (isset($_SESSION['flash']['change_password']) && $_SESSION['flash']['change_password'] === 1) { ?>
                            <div class="alert alert-success" role="alert">
                                Пароль успешно обновлен
                            </div>
                          <?php unset($_SESSION['flash']['change_password']); } ?>

                            <form action="/edit_password.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" name="password_current" class="form-control <?php if (!empty($_SESSION['error']['password_current'])) {echo 'is-invalid';} ?> @enderror" id="exampleFormControlInput1">
                                            <?php if (!empty($_SESSION['error']['password_current'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['password_current']?></strong>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" name="password" class="form-control <?php if (!empty($_SESSION['error']['password'])) {echo 'is-invalid';} ?> @enderror" id="exampleFormControlInput1">
                                            <?php if (!empty($_SESSION['error']['password'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['password']?></strong>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control <?php if (!empty($_SESSION['error']['password_confirmation'])) {echo 'is-invalid';} ?> @enderror" id="exampleFormControlInput1">
                                            <?php if (!empty($_SESSION['error']['password_confirmation'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['password_confirmation']?></strong>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <button class="btn btn-success" name="btn-password-edit">Submit</button>
                                    </div>
                                </div>
                            </form>
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
var_dump($_POST);
echo "</pre>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<pre>";
var_dump($_COOKIE);
echo "</pre>";
?>
