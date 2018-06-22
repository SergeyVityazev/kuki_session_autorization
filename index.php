<?php
require_once __DIR__ . '/function.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    if (login($login, $password)) {
        $_SESSION['login'] = $login;
        $_SESSION['Autorized'] = true;
    }
    if ($login!="" and $password=="")
    {
        $_SESSION['Guest']=true;
        $_SESSION['NameGuest']=$login;
    }
    if ($_SESSION['Guest']==true)
        header('Location:list.php');
    if (login($login, $password)) {
        $_SESSION['Autorized']=true;
        header('Location:list.php');
    } else {
        echo "Логин или пароль не верные. Авторизуйтесь или войдите как гость";
        $errors[] = 'Логин или пароль неверные';
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Авторизация</title>
</head>
<body>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <div class="form-wrap">
                    <h1>Авторизация</h1>
                    <form method="POST" id="login-form" action="">
                        <div class="form-group">
                            <label for="lg" class="sr-only">Логин</label>
                            <input type="text" placeholder="Логин" name="login" id="lg" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Пароль</label>
                            <input type="password"  placeholder="Пароль" name="password" id="key" class="form-control">
                        </div>
                        <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Войти">
                    </form>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>


