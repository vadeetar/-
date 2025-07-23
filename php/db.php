<?php
// Подключение к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname=site;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);