 <?php
    function getCurrentSetupStep () {
        $setup_file_contents = file_exists("../app/storage/config/setup") ? file_get_contents("../app/storage/config/setup") : 0;
        // Check if setup file is present
        if ($setup_file_contents <= 1) {
            return 1;
        }
        // Check if setup should have created database.json
        if ($setup_file_contents > 3 && !file_exists("../app/storage/config/database.json")) {
            return 3;
        }
        // Check if setup should have created paperwork.json
        if ($setup_file_contents > 4 && !file_exists("../app/storage/config/paperwork.json")) {
            return 4;
        }
        // Skip step 5 of the setup wizard (not implemented yet)
        if ($setup_file_contents == 5) {
            $setup_file_contents++;
        }
        // Check if setup should be skipped
        if ($setup_file_contents >= 7) {
            header("Location: /");
        }
        // Return the file contents
        return $setup_file_contents;
    }
    $currentStep = getCurrentSetupStep();
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Paperwork Setup Wizard</title>
        <style>
            html, body {
                height: 100%;
            }
            body {
                position: relative;
                margin: 0;
                padding: 0;
            }
            div {
                width: 100%;
                float: left;
            }
            p {
                margin-bottom: 0;
            }
            .progress_bar {
                width: 100%;
                height: 10px;
                border-bottom: 1px solid #E7E7E7;
            }
            .progres {
                background-color: #03A9F4;
                position: absolute;
                height: 10px;
                width: 0%;
            }
            .button_switch {
                width: 100%;
                margin-bottom: 0 !important;
            }
            .navbar {
                margin-bottom: 0 !important;
            }
            .step {
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                overflow: auto;
                display: none;
            }
            .step_active {
                display: block;
            }
            .button_switcher {
                min-height: 35px;
            }
            .button_switch_row {
                margin-top: 7.5px;
                margin-bottom: 7.5px;
            }
            .step_counter {
                line-height: 35px;
            }
            .paperwork-logo {
                line-height: 50px;
            }
            .wizard-placeholder {
                position: relative;
                min-height: 100%;
                min-height: calc(100% - 124px);
                padding-bottom: 10px;
            }
            .credentials_alert{
                padding: 10px 10px 0 10px;
                margin-bottom: 5px;
            }
            .switch {
                height: 25px;
                background-color: #CCCCCC;
                border-radius: 15px;
                width: 50px;
                position: relative;
            }
            .switch_round {
                height: 25px;
                border-radius: 15px;
                background-color: #FFFFFF;
                position: absolute;
                width: 50%;
                border: 1px solid #ADADAD;
            }
            .switch_active {
                background-color: #286090;
            }
            .configuration_setting {
                padding: 10px 0;
            }
        </style>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    </head>
    <body>
        <?php
            if(file_exists("../app/storage/db_settings")) {
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="convert_settings_dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Database Settings Already Found</h4>
                </div>
                <div class="modal-body">
                    <div id="convert_settings_error" class="credentials_alert bg-danger" style="display: none">
                        <p>Settings conversion has failed. Please try again. </p>
                    </div>
                    <p>It seems that you have a db_settings in your server that is currently being used by Paperwork. Do you want to convert your current settings to be used now?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="convert_settings">Convert Settings</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="row navbar-header text-center">
                    <a class="paperwork-logo transition-effect" href="/">
                        <img src="images/navbar-logo.png"> Paperwork
                    </a>
                </div>
            </div>
        </div>
        <div class="progress_bar">
            <span id="progress" class="progres" style="width: <?php echo floor((($currentStep - 1) / 7) * 100) ?>%"></span>
        </div>
        <div class="wizard-placeholder">
            <div class="col-md-12 step <?php if($currentStep == 1) { ?>step_active<?php } ?>" id="step1">
                <h1>Welcome</h1>
                <?php
                    if(!is_writable("../app/storage/config")) {
                ?>
                <p class="text-danger">
                    <strong>
                        The Setup Wizard needs the web server to have enough permissions to write files in your frontend/app/storage/config
                        folder to work correctly. Please make sure this is possible before going to the next steps. Otherwise, some
                        functionality may not work well.
                    </strong>
                </p>
                <?php
                    }
                ?>
                <p>
                    Through this wizard, you will be able to install and configure your Paperwork instance. At the end of
                    this process, you will be able to use Paperwork as your note-taking application. This installer will
                    take care of the following things:
                </p>
                <ul>
                    <li>check that all assets and dependencies are in place, </li>
                    <li>configure the database needed to save Paperwork's data,</li>
                    <li>configure Paperwork's settings,</li>
                    <li>install the Paperwork database,</li>
                    <li>register the first user account on your Paperwork instance. </li>
                </ul>
                <p>
                    Paperwork is licensed under the MIT license.
                </p>
                <p>
                    <strong>
                        Please note that any previous install's settings may be overwritten during installation. If you
                        wish to keep anything, please backup before continuing through this process.
                    </strong>
                </p>
                <p>
                    If you want to skip using this wizard, please folow the instructions availabe
                    <a href="https://github.com/twostairs/paperwork/wiki/Installing-and-configuring-Paperwork-without-using-the-Setup-Wizard" target="_blank">here</a>.
                    Please avoid this since the wizard makes sure that all dependencies are
                    installed and settings are set correctly.
                </p>
            </div>
            <div class="col-md-12 step <?php if($currentStep == 2) { ?>step_active<?php } ?>" id="step2">
                <h1>Checking dependencies</h1>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Database</h3>
                    </div>
                    <?php
                        $installed_modules = 0;
                        if(extension_loaded("mysql")) {
                            $installed_modules++;
                        }
                        if(extension_loaded("pgsql")) {
                            $installed_modules++;
                        }
                        if(extension_loaded("sqlite3")) {
                            $installed_modules++;
                        }
                        if(extension_loaded("sqlsrv")) {
                            $installed_modules++;
                        }
                    ?>
                    <div class="panel-body <?php echo ($installed_modules > 0) ? 'bg-success' : 'bg-danger' ?>">
                        <p>
                            Paperwork needs a database to work. Currently, MySQL, Postgres, SQLite and SQL Server are supported. Here, you have the following
                            database systems installed and configured:
                            <br>
                            <?php
                                if(extension_loaded("mysql")) {
                            ?>
                            <p class="text-success">MySQL is installed and enabled. </p>
                            <?php
                                }
                                if(extension_loaded("pgsql")) {
                            ?>
                            <p class="text-success">Postgres is installed and enabled. </p>
                            <?php
                                }
                                if(extension_loaded("sqlite3")) {
                            ?>
                            <p class="text-success">SQLite is installed and enabled. </p>
                            <?php
                                }
                                if(extension_loaded("sqlsrv")) {
                            ?>
                            <p class="text-success">SQL Server is installed and enabled. </p>
                            <?php
                                }
                                if($installed_modules < 0) {
                            ?>
                            <p class="text-danger">None of the supported database systems are installed and enabled. </p>
                            <?php
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">PHP Dependencies</h3>
                    </div>
                    <?php
                        $composer_contents = file_get_contents("../composer.json");
                        $composer_contents = json_decode($composer_contents);
                        $composer_contents = $composer_contents->{"require"};

                        $installed_composer = file_get_contents("../composer.lock");
                        $installed_composer = json_decode($installed_composer);
                        $installed_composer = $installed_composer->{"packages"};

                        $installed_dependencies = [];

                        foreach ($composer_contents as $composer_key => $composer_value) {
                            $installed_dependencies[$composer_key] = false;
                            for ($j = 0; $j < count($installed_composer); $j++) {
                                if ($installed_composer[$j]->name === $composer_key) {
                                    $installed_dependencies[$composer_key] = true;
                                    $showErrorBackground = false;
                                    break;
                                }
                            }
                        }
                    ?>
                    <div class="panel-body <?php echo ($showErrorBackground) ? 'bg-danger' : 'bg-success' ?>">
                        <p>Paperwork needs a number of packages installable using Composer in order to work. </p>
                        <?php
                            foreach ($installed_dependencies as $package_name => $installed) {
                                if(!$installed_dependencies[$package_name]) {
                        ?>
                        <p class="text-danger">The package <?php echo $package_name; ?> is not fully installed. Did you run <code>composer install</code>?</p>
                        <?php
                                }else{
                        ?>
                        <p class="text-success">The package <?php echo $package_name; ?> is installed. </p>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">NPM Dependencies</h3>
                    </div>
                    <?php
                        $installed_npm_packages = [];
                        exec("cd ../app/storage/config/ && npm ls --json=true > npm-packages.json");

                        $npm_packages_installed = file_get_contents("../app/storage/config/npm-packages.json");
                        $npm_packages_installed = json_decode($npm_packages_installed);
                        $npm_packages_installed = $npm_packages_installed->{"dependencies"};

                        $npm_dependencies = file_get_contents("../package.json");
                        $npm_dependencies = json_decode($npm_dependencies);
                        $npm_dependencies = $npm_dependencies->{"devDependencies"};

                        $npm_missing = false;
                        foreach($npm_dependencies as $npm_dependency_name => $npm_dependency_value) {
                            foreach($npm_packages_installed as $npm_package_installed_name => $npm_package_installed_value) {
                                if($npm_dependency_name === $npm_package_installed_name) {
                                    $installed_npm_packages[$npm_dependency_name] = true;
                                }
                            }
                            if(!$installed_npm_packages[$npm_dependency_name]) {
                                $npm_missing = true;
                            }
                        }

                        unlink("../app/storage/config/npm-packages.json");

                    ?>
                    <div class="panel-body <?php echo ($npm_missing) ? 'bg-danger' : 'bg-success'; ?>">
                        <p>Paperwork needs a number of dependencies installed using NPM in order to function correctly. </p>
                        <?php
                            foreach($npm_dependencies as $npm_dependency_name => $npm_dependency_value) {
                                if($installed_npm_packages[$npm_dependency_name]) {
                        ?>
                        <p class="text-success">The package <?php echo $npm_dependency_name; ?> is installed. </p>
                        <?php
                                }else{
                        ?>
                        <p class="text-danger">The package <?php echo $npm_dependency_name; ?> is not fully installed. Did you run <code>npm install</code>?</p>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Asset Dependencies</h3>
                    </div>
                    <?php
                        if(!file_exists("css/bootstrap-theme.min.css") || !file_exists("css/themes/paperwork-v1.min.css") ||
                        !file_exists("css/libs.css") || !file_exists("css/freqselector.min.css") ||
                        !file_exists("css/typeahead.min.css") || !file_exists("js/bootstrap.min.js") ||
                        !file_exists("js/paperwork.min.js") || !file_exists("js/paperwork-native.min.js") ||
                        !file_exists("js/angular.min.js") || !file_exists("js/jquery.min.js") ||
                        !file_exists("js/tagsinput.min.js") || !file_exists("js/libraries.min.js") ||
                        !file_exists("js/ltie9compat.min.js") || !file_exists("js/ltie11compat.min.js")) {
                            $assets_missing = true;

                        }else{
                            $assets_missing = false;
                        }
                    ?>
                    <div class="panel-body <?php echo (!$assets_missing) ? 'bg-success' : 'bg-danger' ?>">
                        <?php
                            if($assets_missing) {
                        ?>
                        <p class="text-danger">You seem to be lacking some files required for Paperwork to work. Did you run <code>bower install</code> and <code>gulp</code>?</p>
                        <?php
                            }else{
                        ?>
                        <p class="text-success">All files needed seem to be in place. </p>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 step <?php if($currentStep == 3) { ?>step_active<?php } ?>" id="step3">
                <h1>Where should everything be saved?</h1>
                <p>Paperwork needs a database in order to save all its information. Please fill in the form below with the credentials to the database you want Paperwork to use. Make sure that the database already exists. </p>
                <div id="credentials_holder">
                    <div class="bg-success credentials_alert" id="credentials_correct" style="display: none">
                        <p>These credentials are correct. Install your Paperwork database by clicking 'Next' below. </p>
                    </div>
                    <div class="bg-danger credentials_alert" id="credentials_not_correct" style="display: none">
                        <p>A connection with the database could not be completed due to <span id="credentials_fail_reason"></span>. Please try again. </p>
                    </div>
                </div>
                <br>
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#" id="mysql">MySQL</a></li>
                    <li role="presentation"><a href="#" id="pgsql">PostgreSQL</a></li>
                    <li role="presentation"><a href="#" id="sqlite">SQLite</a></li>
                    <li role="presentation"><a href="#" id="sqlsrv">SQL Server</a></li>
                </ul>
                <br>
                <form id="database_info_form">
                    <div class="form-group" id="serverFieldElement">
                        <label for="serverField">Server</label>
                        <input type="text" name="host" id="serverField" placeholder="Server" class="form-control">
                    </div>
                    <div class="form-group" id="portFieldElement">
                        <label for="portField">Port</label>
                        <input type="number" name="port" id="portField" placeholder="Port" class="form-control">
                    </div>
                    <div class="form-group" id="usernameFieldElement">
                        <label for="usernameField">Username</label>
                        <input type="text" name="username" id="usernameField" placeholder="Username" class="form-control" required>
                    </div>
                    <div class="form-group" id="passwordFieldElement">
                        <label for="passwordField">Password</label>
                        <input type="password" name="password" id="passwordField" placeholder="Password" class="form-control" required>
                    </div>
                    <div class="form-group" id="databaseFieldElement">
                        <label for="databaseField">Database</label>
                        <input type="text" name="database" id="databaseField" placeholder="Database" class="form-control" required>
                    </div>
                    <input type="hidden" name="driver" id="dbms_choice" value="mysql">
                    <button type="button"  class="btn btn-primary col-md-12" id="check_credentials">Check Credentials</button>
                </form>
            </div>
            <div class="col-md-12 step <?php if($currentStep == 4) { ?>step_active<?php } ?>" id="step4">
                <h1>Customise your Paperwork</h1>
                <p>
                    Paperwork can be customised to fit your needs. Use the form below to configurate Paperwork according to your wishes. For more
                    information on what these setting mean and how to change them after installation, check out
                    <a href="https://github.com/twostairs/paperwork/wiki/Configuring-Paperwork" target="_blank">Configuring Paperwork</a>.
                </p>
                <br>
                <div class="bg-danger credentials_alert" id="config_not_set" style="display: none">
                    <p>Configuration has not been set correctly due to <span id="configuration_fail_reason"></span>. Please try again. </p>
                </div>
                <form id="config_form">
                    <div class="container-fluid">
                        <div class="row configuration_setting">
                            <div class="col-md-9">
                                Enable User Registration
                            </div>
                            <div class="col-md-3">
                                <!--
                                <div class="switch" onclick="toggleButton()" id="registration_switch">
                                    <span class="switch_round" id="registration_round"></span>
                                </div>
                                <input type="checkbox" name="registration" id="registration" checked class="hide">
                                -->
                                <select id="registration">
                                    <option value="true">Enabled</option>
                                    <option value="admin">Enabled only for administrators</option>
                                    <option value="false">Disabled</option>
                                </select>
                            </div>
                        </div>
                        <div class="row configuration_setting">
                            <div class="col-md-9">
                                Enable Forgot Password
                            </div>
                            <div class="col-md-3">
                                <div class="switch" onclick="toggleButton()" id="forgot_password_switch">
                                    <span class="switch_round" id="forgot_password_round"></span>
                                </div>
                                <input type="checkbox" name="forgot_password" id="forgot_password" checked class="hide">
                            </div>
                        </div>
                        <div class="row configuration_setting">
                            <div class="col-md-9">
                                Enable Automatic Language Detection
                            </div>
                            <div class="col-md-3">
                                <div class="switch" onclick="toggleButton()" id="language_detection_switch">
                                    <span class="switch_round" id="language_detection_round"></span>
                                </div>
                                <input type="checkbox" name="userAgentLanguage" id="language_detection" class="hide">
                            </div>
                        </div>
                        <div class="row configuration_setting">
                            <div class="col-md-9">
                                Show Issue Reporting Link
                            </div>
                            <div class="col-md-3">
                                <div class="switch" onclick="toggleButton()" id="user_reporting_link_switch">
                                    <span class="switch_round" id="user_reporting_link_round"></span>
                                </div>
                                <input type="checkbox" name="showIssueReportingLink" id="user_reporting_link" checked class="hide">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 step <?php if($currentStep == 5) { ?>step_active<?php } ?>" id="step5">
                <!--
                <h1>Wait a moment...</h1>
                <p>Your Paperwork is still not ready for showtime yet. Please wait a little bit while the last parts are finished. </p>
                -->
            </div>
            <div class="col-md-12 step <?php if($currentStep == 6) { ?>step_active<?php } ?>" id="step6">
                <h1>Register your first account</h1>
                <div class="bg-danger credentials_alert" id="registration_failed" style="display: none">
                    <p>These credentials do not appear to be correct. Please check them again. </p>
                </div>
                <p>It's time to register your first user account. This account will receive administrator rights immediately. Fill in this registration form with the credentials you want. </p>
                <div id="registration_form">
                    <p>Loading....</p>
                </div>
            </div>
            <div class="col-md-12 step <?php if($currentStep == 7) { ?>step_active<?php } ?>" id="step7">
                <h1>Paperwork is ready!</h1>
                <p>Paperwork has been fully installed and your first user account has been registered. All you have to do now is click on the button below. </p>
            </div>
        </div>
        <div class="navbar navbar-default button_switch">
            <div class="container-fluid button_switcher">
                <div class="row button_switch_row">
                    <div class="col-md-4 hidden-xs hidden-sm">
                        <button type="button" class="btn btn-default <?php if($currentStep == 1) { ?>disabled<?php } ?>" id="previous_btn">Previous</button>
                    </div>
                    <div class="hidden-lg hidden-md col-sm-4 col-xs-4">
                        <button type="button" class="btn btn-default col-sm-10 col-xs-10 <?php if($currentStep == 1) { ?>disabled<?php } ?>" id="previous_btn_mobile">Previous</button>
                    </div>
                    <div class="col-md-4 text-center step_counter col-xs-4 col-sm-4">Step <span id="step_counter_dynamic"><?php echo $currentStep; ?></span></div>
                    <div class="col-md-4 hidden-xs hidden-sm" id="next_btn_element">
                        <button type="button" class="btn btn-primary pull-right" id="next_btn">Next</button>
                    </div>
                    <div class="hidden-lg hidden-md col-sm-2 col-xs-2"></div>
                    <div class="hidden-lg hidden-md col-sm-4 col-xs-4">
                        <button type="button" class="btn btn-primary pull-right col-sm-10 col-xs-10" id="next_btn_mobile">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var currentStep = <?php echo $currentStep; ?>;
            var data = "";
            var credentialsCorrect = false;
            var previousBTN = $("#previous_btn, #previous_btn_mobile");
            var nextBTN = $("#next_btn, #next_btn_mobile");
            function disableButtons () {
                $("#previous_btn, #previous_btn_mobile, .step_counter").remove();
                $("#next_btn_element").removeClass("col-md-4").addClass("col-md-12 text-center");
                nextBTN.removeClass("pull-right");
                nextBTN.text("Go to Paperwork");
                nextBTN.off("click");
                nextBTN.on("click", function() {
                    window.location.reload();
                })
            }
            function stepChange (goToStep, currentlyActiveStep) {
                $("#step" + goToStep).addClass("step_active");
                $("#step_counter_dynamic").text(goToStep);
                currentStep = goToStep;
                var newProgress = parseInt(((currentStep - 1) / 7) * 100, 10) + "%";
                $("#progress").width(newProgress);
                $.get("setup/update_step.php?step=" + goToStep);
            }
            function previousStep (goToStep) {
                stepChange(goToStep, (goToStep + 1));
                $("#step" + (goToStep + 1)).slideDown();
                $("#step" + goToStep).show();
                $("#step" + (goToStep + 1)).removeClass("step_active");
                if(goToStep == 1) {
                    previousBTN.addClass("disabled");
                    previousBTN.attr("disabled", true);
                }
            }
            function nextStep (goToStep) {
                stepChange(goToStep, (goToStep - 1));
                $("#step" + (goToStep - 1)).slideUp();
                $("#step" + (goToStep - 1)).removeClass("step_active");
                if(currentStep == 7) {
                    disableButtons();
                }else if(currentStep == 2) {
                    <?php
                        if($installed_modules <= 0 || $showErrorBackground ||  $npm_missing || $assets_missing) {
                    ?>
                    nextBTN.text("Reload");
                    nextBTN.off("click");
                    nextBTN.on("click", function() {
                        window.location.reload();
                    });
                    <?php
                        }
                    ?>
                }else if(currentStep == 3) {
                    nextBTN.attr("disabled", true);
                    <?php
                        if(file_exists("../app/storage/db_settings")) {
                    ?>
                    $("#convert_settings_dialog").modal();
                    $("#convert_settings").click(function() {
                        $.ajax({
                            type: "GET",
                            url: "setup/convert_settings.php"
                        }).success(function() {
                            $("#convert_settings_dialog").modal("hide");
                            nextStep((currentStep + 1));
                            nextBTN.attr("disabled", false);
                        }).error(function() {
                            $("#convert_settings_error").show();
                        });
                    })
                    <?php
                        }
                    ?>
                }else if(currentStep == 6) {
                    openRegistrationForm();
                }else if(currentStep == 7) {
                    $.get("setup/finish");
                }else if(currentStep == 5) {
                    /**
                     * TODO - Not implemented on the server side yet
                     *
                     * $.get("setup/checkDBStatus", function(data) {
                     *   if(data.status == 1) {
                     *       nextStep((currentStep + 1));
                     *   }
                     * });
                     */
                    nextStep((currentStep + 1));
                }
                previousBTN.removeClass('disabled');
                previousBTN.attr("disabled", false);
            }
            previousBTN.click(function() {
                if(currentStep > 1) {
                    previousStep((currentStep - 1));
                }
            });
            nextBTN.click(function() {
                if(currentStep == 4) {
                    data = "";
                    var checkboxes = $("#config_form input[type='checkbox']");
                    for(var i = 0; i < checkboxes.length; i++) {
                        data += checkboxes[i].name + "=";
                        if(checkboxes[i].checked) {
                            data += "true&"
                        }else{
                            data += "false&"
                        }
                    }
                    data += "registration=" + $("#registration").val();
                    $.ajax({
                        type: "POST",
                        url: "setup/setConfig",
                        data: data
                    }).success(function() {
                        nextStep((currentStep + 1));
                    }).error(function(data) {
                        $("#configuration_fail_reason").text(data.responseJSON.errors);
                        $("#config_not_set").show();
                    });
                }else if(currentStep < 7) {
                    nextStep((currentStep + 1));
                }
            });
            function showCredentialAlert (credentialsCorrect, details) {
                if(credentialsCorrect == true) {
                    $("#credentials_correct").show();
                    $("#credentials_not_correct").hide();
                }else{
                    $("#credentials_correct").hide();
                    $("#credentials_fail_reason").text(details);
                    $("#credentials_not_correct").show();
                }
                $("html, body").animate({
                    scrollTop: $("#credentials_holder").offset().top
                });
            }
            $("#check_credentials").click(function() {
                data = $("#database_info_form").serialize();
                if((!$("#databaseField").val()) && $("#dbms_choice").val() !== "sqlite") {
                    showCredentialAlert(false, "not enough information");
                }else{
                    $.ajax("setup/check_database_credentials.php", {
                        type: "POST",
                        data: data
                    }).success(function() {
                        showCredentialAlert(true, "");
                        nextBTN.attr("disabled", false);
                    }).error(function(jqXHR) {
                        showCredentialAlert(false, jqXHR.responseText);
                    });
                }
            });
            $(".nav-tabs").on("click", "*", function() {
                $(".nav-tabs > li").removeClass("active");
                $(this).addClass("active");
                if($(this)[0].id !== "") {
                    var chosenText = $(this)[0].id;
                    $("#dbms_choice").val(chosenText);
                    if(chosenText === "sqlsrv") {
                        $("#portFieldElement").hide();
                        $("#serverFieldElement, #usernameFieldElement, #passwordFieldElement").show();
                    }else if(chosenText === "sqlite") {
                        $("#serverFieldElement, #portFieldElement, #usernameFieldElement, #passwordFieldElement").hide();
                    }else if(chosenText === "pgsql" || chosenText === "mysql") {
                        $("#serverFieldElement, #portFieldElement, #usernameFieldElement, #passwordFieldElement").show();
                    }
                }
            });
            function toggleButton(field, onload) {
                var switch_btn = $("#" + field + "_round");
                var checkbox = $("#" + field);
                var switch_full = $("#" + field + "_switch");
                if(checkbox.is(":checked")) {
                    if(!onload) {
                        switch_btn.css("left", 0);
                        switch_btn.css("right", '');
                        checkbox.prop("checked", false);
                        switch_full.removeClass("switch_active");
                    }else{
                        switch_btn.css("left", '');
                        switch_btn.css("right", 0);
                        switch_full.addClass("switch_active");
                    }
                }else{
                    if(!onload) {
                        switch_btn.css("left", '');
                        switch_btn.css("right", 0);
                        checkbox.prop("checked", true);
                        switch_full.addClass("switch_active");
                    }else{
                        switch_btn.css("left", 0);
                        switch_btn.css("right", '');
                    }
                }
            }
            function openRegistrationForm () {
                $.get("setup/register", function(data) {
                    $("#registration_form").html(data);
                    nextBTN.text("Register and Finish Installation");
                    nextBTN.off("click");
                    nextBTN.click(function() {
                        $.ajax({
                            type: "POST",
                            url: "setup/register",
                            data: $(".form-signin").serialize()
                        }).success(function() {
                            nextStep((currentStep + 1));
                        }).error(function(jqXHR) {
                            $("#registration_failed").show();
                            $("#registration_form").html(jqXHR.responseJSON.html);
                            var formValues = jqXHR.responseJSON.input;
                            $("#registration_form input").each(function(index, element) {
                                if(element.type !== "hidden") {
                                    $("#registration_form [name='" + element.name + "']").val(formValues[element.name]);
                                }
                            });
                        });
                    });
                });
            }
            $(document).ready(function() {
                $("#config_form div.switch").each(function(index, element) {
                    toggleButton((element.id).replace("_switch", ""), true);
                    $(element).click(function() {
                        toggleButton((element.id).replace("_switch", ""), false);
                    });
                });
                <?php
                    if($currentStep == 6) {
                ?>
                openRegistrationForm();
                <?php
                    }
                ?>
            });
        </script>
    </body>
</html>
