<?php
    //Регистрация
    //проверка на существование аккаунта
    header('Content-Type: application/json');

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(strlen($name) < 3){
        echo "Please enter a valid username (minimum 3 characters)!";
        exit;
    }

    if(!str_contains($email, '@') && !str_contains($email, '.')){
        echo "Please enter a valid email address!";
        exit;
    }

    if(strlen($password) < 6){
        echo "Password must be at least 6 characters!";
        exit;
    }

    if($password != $confirmPassword){
        echo "Passwords do not match!";
        exit;
    }

    require "db.php";
        
    $sql = 'SELECT email FROM users WHERE email = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$email]);

    if($query->rowCount() != 0){
        echo "This email is already registered!";
    }
    else {
        //хэширование пароля
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        require "db.php";
        
        $sql = 'INSERT INTO users(name, email, password_hash) VALUES (?, ?, ?)';
        $query = $pdo->prepare($sql);
        $query->execute([$name, $email, $passwordHash]);
        
        header('Location: /site');
    }