<?php
//Авторизация
    header('Content-Type: application/json');

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!str_contains($email, '@') && !str_contains($email, '.')){
        echo "Please enter a valid email address!";
        exit;
    }

    if(strlen($password) < 6){
        echo "Password must be at least 6 characters!";
        exit;
    }
 
    require "db.php";
        
    $sql = 'SELECT password_hash FROM users WHERE email = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if($query->rowCount() == 0 || !password_verify($password, $user['password_hash'])){
        echo "Invalid email or password. Please try again!";
        exit;
    }
    else{
        //пользователь есть
        //установка куки (3 минуты для теста)
        setcookie('auth', $email, time() + 180, "/");
        header('Location: /site');
    }
