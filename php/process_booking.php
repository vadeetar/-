<?php
//Бронирование стола

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $count = trim($_POST['people']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);

    if(strlen($name) < 3){
        echo "Please enter a valid username (minimum 3 characters)!";
        exit;
    }

    if(!str_contains($email, '@') && !str_contains($email, '.')){
        echo "Please enter a valid email address!";
        exit;
    }

    if(strlen($phone) < 11){
        echo "Please enter a valid phone number!";
        exit;
    }

    if(strlen($count) < 1){
        echo "Please select the number of guests!";
        exit;
    }

    if(empty($date)){
        echo "Please select a reservation date!";
        exit;
    }

    if(empty($time)){
        echo "Please select a reservation time!";
        exit;
    }
    
    //бронь только после авторизации
    if(isset($_COOKIE['auth'])){
        require "db.php";
        
        $sql = 'INSERT into booking(user_id, guest_name, guest_email, guest_phone, guests_count, reservation_date, reservation_time) values((select id from users where email = ?), ?, ?, ?, ?, ?, ?)';
        $query = $pdo->prepare($sql);
        $query->execute([$_COOKIE['auth'], $name, $email, $phone, $count, $date, $time]);
        header('Location: /site');
    }
    else{
        echo "To book a table, you need to log in!";
        exit;
    }