<?php

    if(!file_exists("../../app/storage/config/setup")) {
        fopen("../../app/storage/config/setup", "x");
    }
    
    file_put_contents("../../app/storage/config/setup", $_GET['step']);