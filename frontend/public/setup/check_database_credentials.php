<?php

    if(!file_exists("../../app/storage/config/database1.json")) {
        
        try {
            if($_GET['driver'] === "mysql") {
                $connection = new PDO("mysql:host=".$_GET['host'].";port=".$_GET['port'].";dbname=".$_GET['database'], $_GET['username'], $_GET['password']);
            }else if($_GET['driver'] === 'pgsql') {
                $connection = new PDO("pgsql:host=".$_GET['host'].";port=".$_GET['port'].";dbname=".$_GET['database'].";user=".$_GET['username'].";password=".$_GET['password']);
            }else if($_GET['driver'] === 'sqlite') {
                $connection = new PDO("sqlite::memory:");
            }else if($_GET['driver'] === 'sqlsrv') {
                $connection = new PDO("sqlsrv:Server=".$_GET['host'].",".$_GET['port'].";Database=".$_GET['database'], $_GET['username'], $_GET['password']);
            }
            
            $string = array(
                'driver' => $_POST['driver'],
                'database' => $_POST['database'],
                'host' => $_POST['host'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'port' => $_POST['port']
            );
            
            file_put_contents("../../app/storage/config/database1.json", json_encode($string));
            
            header("Location: ".$_SERVER['HTTP_REFERRER'], true, 200);
            
        }catch(PDOException $e) {
            header("Location: ".$_SERVER['HTTP_REFERRER'], true, 404);
        }
        
    }