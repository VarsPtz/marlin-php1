<?php
    session_start();
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
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action="/add_user.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') <?php if (isset($_SESSION['error']['name'])) {echo 'is-invalid';} ?> @enderror" name="name" autofocus value="<?php if (isset($_SESSION['name'])) {echo $_SESSION['name'];}?>">

                                                <?php if (isset($_SESSION['error']['name'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['name']?></strong>
                                                </span>
                                                <?php } ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">

                                            <input id="email" type="email" class="form-control @error('name') <?php if (isset($_SESSION['error']['email'])) {echo 'is-invalid';} ?> @enderror" name="email" value="<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];}?>">

                                            <?php if (isset($_SESSION['error']['email'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['email']?></strong>
                                                </span>
                                            <?php } ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">

                                            <input id="password" type="password" class="form-control @error('name') <?php if (isset($_SESSION['error']['password'])) {echo 'is-invalid';} ?> @enderror" name="password"  autocomplete="new-password" value="<?php if (isset($_SESSION['password'])) {echo $_SESSION['password'];}?>">

                                            <?php if (isset($_SESSION['error']['password'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['password']?></strong>
                                                </span>
                                            <?php } ?>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-6">

                                            <input id="password-confirm" type="password" class="form-control @error('name') <?php if (isset($_SESSION['error']['password_confirmation'])) {echo 'is-invalid';} ?> @enderror" name="password_confirmation"  autocomplete="new-password">

                                            <?php if (isset($_SESSION['error']['password_confirmation'])) { ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['error']['password_confirmation']?></strong>
                                                </span>
                                            <?php } ?>

                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary" name="btn-add-user">
                                                Register
                                            </button>
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
</body>
</html>


<?php
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
echo "<pre>";
var_dump($_POST);
echo "</pre>";
?>