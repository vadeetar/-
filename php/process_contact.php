<?php
header('Content-Type: application/json');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if(strlen($name) < 3){
    echo "Please enter a valid username (minimum 3 characters)!";
    exit;
}

if(!str_contains($email, '@') && !str_contains($email, '.')){
    echo "Please enter a valid email address!";
    exit;
}

if(strlen($message) < 10){
    echo "Please enter your message (minimum 10 characters)!";
    exit;
}

require "db.php";

// Подготовка и выполнение запроса
$sql = 'INSERT into contacts(name, email, message) VALUE(?, ?, ?)';
$query = $pdo->prepare($sql);
$query->execute([$name, $email, $message]);

header('Location: /site');
?>