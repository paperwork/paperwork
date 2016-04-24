<?php

use \Paperwork\UserRegistrator;
//use \Symfony\Component\Process\Process;

class SetupController extends BaseController {
    
    //public $process = "";
    
    public function checkDatabaseCredentials() {
        File::put(storage_path() . "/config/database.json", json_encode(Input::all()));
        try {
            DB::reconnect();
            //$this->process = new Process('php artisan migrate');
            //$this->process->start();
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
        }catch(\PDOException $e) {
            File::delete(storage_path() . "/config/database.json");
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, Input::all());
        }
    }
    
    public function installDatabase() {
        define('STDIN', fopen("php://stdin", "r"));
        Artisan::call('migrate', ['--force' => true]);
        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
    }
    
    public function setConfiguration() {
        File::put(storage_path() . "/config/paperwork.json", json_encode(Input::all()));
        if(File::exists(storage_path() . "/config/paperwork.json")) {
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
        }else{
            return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, Input::all());
        }
    }
    
    public function finishSetup() {
        File::put(storage_path() . "/config/setup", 8);
    }
    
    public function checkDatabaseStatus() {
        /*if($this->process->isRunning()) {
            $response = PaperworkHelpers::STATUS_SUCCESS;
        }else{
            $response = PaperworkHelpers::STATUS_ERROR;
        }
        return PaperworkHelpers::apiResponse($response, array());*/
    }
    
}