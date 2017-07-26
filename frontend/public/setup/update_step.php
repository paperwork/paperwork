<?php

    if(!file_exists("../../storage/config/setup")) {
        fopen("../../storage/config/setup", "x");
    }

    file_put_contents("../../storage/config/setup", $_GET['step']);
