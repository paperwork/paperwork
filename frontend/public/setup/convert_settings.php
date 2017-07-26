<?php

    if(file_exists("../../storage/db_settings")) {
        $db_settings = file_get_contents("../../storage/db_settings");
        $db_settings = explode(", ", $db_settings);

        $configuration = array(
            "host" => $db_settings[1],
            "port" => $db_settings[2],
            "username" => $db_settings[3],
            "password" => $db_settings[4],
            "database" => $db_settings[5],
            "driver" => $db_settings[0],
        );

        file_put_contents("../../storage/config/database.json", json_encode($configuration));
    }
