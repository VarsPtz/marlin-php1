<?php

    function security_clean_data($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function check_empty($data) {
        return empty($data);
    }

    function check_characters($data) {
        return (preg_match('/^[a-zA-Zа-яА-ЯёЁ]++$/u', $data) === 0);
    }

    function validate_email($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) === false);
    }

    function check_name($name) {
        if (check_empty($name)) {
            $_SESSION['error']['name'] = "Вы не ввели имя пользователя";
            return false;
        } elseif (check_characters($name)) {
            $_SESSION['error']['name'] = "Для имени пользователя можно использовать только буквы";
            return false;
        } else {
            if (isset($_SESSION['error']['name'])) {
                unset($_SESSION['error']['name']);
            }
            $_SESSION['name'] = $name;
            return true;
        }
    }

    function check_comment($comment) {
        if (check_empty($comment)) {
            $_SESSION['error']['comment'] = "Вы ничего не написали в комментарии.";
            return false;
        } else {
            if (isset($_SESSION['error']['comment'])) {
                unset($_SESSION['error']['comment']);
            }
            return true;
        }
    }

    function check_email($email, $result) {
        if (check_empty($email)) {
            $_SESSION['error']['email'] = "Вы не ввели e-mail.";
            return false;
        } elseif (validate_email($email)) {
            $_SESSION['error']['email'] = "Вы ввели не корректный почтовый адрес";
            return false;
        } elseif ($result) {
            $_SESSION['error']['email'] = "Почтовый адрес уже зарегистрирован в базе данных.";
            return false;
        } else {
            if (isset($_SESSION['error']['email'])) {
                unset($_SESSION['error']['email']);
            }
            $_SESSION['email'] = $email;
            return true;
        }
    }

    function check_password($password, $password_confirmation) {
        if (check_empty($password)) {
            $_SESSION['error']['password'] = "Вы не ввели пароль.";
            return false;
        } elseif (strlen($password) < 6) {
            $_SESSION['error']['password'] = "Длина пароля меньше шести символов.";
            return false;
        } else {
            unset($_SESSION['error']['password']);
            $_SESSION['password'] = $password;
        }

        //$_SESSION['password'] = $password;

        if (check_empty($password_confirmation)) {
            $_SESSION['error']['password_confirmation'] = "Вы не ввели подтверждение пароля.";
            return false;
        } elseif ($password !== $password_confirmation) {
            $_SESSION['error']['password_confirmation'] = "Пароли не совпадают.";
            return false;
        } else {
            if (isset($_SESSION['error']['password']) && isset($_SESSION['error']['password_confirmation'])) {
                unset($_SESSION['error']['password']);
                unset($_SESSION['error']['password_confirmation']);
            }
            return true;
        }
    }

?>
