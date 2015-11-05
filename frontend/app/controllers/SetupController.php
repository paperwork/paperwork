<?php
class SetupController extends BaseController {
    
    public function showInstallerPage() {
        if (!File::exists('css/themes/paperwork-v1.min.css') 
            || !File::exists('js/jquery.min.js') 
            || !File::exists('js/libraries.min.js') 
            || !File::exists('css/freqselector.min.css') 
            || !File::exists('css/typeahead.min.css') 
            || !File::exists('css/libs.css') 
            || !File::exists('js/angular.min.js') 
            || !File::exists('js/paperwork.min.js') 
            || !File::exists('js/paperwork-native.min.js') 
            || !File::exists('js/tagsinput.min.js')) {
            $assets_missing = true;
        }else{
            $assets_missing = false;
        }
        return View::make("setup/installer", array('assets_missing' => $assets_missing));
    }
    
    public function finishSetup() {
        File::delete(storage_path()."/setup");
        if(!File::exists(storage_path()."/setup")) {
            $response = PaperworkHelpers::STATUS_SUCCESS;
        }else{
            $response = PaperworkHelpers::STATUS_ERROR;
        }
        return PaperworkHelpers::apiResponse($response, array());
    }
    
    public function setupDatabase() {
        // Create credentials string
        $string = Input::get("driver") . ", " . Input::get("server") . ", " . Input::get("port") . ", " . Input::get("username") . ", " . Input::get("password") . ", " . Input::get("database");
        // Create file to hold info
        // Save File
        File::put(storage_path()."/db_settings", $string);
        // Open connection
        // Check if any errors occurred
        // If true, send error response 
        // If false, send success response 
        if(Input::get("driver") !== "sqlite") {
            if(DB::connection()->getDatabaseName()) {
                $response = PaperworkHelpers::STATUS_SUCCESS;
                define('STDIN',fopen("php://stdin","r"));
                Artisan::call("migrate", ['--quiet' => true, '--force' => true]);
            }else{
                $response = PaperworkHelpers::STATUS_NOTFOUND;
                unlink(storage_path()."/db_settings");
            }
        }else{
            $response = PaperworkHelpers::STATUS_SUCCESS;
        }
        
        return PaperworkHelpers::apiResponse($response, array());
    }
    
    public function configurate() {
        //Create settings string 
        $string = "";
        if(Input::get("debug") !== Config::get("app.debug")) {
            $string .= "debug: " . Input::get("debug") . "\r\n";
        }
        if(Input::get("registration") !== Config::get("paperwork.registration")) {
            $string .= "registration: " . Input::get("registration") . "\r\n";
        }
        if(Input::get("forgot_password") !== Config::get("paperwork.forgot_password")) {
            $string .= "forgot_password: " . Input::get("forgot_password") . "\r\n";
        }
        if(Input::get("showIssueReportingLink") !== Config::get("paperwork.showIssueReportingLink")) {
            $string .= "showIssueReportingLink: " . Input::get("showIssueReportingLink") . "\r\n";
        }
        File::put(storage_path()."/paperwork_settings", $string);
        
        if(file::exists(storage_path()."/paperwork_settings")) {
            $response = PaperworkHelpers::STATUS_SUCCESS;
        }else{
            $response = PaperworkHelpers::STATUS_NOTFOUND;
        }
        
        return PaperworkHelpers::apiResponse($response, array());
    }
    
    public function update() {
        define('STDIN',fopen("php://stdin","r"));
        Artisan::call("paperwork:update", ['--quiet' => true]);
        Cache::forget('paperwork.commitInfo');
        return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
    }
    
}