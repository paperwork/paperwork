<?php

use \Paperwork\UserRegistrator;
//use \Symfony\Component\Process\Process;

class SetupController extends BaseController {

    //public $process = "";

    public function installDatabase() {
        /**
         * This is being handled by check_database_credentials.php
         *
         * define('STDIN', fopen("php://stdin", "r"));
         * Artisan::call('migrate', ['--force' => true]);
         * return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
         */
    }

    public function canWriteSetupFiles() {
        return File::isWritable("../app/storage/config/");
    }

    public function setConfiguration() {
        if($this->canWriteSetupFiles()) {
            File::put("../app/storage/config/paperwork.json", json_encode(Input::all()));
            if(File::exists("../app/storage/config/paperwork.json")) {
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
            }else{
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, 'an error');
            }
        }else{
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, 'not enough file permissions');
        }
    }

    public function finishSetup() {
        if($this->canWriteSetupFiles()) {
            File::put("../app/storage/config/setup", 8);
        }else{
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, 'not enough file permissions');
        }
    }

    public function checkDatabaseStatus() {
        /**
         * TODO - This is not working
         *
         * if($this->process->isRunning()) {
         *   $response = PaperworkHelpers::STATUS_SUCCESS;
         * }else{
         *   $response = PaperworkHelpers::STATUS_ERROR;
         * }
         * return PaperworkHelpers::apiResponse($response, array());
         */
    }

}
