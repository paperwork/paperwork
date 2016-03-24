<!DOCTYPE html>
<html lang="en" class="setup_wizard">
    <head>
        @include('partials/header-sidewide-meta')
        [[ HTML::style('css/themes/paperwork-v1.min.css') ]]
    </head>
    
    <body id="wizard-body" class="">
        <div class="container-fluid wizard-body-wrapper">
        <div class="row wizard-body-wrapper">
        <div id="wizard-menu" class="col-sm-4 col-md-3" align="center">
            <a id="wizard-brand" class="navbar-brand transition-effect" href="/">
                <img class="wizard-paperwork-logo" src="[[ asset('images/paperwork-logo.png') ]]"> 
                <h1 class="wizard-title">Paperwork Setup</h1>
            </a>
            <div class="clearfix"></div>
            <div id="wizard-flow">
                <h4 class="current"><i class="fa fa-circle-o"></i> Welcome</h4>
                <h4 class="others" id="flow-setup"><i class="fa fa-circle-o"></i> Setup Wizard </h4>
                <div id="flow-wizard-secondary" style="display:none;">
                    <h4 class="others secondary"><i class="fa fa-circle-o"></i> Database </h4>
                    <h4 class="others secondary"><i class="fa fa-circle-o"></i> Configuration </h4>
                    <h4 class="others secondary"><i class="fa fa-circle-o"></i> Registration </h4>
                    </div>
                <h4 class="others"><i class="fa fa-circle-o"></i> Finish </h4>
            </div>
            <p style="margin-top:1.75em;">
                <a href="https://github.com/twostairs/paperwork">GitHub Repo</a> &middot; <a href="https://gitter.im/twostairs/paperwork">Gitter</a> &middot; <a href="https://github.com/twostairs/paperwork/wiki/Installing-and-configuring-Paperwork-without-using-the-Setup-Wizard" target="_blank">Wiki</a>
            </p>
        </div> <!-- Left menu bar -->
        <div class="wizard col-sm-8 col-md-9"> <!-- wizard -->
            <div class="container-fluid" style="padding-top:1em">
                <div class="form-group" style="display:@if($assets_missing) block @else none @endif">
                    <h1>[[ Lang::get('messages.setup.assets_check.assets_not_found') ]]</h1>
                    <p>[[ Lang::get('messages.setup.assets_check.assets_not_found_description') ]]</p>
                </div>
                <ul class="form text-center">
                    <li class="form-group @if($assets_missing) hidden @endif" align="left"> <!-- landing page -->
                        <div class="col-md-10 col-md-offset-1"><h1>[[ Lang::get('keywords.welcome') ]]</h1></div>
                        <div class="col-md-10 col-md-offset-1"><h4>[[ Lang::get('messages.setup.general.first_time') ]]</h4></div>
                        <div class="col-md-11 col-md-offset-1">
                            <p>[[ Lang::get('messages.setup.general.problems') ]]
                                <br><a href="https://groups.google.com/forum/#!forum/paperwork-dev" style="line-height: 25px;">Google Group</a>
                                <br><a href="https://gitter.im/twostairs/paperwork">Gitter</a>
                            </p>
                            <p>[[ Lang::get('messages.setup.general.wiki') ]]
                                <br><a href="https://github.com/twostairs/paperwork/wiki" style="line-height: 25px;">Paperwork Wiki</a>
                            </p>
                        </div>
                        <div class="col-md-11 col-md-offset-1"><h3>[[ Lang::get('messages.setup.update_check.checking_for_updates') ]]</h3>
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
                                <div class="col-md-4" style="padding:0" data-toggle="tooltip" data-placement="right" title="Coming Soon">
                                    <button class="btn btn-default btn-block next_step" id="update_button" disabled="disabled">Update (requires npm, bower and gulp)</button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-11 col-md-offset-1" style="margin-top:5px">
                            <h3>Setup</h3>
                            <p>When you are ready, you can proceed to the Setup Wizard</p>
                            <button class="btn btn-primary btn-md next_step" id="step0">[[ Lang::get('messages.setup.proceed_to_wizard_button') ]]</button>
                        </div>
                    </li> <!-- landing page -->
                    <li class="form-group" style="display:none"> <!-- wizard landing page -->
                        <div class="col-md-10 col-md-offset-1"><h1>[[ Lang::get('messages.setup.general.setup_wizard') ]]</h1></div>
                        <div class="col-md-10 col-md-offset-1"><h4>[[ Lang::get('messages.setup.general.setup_wizard_text') ]]</h4></div>
                        <div class="col-md-5 col-md-offset-1" style="margin-top:5px">
                            <h3>Setup Manually</h3>
                            <p>
                                [[ Lang::get('messages.setup.general.manual_configuration') ]]<a href="https://github.com/twostairs/paperwork/wiki/Installing-and-configuring-Paperwork-without-using-the-Setup-Wizard" target="_blank">here</a> 
                            </p>
                        </div>
                        <div class="col-md-5" style="margin-top:5px">
                            <h3>Setup using Setup Wizard</h3>
                            <p>The Setup Wizard guides you to fill in database settings and configure system and admin settings.</p>
                            <button class="btn btn-primary btn-md next_step" id="step1">[[ Lang::get('messages.setup.button_next') ]]</button>
                        </div>
                    </li> <!-- wizard landing page -->
                    <li class="form-group" style="display:none"> <!-- database setting -->
                        <h1>[[ Lang::get('messages.setup.database_setup.setting_up_database') ]]</h1>
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Select Database System</h3>
                            <p>Select the database system you would want Paperwork to use in your server</p>
                            <div class="btn-group dbms_choice" data-toggle="buttons">
                              <label class="btn btn-primary active database_links">
                                <input type="radio" checked>MySQL
                              </label>
                              <label class="btn btn-primary database_links">
                                <input type="radio">SQLite
                              </label>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1 dbms_details_form"> <!-- second drop down - requirements and credentials form -->
                            <div id="dbms_mysql_form">
                                <h3>Checking Database Requirements</h3>
                                @if(extension_loaded('mysql'))
                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_met') ]]</p>
                                @else 
                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_not_met') ]]</p>
                                @endif
                                <h3>Database system details</h3>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div id="connection_id_success" class="hidden">[[ Lang::get('messages.setup.database_setup.credentials_correct') ]]</div>
                                        <div id="connection_id_failure" class="hidden">[[ Lang::get('messages.setup.database_setup.credentials_not_correct') ]]<br>[[ Lang::get('messages.setup.database_setup.problem_persists') ]]</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputServer" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.server_form_label') ]]</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputServer" placeholder="[[ Lang::get('messages.setup.database_setup.server_form_placeholder') ]]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPort" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.port_form_label') ]]</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="inputPort" placeholder="[[ Lang::get('messages.setup.database_setup.port_form_placeholder') ]]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputUser" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.username_form_label') ]]</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputUser" placeholder="[[ Lang::get('messages.setup.database_setup.username_form_placeholder') ]]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.password_form_label') ]]</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputPassword" placeholder="[[ Lang::get('messages.setup.database_setup.password_form_placeholder') ]]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDatabase" class="col-sm-2 control-label">[[ Lang::get('messages.setup.database_setup.database_form_label') ]]</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputDatabase" placeholder="[[ Lang::get('messages.setup.database_setup.database_form_placeholder') ]]">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-default check-connection-btn" id="mysql_connection_check">[[ Lang::get('messages.setup.database_setup.button_check_connection_install_database') ]]</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="dbms_sqlite_form" class="hidden">
                            <h3>Checking Database Requirements</h3>
                                @if(extension_loaded('sqlite3'))
                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_met') ]]</p>
                                @else
                                    <p>[[ Lang::get('messages.setup.database_setup.requirements_not_met') ]]</p>
                                @endif
                            </div>
                        <button class="btn btn-primary btn-md next_step" id="step2">[[ Lang::get('messages.setup.button_next') ]]</button>
                        </div>
                    </li> <!-- database setting -->
                    <li class="form-group" style="display:none"> <!-- config -->
                        <h1>[[ Lang::get('messages.setup.configuration.configuration_settings') ]]</h1>
                        <div class="col-md-10 col-md-offset-1">    
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>[[ Lang::get('messages.setup.configuration.debug_mode') ]]</h3>
                                    <p>When your application is in debug mode, detailed error messages with stack traces will be shown on every error that occurs within your application. If disabled, a simple generic error page is shown.</p>
                                    </div>
                                <div id="debug_editable" class="config_switch" class="col-md-3">
                                    <input type="checkbox" id="debug_mode_switch" @if (Config::get('app.debug')) checked="checked" @endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>[[ Lang::get('messages.setup.configuration.registrations') ]]</h3>
                                    <p>If set to true, user registration is enabled. If set to false no new users will be able to register.</p>
                                </div>
                                <div id="registration_editable" class="config_switch" class="col-md-3">
                                    <input type="checkbox" id="registration_config_switch" @if (Config::get('paperwork.registration')) checked="checked" @endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>[[ Lang::get('messages.setup.configuration.forgot_password') ]]</h3>
                                    <p>If set to true, forgot password link is enabled.</p>
                                </div>
                                <div id="forgot_password_editable" class="config_switch" class="col-md-3">
                                    <input type="checkbox" id="forgot_password_switch" @if (Config::get('paperwork.forgot_password')) checked="checked" @endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>[[ Lang::get('messages.setup.configuration.issue_reporting_link') ]]</h3>
                                    <p>If set to true, a link for reporting issues is being displayed.</p>
                                </div>
                                <div id="issue_reporting_editable" class="config_switch" class="col-md-3">
                                    <input type="checkbox" id="issue_reporting_link_switch" @if (Config::get('paperwork.showIssueReportingLink')) checked="checked" @endif>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-8">
                                    <button class="btn btn-default" id="reset_default_btn">Reset to default</button>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <h3>More advanced settings</h3>
                            <p>For more advanced settings on user accounts, access, functions, etc. you can check out the configuration file at paperwork/frontend/app/config/paperwork.php</p>
                            <button class="btn btn-primary next_step" id="step3" style="margin-top:15px;">[[ Lang::get('messages.setup.button_next') ]]</button>
                        </div>
                    </li> <!-- config -->
                    <li class="form-group" style="display:none"> <!-- registration -->
                        <h1>[[ Lang::get('messages.setup.registration_first_user.register_first_user') ]]</h1>
                        <div class="col-md-8 col-md-offset-2" style="margin-top:2em">
                            <div id="error_div" class="hidden" align="left"></div>
                            @include("partials/registration-form", array('back' => false, 'frominstaller' => true))
                        </div>
                    </li> <!-- registration -->
                    <li class="form-group" style="display:none"> <!-- complete -->
                        <h1>[[ Lang::get('messages.setup.install_complete.installation_completed') ]]</h1>
                        <p style="margin:2em">[[ Lang::get('messages.setup.install_complete.installation_completed_message') ]]</p>
                        <button class="btn btn-primary btn-lg next_step" id="step5">[[ Lang::get('messages.setup.install_complete.proceed_to_paperwork_button') ]]</button>
                    </li> <!-- complete -->
                </ul>

            </div>
        </div> <!-- Wizard -->
        </div>
        </div>
        [[ HTML::script('js/jquery.min.js') ]]
        [[ HTML::script('js/bootstrap.min.js') ]]
        <script type="text/javascript">
            
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        
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
            
            function shownext(currentStep){
                var nextStep = currentStep+1;
                $("ul.form li").eq(currentStep).fadeOut(250, function(){
                        // $("ul.form li").eq(nextStep).removeClass("hidden");
                        $("ul.form li").eq(nextStep).fadeIn(250);
                    });
                if (currentStep!=1) $("#wizard-flow h4").eq(currentStep).removeClass('current').addClass('others');
                if (currentStep==0) $("#flow-wizard-secondary").slideToggle();
                if (currentStep==4) $("#flow-setup").removeClass('current').addClass('others')
                $("#wizard-flow h4").eq(nextStep).addClass('current').removeClass('others');
            }
            
            $(".next_step").click(function(event) {
                if($(event.currentTarget).hasClass("btn-primary") && event.target.id !== "step5" && event.target.id !== "step3" && driver !== "sqlite") {
                    var currentStep = parseInt(event.currentTarget.id.replace("step", ""), 10);
                    shownext(currentStep);

                }else if(event.target.id === "step2" && driver === "sqlite") {
                    event.preventDefault();
                    var dataString = "driver="+driver;
                    $.ajax({
                        type: "POST",
                        url: "install/checkdb",
                        data: dataString,
                    });
                    var currentStep = 2;
                    shownext(currentStep);
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
                                var currentStep = 3;
                                shownext(currentStep);
                            }
                        });
                    }else{
                        var currentStep = 3;
                        shownext(currentStep);
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
                            var currentStep = 2;
                            shownext(currentStep);
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
                        var currentStep = 4;
                        shownext(currentStep);
                    },
                    error: function(jqXHR) {
                        var text = "[[ Lang::get('messages.setup.registration_first_user.registration_failed') ]]";
                        $.each(jqXHR.responseJSON.errors, function(index, value) {
                            text += index.charAt(0).toUpperCase() + index.substring(1) + ", ";
                        });
                        text += "[[ Lang::get('messages.setup.registration_first_user.try_again') ]]";
                        $("#error_div").text(text);
                        $("#error_div").removeClass("hidden");
                        $("#step5_submit").unbind("click");
                        $("#step5_submit").click(function() {
                            var currentStep = 4;
                            shownext(currentStep);
                        });
                        $("#step5_submit").attr("value", "[[ Lang::get('messages.setup.registration_first_user.continue_without_registering') ]]");
                        $("#step5_submit").attr("id", "");
                    }
                });
            });
            
            $('#reset_default_btn').click(function(){
                $('#debug_mode_switch').prop('checked', true);
                $('#registration_config_switch').prop('checked', true);
                $('#forgot_password_switch').prop('checked', true);
                $('#issue_reporting_link_switch').prop('checked', true);
            });
            
            $(document).ready(function(){
                $('#wizard-flow h4 i').dblclick(function () {
                    if ($(this).parent().hasClass('current')){
                        if ($('#wizard-body').hasClass('blue-theme')) $('#wizard-body').removeClass('blue-theme');
                        else $('#wizard-body').addClass('blue-theme');
                    }
                });
            });
        </script>
    </body>
</html>