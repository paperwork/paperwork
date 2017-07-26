<?php

    if(!file_exists("../../storage/config/database.json")) {

        try {
            if($_POST['driver'] === "mysql") {
                $connection = new PDO("mysql:host=".$_POST['host'].";port=".$_POST['port'].";dbname=".$_POST['database'], $_POST['username'], $_POST['password']);
            }else if($_POST['driver'] === 'pgsql') {
                $connection = new PDO("pgsql:host=".$_POST['host'].";port=".$_POST['port'].";dbname=".$_POST['database'].";user=".$_POST['username'].";password=".$_POST['password']);
            }else if($_POST['driver'] === 'sqlite') {
                $connection = new PDO("sqlite::memory:");
            }else if($_POST['driver'] === 'sqlsrv') {
                $connection = new PDO("sqlsrv:Server=".$_POST['host'].",".$_POST['port'].";Database=".$_POST['database'], $_POST['username'], $_POST['password']);
            }

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $string = array(
                'driver' => $_POST['driver'],
                'database' => $_POST['database'],
                'host' => $_POST['host'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'port' => $_POST['port']
            );

            file_put_contents("../../storage/config/database.json", json_encode($string));

            try{
                $test = $connection->query("SELECT * FROM migrations LIMIT 1");
            }catch(Exception $error) {
                exec("cd ../../ && php artisan migrate --force");
            }

            header("Location: ".$_SERVER['HTTP_REFERRER'], true, 200);

        }catch(PDOException $e) {
            header("Location: ".$_SERVER['HTTP_REFERRER'], true, 404);
        }

    }
