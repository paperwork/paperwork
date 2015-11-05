<!DOCTYPE html>
<html lang="en" class="setup_wizard">
    <head>
        @include('partials/header-sidewide-meta')
        [[ HTML::style('css/themes/paperwork-v1.min.css') ]]
    </head>
    
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="paperwork-logo navbar-brand transition-effect" href="/">
                        <img src="[[ asset('images/navbar-logo.png') ]]"> Paperwork
                    </a>
                </div>
            </div>
        </div>
        <div class="wizard"> <!-- wizard -->
            <div style="height:10px"> <!-- progress container -->
                <div id="progress_bar"><!-- progress bar --></div>
            </div>
            <div style="padding:10px;background-color:#FFFF91">
                <p class="text-center">
                    If you do not want to use the Setup Wizard, you can follow the instructions <a href="https://github.com/twostairs/paperwork/wiki/Installing-and-configuring-Paperwork-without-using-the-Setup-Wizard" target="_blank">here</a> to configure Paperwork manually. 
                </p>
            </div>
            <div class="container-fluid">
                <div class="first">
                    <div class="inner cover">
                        <div class="center-div">
                            <div class="questionnaire">
                                <div class="form-group" style="display:@if($assets_missing) block @else none @endif">
                                    <h1>[[ Lang::get('messages.setup.assets_check.assets_not_found') ]]</h1>
                                    <p>[[ Lang::get('messages.setup.assets_check.assets_not_found_description') ]]</p>
                                </div>
                                <ul class="form text-center">
                                    <li class="form-group @if($assets_missing) hidden @endif">
                                        <h1>[[ Lang::get('messages.setup.update_check.checking_for_updates') ]]</h1>
                                        <?php
                                            list($lastCommitOnInstall, $upstreamLatest, $lastCommitTimestamp, $upstreamTimestamp) = PaperworkHelpers::getHashes();
                                        ?>
                                        @if(empty($lastCommitOnInstall))
                                            @if(function_exists('curl_init'))
                                            <p>[[ Lang::get('messages.setup.update_check.cannot_connect_error_no_solution') ]]</p>
                                            @else
                                            <p>[[ Lang::get('messages.setup.update_check.cannot_connect_error_curl') ]]</p>
                                            @endif
                                        @elseif(strtotime($lastCommitTimestamp) > strtotime($upstreamTimestamp))
                                            <p>[[ Lang::get('messages.setup.update_check.newer_commit_found') ]]</p>
                                        @else
                                            <p>[[ Lang::get('messages.setup.update_check.newer_version_available') ]]</p>
                                            <button class="btn btn-default btn-lg next_step" style="left: 5% !important;right: 5% !important;width:100%; bottom:25%;" id="update_button">Update (requires npm, bower and gulp)</button>
                                        @endif
                                        <button class="btn btn-primary btn-lg next_step" id="step1">[[ Lang::get('messages.setup.button_next') ]]</button>
                                    </li>
                                    <li class="form-group hidden">
                                        <h1>[[ Lang::get('messages.setup.database_setup.setting_up_database') ]]</h1>
                                        <div class="dbms_choice"> <!--- first drop down - dbms choice -->
                                            <a class="database_links active">MySQL <span class="caret"></span></a><br>
                                            <a class="database_links">SQLite <span class="caret"></span></a><br>
                                            <a class="database_links hidden">Choice 2 <span class="caret"></span></a>
                                        </div>
                                        <div class="dbms_details_form"> <!-- second drop down - requirements and credentials form -->
                                            <div id="dbms_mysql_form">
                                                @if(extension_loaded('mysql'))
                                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_met') ]]</p>
                                                @else 
                                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_not_met') ]]</p>
                                                @endif
                                                <form class="form-horizontal">
                                                    <div class="form-group">
                                                        <div id="connection_id_success" class="hidden">[[ Lang::get('messages.setup.database_setup.credentials_correct') ]]</div>
                                                        <div id="connection_id_failure" class="hidden">[[ Lang::get('messages.setup.database_setup.credentials_not_correct') ]]</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputServer" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.server_form_label') ]]</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputServer" placeholder="[[ Lang::get('messages.setup.database_setup.server_form_label') ]]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPort" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.port_form_label') ]]</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="inputPort" placeholder="[[ Lang::get('messages.setup.database_setup.port_form_label') ]]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputUser" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.username_form_label') ]]</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputUser" placeholder="[[ Lang::get('messages.setup.database_setup.username_form_label') ]]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPassword" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.password_form_label') ]]</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" id="inputPassword" placeholder="[[ Lang::get('messages.setup.database_setup.password_form_label') ]]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputDatabase" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.database_form_label') ]]</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputDatabase" placeholder="[[ Lang::get('messages.setup.database_setup.database_form_label') ]]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-default" id="mysql_connection_check">[[ Lang::get('messages.setup.database_setup.button_check_connection_install_database') ]]</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="dbms_sqlite_form" class="hidden">
                                                @if(extension_loaded('sqlite3'))
                                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_met') ]]</p>
                                                @else
                                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_not_met') ]]</p>
                                                @endif
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-lg next_step" id="step2">[[ Lang::get('messages.setup.button_next') ]]</button>
                                    </li>
                                    <li class="form-group hidden">
                                        <h1>[[ Lang::get('messages.setup.configuration.configurating') ]]</h1>
                                        <div>
                                            <div class="row">
                                                <h2 style="">[[ Lang::get('messages.setup.configuration.configuration_settings') ]]</h2>
                                                <a id="change_config">[[ Lang::get('messages.setup.configuration.change') ]]</a>
                                            </div>
                                            <div>    
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3>[[ Lang::get('messages.setup.configuration.debug_mode') ]]</h3>
                                                        <p><!--Help Text--></p>
                                                    </div>
                                                    <div id="debug_non_editable" class="col-md-3">
                                                        <input type="checkbox" disabled="disabled" @if (Config::get('app.debug')) checked="checked" @endif>   
                                                    </div>
                                                    <div id="debug_editable" class="hidden col-md-3">
                                                        <input type="checkbox" id="debug_mode_switch" @if (Config::get('app.debug')) checked="checked" @endif>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3>[[ Lang::get('messages.setup.configuration.registrations') ]]</h3>
                                                        <p><!--Help Text--></p>
                                                    </div>
                                                    <div id="registration_non_editable" class="col-md-3">
                                                        <input type="checkbox" disabled="disabled" @if (Config::get('paperwork.registration')) checked="checked" @endif>
                                                    </div>
                                                    <div id="registration_editable" class="col-md-3 hidden">
                                                        <input type="checkbox" id="registration_config_switch" @if (Config::get('paperwork.registration')) checked="checked" @endif>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3>[[ Lang::get('messages.setup.configuration.forgot_password') ]]</h3>
                                                        <p><!--Help Text--></p>
                                                    </div>
                                                    <div id="forgot_password_non_editable" class="col-md-3">
                                                        <input type="checkbox" disabled="disabled" @if (Config::get('paperwork.forgot_password')) checked="checked" @endif>
                                                    </div>
                                                    <div id="forgot_password_editable" class="col-md-3 hidden">
                                                        <input type="checkbox" id="forgot_password_switch" @if (Config::get('paperwork.forgot_password')) checked="checked" @endif>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <h3>[[ Lang::get('messages.setup.configuration.issue_reporting_link') ]]</h3>
                                                        <p><!--Help Text--></p>
                                                    </div>
                                                    <div id="issue_reporting_non_editable" class="col-md-3">
                                                        <input type="checkbox" disabled="disabled" @if (Config::get('paperwork.showIssueReportingLink')) checked="checked" @endif>
                                                    </div>
                                                    <div id="issue_reporting_editable" class="col-md-3 hidden">
                                                        <input type="checkbox" id="issue_reporting_link_switch" @if (Config::get('paperwork.showIssueReportingLink')) checked="checked" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-lg next_step" id="step3">[[ Lang::get('messages.setup.button_next') ]]</button>
                                    </li>
                                    <li class="form-group hidden">
                                        <h1>[[ Lang::get('messages.setup.registration_first_user.register_first_user') ]]</h1>
                                        <div id="error_div" class="hidden"></div>
                                        @include("partials/registration-form", array('back' => false, 'frominstaller' => true))
                                    </li>
                                    <li class="form-group hidden">
                                        <h1>[[ Lang::get('messages.setup.install_complete.installation_completed') ]]</h1>
                                        <p>[[ Lang::get('messages.setup.install_complete.installation_completed_message') ]]</p>
                                        <button class="btn btn-primary btn-lg next_step" id="step5">[[ Lang::get('messages.setup.install_complete.proceed_to_paperwork_button') ]]</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        [[ HTML::script('js/jquery.min.js') ]]
        <script type="text/javascript">
            var driver = "mysql";
            $(".database_links").click(function(event) {
                $("#dbms_"+driver+"_form").addClass("hidden");
                driver = ((event.currentTarget.innerText).trim()).toLowerCase();
                $(".database_links").removeClass("active");
                $(event.currentTarget).addClass("active");
                $("#dbms_"+driver+"_form").removeClass("hidden");
                if(driver === "choice 2") {
                    driver = "mysql";
                    alert("[[ Lang::get('messages.setup.database_setup.new_db_options_soon') ]]");
                }
            });
            $(".next_step").click(function(event) {
                if($(event.currentTarget).hasClass("btn-primary") && event.target.id !== "step5" && event.target.id !== "step3" && driver !== "sqlite") {
                    var currentStep = parseInt(event.currentTarget.id.replace("step", ""), 10) - 1;
                    var nextStep = currentStep + 1;
                    $("ul.form li").eq(currentStep).fadeOut("slow");
                    $("ul.form li").eq(currentStep).addClass("hidden");
                    $("ul.form li").eq(nextStep).removeClass("hidden");
                    $("ul.form li").eq(nextStep).fadeIn("slow");
                    $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                }else if(event.target.id === "step2" && driver === "sqlite") {
                    event.preventDefault();
                    var dataString = "driver="+driver;
                    $.ajax({
                        type: "POST",
                        url: "install/checkdb",
                        data: dataString,
                    });
                    var currentStep = 2 - 1;
                    var nextStep = currentStep + 1;
                    $("ul.form li").eq(currentStep).fadeOut("slow");
                    $("ul.form li").eq(currentStep).addClass("hidden");
                    $("ul.form li").eq(nextStep).removeClass("hidden");
                    $("ul.form li").eq(nextStep).fadeIn("slow");
                    $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                }else if(event.currentTarget.id === "update_button") {
                    alert("[[ Lang::get('messages.setup.update_check.coming_soon') ]]");
                }else if(event.target.id === "step5") {
                    $.ajax({
                        type: "POST",
                        url: "install/finish",
                        success: function() {
                            window.location.href = "/login";
                        }
                    });
                }else if(event.target.id === "step3") {
                    if($("#change_config").hasClass("hidden")) {
                        var debug = $("#debug_mode_switch").is(":checked");
                        var registration = $("#registration_config_switch").is(":checked");
                        var forgot = $("#forgot_password_switch").is(":checked");
                        var showIssue = $("#issue_reporting_link_switch").is(":checked");
                        var data = "debug="+debug+"&registration="+registration+"&forgot_password="+forgot+"&showIssueReportingLink="+showIssue;
                        $.ajax({
                            type: "POST",
                            url: "install/configurate",
                            data: data,
                            success: function() {
                                var currentStep = 3 - 1;
                                var nextStep = currentStep + 1;
                                $("ul.form li").eq(currentStep).fadeOut("slow");
                                $("ul.form li").eq(currentStep).addClass("hidden");
                                $("ul.form li").eq(nextStep).removeClass("hidden");
                                $("ul.form li").eq(nextStep).fadeIn("slow");
                                $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                            }
                        });
                    }else{
                        var currentStep = 3 - 1;
                        var nextStep = currentStep + 1;
                        $("ul.form li").eq(currentStep).fadeOut("slow");
                        $("ul.form li").eq(currentStep).addClass("hidden");
                        $("ul.form li").eq(nextStep).removeClass("hidden");
                        $("ul.form li").eq(nextStep).fadeIn("slow");
                        $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                    }
                }
            });
            $("#mysql_connection_check").click(function() {
                event.preventDefault();
                var user = $("#inputUser").val();
                var pass = $("#inputPassword").val();
                var server = $("#inputServer").val();
                var port = $("#inputPort").val();
                var database = $("#inputDatabase").val();
                var dataString = "username="+user+"&password="+pass+"&server="+server+"&driver="+driver+"&port="+port+"&database="+database;
                $.ajax({
                    type: "POST",
                    url: "install/checkdb",
                    data: dataString,
                    success: function() {
                        $("#connection_id_success").removeClass("hidden");
                        $("#connection_id_failure").addClass("hidden");
                        setTimeout(function() {
                            var currentStep = 2 - 1;
                            var nextStep = currentStep + 1;
                            $("ul.form li").eq(currentStep).fadeOut("slow");
                            $("ul.form li").eq(currentStep).addClass("hidden");
                            $("ul.form li").eq(nextStep).removeClass("hidden");
                            $("ul.form li").eq(nextStep).fadeIn("slow");
                            $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                        }, 2000);
                    },
                    error: function() {
                        $("#connection_id_failure").removeClass("hidden");
                        $("#connection_id_success").addClass("hidden");
                    }
                });
            });
            $("#step5_submit").click(function(event) {
                event.preventDefault();
                var token = $("[name='_token']").val();
                var user = $("[name='username']").val();
                var name = $("[name='firstname']").val();
                var lastname = $("[name='lastname']").val();
                var pass = $("[name='password']").val();
                var confirm = $("[name='password_confirmation']").val();
                var lang = $("#ui_language").val(); 
                var dataString = 
                    "_token="+token+"&username="+user+"&firstname="+name+"&lastname="+
                    lastname+"&password="+pass+"&password_confirmation="+confirm
                    +"&ui_language="+lang+"&frominstaller=1";
                $.ajax({
                    type: "POST",
                    url: "install/registeradmin",
                    data: dataString,
                    success: function() {
                        var currentStep = 4 - 1;
                        var nextStep = currentStep + 1;
                        $("ul.form li").eq(currentStep).fadeOut("slow");
                        $("ul.form li").eq(currentStep).addClass("hidden");
                        $("ul.form li").eq(nextStep).removeClass("hidden");
                        $("ul.form li").eq(nextStep).fadeIn("slow");
                        $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");
                    },
                    error: function(jqXHR) {
                        var text = "[[ Lang::get('messages.setup.registration_first_user.registration_failed') ]]";
                        $.each(jqXHR.responseJSON.errors, function(index, value) {
                            text += index.charAt(0).toUpperCase() + index.substring(1) + ", ";
                        });
                        $("#error_div").text(text);
                        $("#error_div").removeClass("hidden");
                        $("#step5_submit").unbind("click");
                        $("#step5_submit").click(function() {
                            var currentStep = 4 - 1;
                            var nextStep = currentStep + 1;
                            $("ul.form li").eq(currentStep).fadeOut("slow");
                            $("ul.form li").eq(currentStep).addClass("hidden");
                            $("ul.form li").eq(nextStep).removeClass("hidden");
                            $("ul.form li").eq(nextStep).fadeIn("slow");
                            $("#progress_bar").css("width", ((nextStep / 5) * 100) + "%");                       
                        });
                        $("#step5_submit").attr("value", "[[ Lang::get('messages.setup.registration_first_user.continue_without_registering') ]]");
                        $("#step5_submit").attr("id", "");
                    }
                });
            });
            $("#change_config").click(function() {
                $("#change_config").addClass("hidden");
                $("#debug_non_editable").addClass("hidden");
                $("#registration_non_editable").addClass("hidden");
                $("#forgot_password_non_editable").addClass("hidden");
                $("#issue_reporting_non_editable").addClass("hidden");
                $("#debug_editable").removeClass("hidden");
                $("#registration_editable").removeClass("hidden");
                $("#forgot_password_editable").removeClass("hidden");
                $("#issue_reporting_editable").removeClass("hidden");
            });
        </script>
    </body>
</html>