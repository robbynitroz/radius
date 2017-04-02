<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>

    <link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css">
    <title>Admin panel</title>
    <?php
    foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"/>

    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>

        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>

    <script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <!-- Latest compiled and minified JavaScript -->

    <style type='text/css'>
        body {
            font-family: Arial;
            font-size: 14px;
        }

        a {
            color: blue;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }

        .fade {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: -1;
            opacity: 0;
            -webkit-transition: opacity 0.15s linear;
            -moz-transition: opacity 0.15s linear;
            -o-transition: opacity 0.15s linear;
            transition: opacity 0.15s linear;
        }

        .fade.in {
            opacity: 1;
            z-index: 100;
        }
    </style>

</head>
<body>

<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=696113500523537';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function() {
        $.ajaxSetup({ cache: true });
        $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
                appId: '696113500523537',
                status: true, // check login status
                oauth: false,
                version: 'v2.8' // or v2.1, v2.2, v2.3, ...
            });
            $('#loginbutton,#feedbutton').removeAttr('disabled');

            FB.Event.subscribe('edge.create', function(response) {
                window.location = 'http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url';
            });

            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var accessToken = response.authResponse.accessToken;

                    FB.api('/me/likes/830775716985965', {access_token: accessToken}, function(response) {
                        console.log(response.data);
                    });

                    FB.api('/me', { locale: 'en_US', fields: 'name, email', access_token: accessToken },
                        function(response) {
                            console.log(response.email);
                        }
                    );
                }
            } );

        });
    });

</script>

<!-- Beginning header -->
<!--<div>-->
<!--    <a href='--><?php //echo site_url('admin/main/hotels') ?><!--'>Manage hotels</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/nas') ?><!--'>Manage hotel routers</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/defaults') ?><!--'>Edit template defaults</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/emails') ?><!--'>Emails</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/active_users') ?><!--'>Active users</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/users') ?><!--'>User management</a> |-->
<!--    <a href='--><?php //echo site_url('admin/main/templates') ?><!--'>Templates management</a> |-->
<!--    <a href='--><?php //echo site_url('admin/logout') ?><!--'>Logout</a> |-->
<!---->
<!--    <div id="myAlert" class="alert fade" data-alert="alert">This is the alert.</div>-->
<!--</div>-->

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="li-hotels active">
                        <a href='<?php echo site_url('admin/main/hotels') ?>'>Manage hotels</a>
                    </li>
                    <li class='li-nas'>
                        <a href='<?php echo site_url('admin/main/nas') ?>'>Manage hotel routers</a>
                    </li>
                    <li class='li-defaults'>
                        <a href='<?php echo site_url('admin/main/defaults') ?>'>Edit template defaults</a>
                    </li>
                    <li class='li-emails'>
                        <a href='<?php echo site_url('admin/main/emails') ?>'>Emails</a>
                    </li>
                    <li class='li-active_users'>
                        <a href='<?php echo site_url('admin/main/active_users') ?>'>Active users</a>
                    </li>
                    <li class='li-users'>
                        <a href='<?php echo site_url('admin/main/users') ?>'>User management</a>
                    </li>
                    <li class='li-templates'>
                        <a href='<?php echo site_url('admin/main/templates') ?>'>Templates management</a>
                    </li>
                    <li class='li-change-pass'>
                        <a href='<?php echo site_url('admin/change-pass') ?>'>Change Admin password</a>
                    </li>
                    <li class='li-logout'>
                        <a href='<?php echo site_url('admin/logout') ?>'>Logout</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="myAlert" class="alert fade" data-alert="alert">This is the alert.</div>

<!-- End of header-->
<div style='height:20px;'></div>
<div>
    <?php echo $output; ?>

</div>

<!-- Template variables form start -->
<div id="template_edit" class="row" style="margin: 10px"></div>
<!-- Template variables form end -->

<!-- Hotel Statistics form -->
<div id="hotel_statistics" class="row" style="margin: 10px"></div>
<!-- Hotel Statistics form end-->

<!-- Hotel mails form -->
<div id="hotel_emails" class="row" style="margin: 10px"></div>
<!-- Hotel Statistics form end-->

<!-- Beginning footer -->
<div>
    <footer>
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong>
            seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </p>
    </footer>
<!--    <script src="/assets/js/jquery-1.10.2.js"></script>-->
    <script src="/assets/js/bootstrap.min.js"></script>
    <?php echo $before_body; ?>
</div>
<!-- End of Footer -->

<script>
    $(document).on('ready', function () {

        window.icon_sets = '';

        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/getIcons',
            dataType: 'json',
            data: {},
            success: function(response){
                if(response) {
                    window.icon_sets = response;
                } else {
                    return false;
                }
            },
            async:false
        });

        //Get current URL
        var URL = window.location.href;
        var URL_SEGMENTS = URL.split('/');
        window.SEGMENT_1 = URL_SEGMENTS[URL_SEGMENTS.length - 3];
        window.SEGMENT_2 = URL_SEGMENTS[URL_SEGMENTS.length - 2];
        window.SEGMENT_3 = URL_SEGMENTS[URL_SEGMENTS.length - 1].replace('#', ''); //last segment


        if (window.SEGMENT_2 == 'edit') {

            if (window.SEGMENT_1 == 'hotels') {
                // SEGMENT_3 is a hotel id
                getHotelTemplatesAndActiveTemplate(parseInt(window.SEGMENT_3));
            } else if (window.SEGMENT_1 == 'nas') {
                if ($('#field-hotel_id').length) {
                    generateFlushMacAddress();
                }
            }
        } else if (window.SEGMENT_3 == 'hotels' && window.SEGMENT_2 == 'main') {
            $('.navbar-nav li' ).removeClass('active');
            $('.li-hotels').addClass('active');
            getAllHotelsAndTemplates();
        } else if (window.SEGMENT_3 == 'admin' && window.SEGMENT_2 == 'index.php') {

        }else if (window.SEGMENT_3 == 'nas' && window.SEGMENT_2 == 'main') {
            $('.navbar-nav li' ).removeClass('active');
            $('.li-nas').addClass('active');
            addRouterOnlineColumn();
//            addRouterUsersColumn();
        }

    });

    function getHotelTemplatesAndActiveTemplate(hotel_id) {
        $.ajax({
            type: "POST",
            url: "/index.php/admin/main/getHotelTemplatesAndActiveTemplate",
            dataType: "json",
            data: {hotel_id: hotel_id},
            success: function (response) {
                generateHotelTemplatesActiveRadioBtn(hotel_id, response);
                generateHotelTemplatesRadioBtn(hotel_id, response);
                getAllLanguages(hotel_id, response);
            }
        });
    }

    function addRouterOnlineColumn()
    {
        // Get main table's last TR
        var online = '<th width="3%"><div class="text-left field-sorting " rel="wifi">Online</div></th>';
        $(online).insertBefore('#flex1 thead tr th:last');

        //Get all routers Ip
        var routers_ip = $('#flex1 tbody tr td:first-child div');
        var routers_ip_array = [];
        $.each(routers_ip, function( index, value ) {
            routers_ip_array.push($(value).text());
        });

        // Call ajax to get all routers statuses
        getRoutersStatus(routers_ip_array);

    }

    function fillRouterOnlineColumn(array_of_status)
    {
        // Add rows TD
        var online_item = '';
        var all_rows = $('#flex1 tbody tr');
        $.each(all_rows, function( index, value ) {
            var last_td = $(value).find('td:last');
            var router_ip = $.trim($(value).find('td:first').text());
            var status = (array_of_status[router_ip] == 0)?'Offline': 'Online';
            $('<td width="3%" class=""><div class="text-left '+ status +'">'+ status +'</div></td>').insertBefore($(last_td));
        });

        addRouterUsersColumn();
    }

    function addRouterUsersColumn()
    {
        // Get main table's last TR
        var online = '<th width="3%"><div class="text-left field-sorting " rel="wifi">Users</div></th>';
        $(online).insertBefore('#flex1 thead tr th:last');

        //Get all routers IP
        var routers_ip = $('#flex1 tbody tr td:first-child div');
        var routers_ip_array = [];
        var router_status = '';

        $.each(routers_ip, function( index, value ) {

            router_status = $('#flex1 tbody tr:eq('+ index +') td:eq(4) div').text().toLowerCase();
            if(router_status != 'offline') {
                routers_ip_array.push($(value).text());
            }

        });

        // Call ajax to get all routers statuses
        getRoutersUsersCount(routers_ip_array);
    }

    function fillRoutersUsersCount(array_of_counts)
    {
        // Add rows TD
        var online_item = '';
        var all_rows = $('#flex1 tbody tr');

        if(array_of_counts.length == 0) {
            $.each(all_rows, function( index, value ) {
                var last_td = $(value).find('td:last');
                var router_ip = $.trim($(value).find('td:first').text());
                $('<td width="" class=""><div class="text-left">0</div></td>').insertBefore($(last_td));
            });
        } else {
            $.each(all_rows, function( index, value ) {
                var last_td = $(value).find('td:last');
                var router_ip = $.trim($(value).find('td:first').text());
                var count = (typeof array_of_counts[router_ip] == 'undefined' )? '0': array_of_counts[router_ip];
                $('<td width="" class=""><div class="text-left">'+ count +'</div></td>').insertBefore($(last_td));
            });
        }


        addRouterBandwidthColumn();
    }

    function addRouterBandwidthColumn()
    {
        // Get main table's last TR
        var online = '<th width="3%"><div class="text-left field-sorting " rel="wifi">Bandwidth</div></th>';
        $(online).insertBefore('#flex1 thead tr th:last');

        //Get all routers IP
        var routers_ip = $('#flex1 tbody tr td:first-child div');
        var routers_ip_array = [];
        $.each(routers_ip, function( index, value ) {
            routers_ip_array.push($(value).text());
        });

        // Call ajax to get all routers statuses
        getRoutersBandwidth(routers_ip_array);
    }

    function fillRouterBandwidth(array_of_traffic)
    {
        // Add rows TD
        var online_item = '';
        var all_rows = $('#flex1 tbody tr');
        $.each(all_rows, function( index, value ) {
            var last_td = $(value).find('td:last');
            var router_ip = $.trim($(value).find('td:first').text());
            $('<td width="" class=""><div class="text-left">'+ formatBytes(array_of_traffic[router_ip], 0) +'</div></td>').insertBefore($(last_td));
        });
    }

    function formatBytes(bytes, decimals)
    {
//        var bytes = bites/8;

        if(bytes == 0){
            return '0 Byte';
        }
        var k = 1000; // or 1024 for binary
        var dm = decimals + 1 || 3;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }


    function getRoutersStatus(routers_ip_array)
    {
        $.ajax({
            type: 'post',
            url: '/index.php/admin/main/getRoutersStatus',
            dataType: 'json',
            data: {routers_ip_array: routers_ip_array},
            success: function (response) {
                if(response) {
                    fillRouterOnlineColumn(response);
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    function getRoutersUsersCount(routers_ip_array)
    {
        if(routers_ip_array.length == 0) {
            return  fillRoutersUsersCount([]);
        }

        $.ajax({
            type: 'post',
            url: '/index.php/admin/main/getRoutersUsersCount',
            dataType: 'json',
            data: {routers_ip_array: routers_ip_array},
            success: function (response) {
                if(response) {
                    fillRoutersUsersCount(response);
                }
            }
        });
    }

    function getRoutersBandwidth(routers_ip_array)
    {
        $.ajax({
            type: 'post',
            url: '/index.php/admin/main/getRoutersBandwidth',
            dataType: 'json',
            data: {routers_ip_array: routers_ip_array},
            success: function (response) {
                if(response) {
                    fillRouterBandwidth(response, routers_ip_array);
                }
            }
        });
    }

    function getAllHotelsAndTemplates() {
        $.ajax({
            type: "POST",
            url: "/index.php/admin/main/getAllHotelsAndTemplates",
            dataType: "json",
            data: {},
            success: function (response) {
                window.allHotelsAndTemplates = response;

                var hotels_table = getHotelsTable();

                var hotel_column_number = findHotelIDColumnNumber(hotels_table);
                var hotels_id = getHotelsID(hotels_table, hotel_column_number);

                var templates_column_number = findTemplatesColumnNumber(hotels_table);

                runOverTemplates(hotels_table, templates_column_number, hotels_id);
            }
        });
    }

    function getTemplateVariables(hotel_id, template_id) {

        $.ajax({
            type: "POST",
            url: "/index.php/admin/main/getTemplateVariables",
            dataType: "json",
            data: {hotel_id: hotel_id, template_id: template_id},
            success: function (response) {
                response['template_id'] = template_id;
                generateTemplateEdit(response);
            }
        });
        return 0;
    }

    function generateTemplateEdit(template_variables) {
        var template_variables_length = $.map(template_variables, function (el) {
            return el
        }).length;

        if (template_variables_length == 1) {

            template_variables['hotel_label_1'] = '';
            template_variables['hotel_label_2'] = '';
            template_variables['hotel_btn_label'] = '';

            template_variables['hotel_bg_image'] = 'undefined.png';
            template_variables['hotel_logo'] = 'undefined.png';

            template_variables['hotel_bg_color'] = '';
            template_variables['hotel_centr_color'] = '';
            template_variables['hotel_btn_bg_color'] = '';

            template_variables['hotel_font_color1'] = ''; // header font color
            template_variables['hotel_font_color2'] = ''; // button font color
            template_variables['hotel_font_color3'] = ''; // label  font color

            template_variables['hotel_font_size1'] = '';  // header font size
            template_variables['hotel_font_size2'] = '';  // button font size
            template_variables['hotel_font_size3'] = '';  // label font size

        }

        var edit_form;
        var template_type = template_variables['template_type'];

        switch(template_type){
            case 'Login template':
                edit_form = generateTemplateLoginEdit(template_variables);
                $('#template_edit').html(edit_form);
                break;
            case 'Email template':
                edit_form = generateTemplateEmailEdit(template_variables);
                $('#template_edit').html(edit_form);
                break;
            case 'Facebook template':
                edit_form = generateTemplateFacebookEdit(template_variables);
                $('#template_edit').html(edit_form);
                break;
            case 'Question template':
                edit_form = generateTemplateQuestionEdit(template_variables);
                $('#template_edit').html(edit_form);
                break;
        }

        addClickOnLanguageTabItem()  ;

        $("html, body").animate({scrollTop: 320}, 1200);

        $("#close_template_edit").on('click', function () {
            if ($("#template_edit").hasClass("show_edit_template")) {
                $("#template_edit").removeClass("show_edit_template");
            }
        });

        // Write to db template's variables by clicking Update
        $('#template_update').submit(function (e) {
            e.preventDefault();
            var form = $('#template_update')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: '/index.php/admin/main/setTemplateVariables',
                dataType: "json",
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response) {
                        if ($("#template_edit").hasClass("show_edit_template")) {
                            $("#template_edit").removeClass("show_edit_template");
                        }
                        $("input.template_item").attr('checked', false);
                        flashMsg('Variables successfully updated!', 'success');
                        location.reload();
                    }
                    else if(response['image_errors'] !== 'undefined') {
                        flashMsg(response['image_errors'], 'danger');
                    }
                    else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (request) {
                    flashMsg(request.responseText, 'danger');
                }
            });
        });

        // Add on change to the Icon Selet list
        $('.icon_set_select').on('change', function(){
            var new_set_id  = $(this).val();
            var question_id = $(this).data('question_id');

            $.ajax({
                type: 'POST',
                url: '/index.php/admin/main/setIconsForQuestion',
                dataType: 'json',
                data: {question_id: question_id, icon_set_id: new_set_id},
                success: function (response) {
                    if (response) {
                        flashMsg('Icon successfully changed!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (response) {
                    flashMsg(response.responseText, 'danger');
                }
            });
        });
    }

    function generateTemplateLoginEdit(data)
    {
        var language_tabs = generateLanguageTabs();

        var edit_form =
            '<div class="col-md-12">' +
                '<div style="margin: 10px 0px;">' +
                    language_tabs +
                '</div>' +
                '<form id="template_update" role="form" enctype="multipart/form-data">' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel header text:</label>' +
                        '<input type="text" class="form-control" name="hotel_label_1" value="' + data['hotel_label_1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel button text:</label>' +
                        '<input type="text" class="form-control" name="hotel_btn_label" value="' + data['hotel_btn_label'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel button label:</label>' +
                        '<input type="text" class="form-control" name="hotel_label_2" value="' + data['hotel_label_2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel background image:</label>' +
                        '<img src="/assets/variables/' + data['hotel_bg_image'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                        '<input type="file" class="form-control" name="hotel_bg_image" value="">' +
                    '</div>' +
                        '<div class="form-group">' +
                        '<label for="pwd">Hotel logo:</label>' +
                        '<img src="/assets/variables/' + data['hotel_logo'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                        '<input type="file" class="form-control" name="hotel_logo" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel background color:</label>' +
                        '<input type="color" class="form-control" name="hotel_bg_color" value="' + data['hotel_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel central part color:</label>' +
                        '<input type="color" class="form-control" name="hotel_centr_color" value="' + data['hotel_centr_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Hotel button background color:</label>' +
                        '<input type="color" class="form-control" name="hotel_btn_bg_color" value="' + data['hotel_btn_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Header font color:</label>' +
                        '<input type="color" class="form-control" name="hotel_font_color1" value="' + data['hotel_font_color1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Button font color:</label>' +
                        '<input type="color" class="form-control" name="hotel_font_color2" value="' + data['hotel_font_color2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Label font color:</label>' +
                        '<input type="color" class="form-control" name="hotel_font_color3" value="' + data['hotel_font_color3'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Header font size:</label>' +
                        '<input type="number" class="form-control" name="hotel_font_size1" value="' + data['hotel_font_size1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Button font size:</label>' +
                        '<input type="number" class="form-control" name="hotel_font_size2" value="' + data['hotel_font_size2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label for="pwd">Label font size:</label>' +
                        '<input type="number" class="form-control" name="hotel_font_size3" value="' + data['hotel_font_size3'] + '">' +
                    '</div>' +
                    '<input type="hidden" class="form-control" name="template_id" value="' + data['template_id'] + '">' +
                    '<input type="hidden" class="form-control" name="template_type" value="' + data['template_type'] + '">' +
                    '<input type="hidden" class="form-control" name="hotel_id" value="' +  window.SEGMENT_3 + '">' +
                    '<input type="hidden" class="form-control" name="form_language" value="' + window.ACTIVE_LANGUAGES[0]['name'] + '">' +
                    '<button type="submit" class="btn btn-info">Submit</button>' +
                    '<button type="button" class="btn btn-info" id="close_template_edit" style="margin-left: 10px">Close</button>' +
                '</form>' +
            '</div>';

        return edit_form;
    }

    function generateTemplateEmailEdit(data)
    {
        var language_tabs = generateLanguageTabs();

        var edit_form =
            '<div class="col-md-12">' +
                '<div style="margin: 10px 0px;">' +
                    language_tabs +
                '</div>' +
                '<form id="template_update" role="form" enctype="multipart/form-data">' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel header text:</label>' +
                    '<input type="text" class="form-control" name="hotel_label_1" value="' + data['hotel_label_1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel button text:</label>' +
                    '<input type="text" class="form-control" name="hotel_btn_label" value="' + data['hotel_btn_label'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel email placeholder:</label>' +
                    '<input type="text" class="form-control" name="hotel_label_2" value="' + data['hotel_label_2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background image:</label>' +
                    '<img src="/assets/variables/' + data['hotel_bg_image'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_bg_image" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel logo:</label>' +
                    '<img src="/assets/variables/' + data['hotel_logo'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_logo" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background color:</label>' +
                    '<input type="color" class="form-control" name="hotel_bg_color" value="' + data['hotel_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel central part color:</label>' +
                    '<input type="color" class="form-control" name="hotel_centr_color" value="' + data['hotel_centr_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel button background color:</label>' +
                    '<input type="color" class="form-control" name="hotel_btn_bg_color" value="' + data['hotel_btn_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Header font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color1" value="' + data['hotel_font_color1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Button font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color2" value="' + data['hotel_font_color2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Label font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color3" value="' + data['hotel_font_color3'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Header font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size1" value="' + data['hotel_font_size1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Button font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size2" value="' + data['hotel_font_size2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Label font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size3" value="' + data['hotel_font_size3'] + '">' +
                    '</div>' +
                    '<input type="hidden" class="form-control" name="template_id" value="' + data['template_id'] + '">' +
                    '<input type="hidden" class="form-control" name="template_type" value="' + data['template_type'] + '">' +
                    '<input type="hidden" class="form-control" name="hotel_id" value="' +  window.SEGMENT_3 + '">' +
                    '<input type="hidden" class="form-control" name="form_language" value="' + window.ACTIVE_LANGUAGES[0]['name'] + '">' +
                    '<button type="submit" class="btn btn-info">Submit</button>' +
                    '<button type="button" class="btn btn-info" id="close_template_edit" style="margin-left: 10px">Close</button>' +
                '</form>' +
            '</div>';

        return edit_form;
    }

    function generateTemplateFacebookEdit(data)
    {
        var language_tabs = generateLanguageTabs();

        var edit_form =
            '<div class="col-md-12">' +
                '<div style="margin: 10px 0px;">' +
                    language_tabs +
                '</div>' +
                '<form id="template_update" role="form" enctype="multipart/form-data">' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel header text:</label>' +
                    '<input type="text" class="form-control" name="title" value="' + data['title'] + '">' +
                    '</div>' +
//                    '<div class="form-group">' +
//                    '<label for="pwd">Hotel Facebook button text:</label>' +
//                    '<input type="text" class="form-control" name="fb_title" value="' + data['fb_title'] + '">' +
//                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel devider text:</label>' +
                    '<input type="text" class="form-control" name="middle_title" value="' + data['middle_title'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel email field placeholder:</label>' +
                    '<input type="text" class="form-control" name="email_title" value="' + data['email_title'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background image:</label>' +
                    '<img src="/assets/variables/' + data['hotel_bg_image'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_bg_image" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel logo:</label>' +
                    '<img src="/assets/variables/' + data['hotel_logo'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_logo" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background color:</label>' +
                    '<input type="color" class="form-control" name="hotel_bg_color" value="' + data['hotel_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel central part color:</label>' +
                    '<input type="color" class="form-control" name="hotel_centr_color" value="' + data['hotel_centr_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel button background color:</label>' +
                    '<input type="color" class="form-control" name="hotel_btn_bg_color" value="' + data['hotel_btn_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Title font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color1" value="' + data['hotel_font_color1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Facebook button font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color2" value="' + data['hotel_font_color2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Delimiter font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color3" value="' + data['hotel_font_color3'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Title font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size1" value="' + data['hotel_font_size1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Facebook button font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size2" value="' + data['hotel_font_size2'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Delimiter font color size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size3" value="' + data['hotel_font_size3'] + '">' +
                    '</div>' +
                    '<input type="hidden" class="form-control" name="template_id" value="' + data['template_id'] + '">' +
                    '<input type="hidden" class="form-control" name="template_type" value="' + data['template_type'] + '">' +
                    '<input type="hidden" class="form-control" name="hotel_id" value="' +  window.SEGMENT_3 + '">' +
                    '<input type="hidden" class="form-control" name="form_language" value="' + window.ACTIVE_LANGUAGES[0]['name'] + '">' +
                    '<button type="submit" class="btn btn-info">Submit</button>' +
                    '<button type="button" class="btn btn-info" id="close_template_edit" style="margin-left: 10px">Close</button>' +
                '</form>' +
            '</div>';

        return edit_form;
    }

    function generateIconSetsDropDown(data)
    {
        var icons_list = '';

        $.each(window.icon_sets, function(index, value){
            if(data['icon_set_id'] == value['id']) {
                icons_list += '<option value="'+ value['id'] +'" selected>'+ value['name'] +'</option>';
            } else {
                icons_list += '<option value="'+ value['id'] +'">'+ value['name'] +'</option>';
            }
        });

        return icons_list;
    }

    function generateTemplateQuestionEdit(data)
    {
        var questions_list = generateDataTableQuestions(data['questions_list'], data['icons']);
        var language_tabs  = generateLanguageTabs();

        var edit_form =
            '<div class="col-md-12">' +
                '<div style="margin: 10px 0px;">' +
                    language_tabs +
                '</div>' +
                '<form id="template_update" role="form" enctype="multipart/form-data">' +
                    '<div class="form-group">' +
                    '<label for="pwd">Question:</label>' +
                    questions_list +
                    '<input id="new_question_text" type="text" class="form-control" style="margin: 5px auto" placeholder="Write your new question">' +
                    '<button onclick="addNewQuestion(' + window.SEGMENT_3 + ')" ' +
                    'type="button"style="margin-bottom: 5px auto" class="btn btn-info" title="Add new question">Add</button>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background image:</label>' +
                    '<img src="/assets/variables/' + data['hotel_bg_image'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_bg_image" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel logo:</label>' +
                    '<img src="/assets/variables/' + data['hotel_logo'] + '" class="img-thumbnail" style="display: block; margin: 5px 0px;" alt="Cinque Terre" width="150" height="150">' +
                    '<input type="file" class="form-control" name="hotel_logo" value="">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="sel1">Icons list:</label>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Question label:</label>' +
                    '<input type="text" class="form-control" name="translate_question_label" value="' + data['translate_question_label'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel background color:</label>' +
                    '<input type="color" class="form-control" name="hotel_bg_color" value="' + data['hotel_bg_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Hotel central part color:</label>' +
                    '<input type="color" class="form-control" name="hotel_centr_color" value="' + data['hotel_centr_color'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Header font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color1" value="' + data['hotel_font_color1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Label font color:</label>' +
                    '<input type="color" class="form-control" name="hotel_font_color3" value="' + data['hotel_font_color3'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Header font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size1" value="' + data['hotel_font_size1'] + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label for="pwd">Label font size:</label>' +
                    '<input type="number" class="form-control" name="hotel_font_size3" value="' + data['hotel_font_size3'] + '">' +
                    '</div>' +
                    '<input type="hidden" class="form-control" name="template_id" value="' + data['template_id'] + '">' +
                    '<input type="hidden" class="form-control" name="template_type" value="' + data['template_type'] + '">' +
                    '<input type="hidden" class="form-control" name="hotel_id" value="' +  window.SEGMENT_3 + '">' +
                    '<input type="hidden" class="form-control" name="form_language" value="' + window.ACTIVE_LANGUAGES[0]['name'] + '">' +
                    '<button type="submit" class="btn btn-info">Submit</button>' +
                    '<button type="button" class="btn btn-info" id="close_template_edit" style="margin-left: 10px">Close</button>' +
                '</form>' +
            '</div>';

        return edit_form;
    }

    function generateLanguageTabs()
    {
        var tabs = '<ul class="nav nav-tabs">';
        var active_class = 'active';

        window.ACTIVE_LANGUAGES.forEach(function(entry){

            tabs += '<li data-name="'+ entry['name'] +'" style="cursor: pointer" class="language_tabs_item '+ active_class +'"><a>'+ entry['name'] +'</a></li>';
            active_class = '';
        });

        tabs += '<ul>';

        return tabs;
    }

    function addClickOnLanguageTabItem()
    {
        // Set default current language is English
        window.CURRENT_LANGUAGE = 'English';

        $('.language_tabs_item').on('click', function(){
            $('.language_tabs_item').removeClass('active');
            $(this).addClass('active');

            // Save chosen language name in hidden input for saving text in db
            window.CURRENT_LANGUAGE = $(this).data('name')

            // Get template type
            var template_type = $('input[name="template_type"]').val();

            $('input[name="form_language"]').val(window.CURRENT_LANGUAGE);

            // Get translates for chosen language
            $.ajax({
                type: 'POST',
                url: '/index.php/admin/main/getTranslate',
                dataType: 'json',
                data: {hotel_id: window.SEGMENT_3, language: window.CURRENT_LANGUAGE, template_type: template_type},
                success: function (response) {
                    if (response) {
                        changeTranslates(response, template_type);
                        flashMsg('Translates successfully taken!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (request) {
                    flashMsg(request.responseText, 'danger');
                }
            });
        });
    }

    function getIconSets()
    {

    }

    function changeTranslates(data, template_type)
    {
        if(template_type == 'Question template')
        {
            $('input[name="translate_question_label"]').val(data['translate_question_label']);
            delete data['translate_question_label'];

            $.each(data, function(index, value){
                $('#questions_table tbody tr:eq('+ index +')').find('textarea').val(value['text']);
            });
        }
        else
        {
            $('input[name="hotel_label_1"]').val(data['hotel_label_1']);
            $('input[name="hotel_label_2"]').val(data['hotel_label_2']);
            $('input[name="hotel_btn_label"]').val(data['hotel_btn_label']);
        }
    }

    function addNewQuestion(hotel_id) {
        var text = $('#new_question_text').val();

        if (text.length < 10)
            return;

        var question_id = $('#questions_table tbody tr:last').attr('data-questionid'); + 1;

        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/addNewQuestion',
            dataType: 'json',
            data: {hotel_id: hotel_id, text: text, language: window.CURRENT_LANGUAGE},
            success: function (response) {
                if (response) {

                    var new_question =
                        '<tr data-questionid="' + question_id + '">' +
                            '<td>' +
                                '<input type="radio" class="questions_item" ' +
                                'name="question_radio" ' +
                                'onchange="setHotelActiveQuestion(' + hotel_id + ',' + question_id + ', \'' + text + '\')" >' +
                            '</td>' +
                            '<td>' +
                                '<textarea data-questionid="' + question_id + '" style="width: 100%; resize: none;" rows="2">' + text + '</textarea></td>' +
                            '<td>' +
                                '<p data-placement="top" data-toggle="tooltip" title="Edit">' +
                                    '<button type="button" class="btn btn-primary btn-xs" onclick="editHotelQuestion(' + question_id + ')" data-title="Edit">' +
                                        '<span class="glyphicon glyphicon-pencil"></span>' +
                                    '</button>' +
                                '</p>' +
                            '</td>' +
                            '<td>' +
                                '<p data-placement="top" data-toggle="tooltip" title="Delete">' +
                                    '<button type="button" class="btn btn-danger btn-xs" onclick="deleteHotelQuestion(' + question_id + ')" data-title="Delete" >' +
                                        '<span class="glyphicon glyphicon-trash"></span>' +
                                    '</button>' +
                                '</p>' +
                            '</td>' +
                        '<td>' +
                            '<select class="icon_set_select" data-question_id="'+ question_id +'">';

                            var icon_set_select = '';

                            response.forEach(function(entry)  {
                                if(entry['default'] == '1') {
                                    icon_set_select += '<option value="'+ entry['id'] +'" selected>'+ entry['name'] +'</option>';
                                } else {
                                    icon_set_select += '<option value="'+ entry['id'] +'">'+ entry['name'] +'</option>';
                                }
                            });

                    new_question += icon_set_select;
                    new_question +=
                                '</select>' +
                            '</td>' +
                        '</tr>';


                    $("#questions_table tbody").append(new_question);
                    flashMsg('Question successfully added!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function deleteHotelQuestion(question_id) {
        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/deleteHotelQuestion',
            data: {question_id: question_id},
            success: function (response) {
                if (response) {
                    $('#questions_table tbody tr[data-questionid=' + question_id + ']').remove();
                    flashMsg('Question successfully deleted!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function editHotelQuestion(question_id) {
        var text = $('#questions_table textarea[data-questionid=' + question_id + ']').val();

        if (text.length < 10)
            return;

        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/editHotelQuestion',
            data: {question_id: question_id, text: text, hotel_id: window.SEGMENT_3, language: window.CURRENT_LANGUAGE},
            success: function (response) {
                if (response) {
                    flashMsg('Question successfully updated!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });

    }

    function generateDataTableQuestions(data, icons) {

        var table =
            '<div class="table-responsive">' +
                '<table id="questions_table" class="table table-bordred table-striped">' +
                    '<thead>' +
                        '<th>Set first</th>' +
                        '<th>Question</th>' +
                        '<th>Edit</th>' +
                        '<th>Delete</th>' +
                        '<th>Set Icon Set</th>' +
                    '</thead>' +
                    '<tbody>';
        for (var key in data) {
            if (data[key]['is_first'] == 1) {
                var is_first = 'checked';
            } else {
                var is_first = '';
            }
            table +=
                '<tr data-questionid="' + data[key]['question_id'] +'"data-icon_set_id="'+ data[key]['icon_set_id'] +'">' +
                    '<td>' +
                        '<input type="radio" class="questions_item" ' +
                        'name="question_radio" ' +
                        'onchange="setHotelActiveQuestion(' + window.SEGMENT_3 + ',' + data[key]['question_id'] + ', \'' + data[key]['text'] + '\')" ' + is_first + '>' +
                    '</td>' +
                    '<td>' +
                        '<textarea data-questionid="' + data[key]['question_id'] + '" style="width: 100%; resize: none;" rows="2">' + data[key]['text'] + '</textarea>' +
                    '</td>' +
                    '<td>' +
                        '<p data-placement="top" data-toggle="tooltip" title="Edit">' +
                            '<button type="button" class="btn btn-primary btn-xs" onclick="editHotelQuestion(' + data[key]['question_id'] + ')" data-title="Edit">' +
                                '<span class="glyphicon glyphicon-pencil"></span>' +
                            '</button>' +
                        '</p>' +
                    '</td>' +
                    '<td>' +
                        '<p data-placement="top" data-toggle="tooltip" title="Delete">' +
                            '<button type="button" class="btn btn-danger btn-xs" onclick="deleteHotelQuestion(' + data[key]['question_id'] + ')" data-title="Delete" >' +
                                '<span class="glyphicon glyphicon-trash"></span>' +
                            '</button>' +
                        '</p>' +
                    '</td>' +
                    '<td>' +
                        '<select class="icon_set_select" data-question_id="'+ data[key]['question_id'] +'">';

                            var icon_set_select = '';
                            icons.forEach(function(entry)  {
                                if(entry['id'] == data[key]['icon_set_id']) {
                                    icon_set_select += '<option value="'+ entry['id'] +'" selected>'+ entry['name'] +'</option>';
                                } else {
                                    icon_set_select += '<option value="'+ entry['id'] +'">'+ entry['name'] +'</option>';
                                }
                            });

                    table += icon_set_select;
                    table +=
                        '</select>' +
                    '</td>' +
                '</tr>';
        }

        table +=
            '</tbody>' +
            '</table>' +
            '</div>';

        return table;
    }

    function getHotelsTable() {
        return $('th div:contains("Hotel ID")').parent().parent().parent().parent();
    }

    /**
     * Count from 0 ...
     *
     * @param table
     * @returns {*}
     */
    function findHotelIDColumnNumber(table) {
        var th = $(table).find('th div[rel="id"]').parent();

        var number = th.parent().children().index(th);

        return number;
    }

    /**
     * Count from 0 ...
     *
     * @param table
     * @returns {*}
     */
    function findTemplatesColumnNumber(table) {
        var th = $(table).find('th div[rel="Active template"]').parent();

        var number = th.parent().children().index(th);

        return number;
    }

    function getHotelsID(table, number) {
        var ids = [];

        table.find('tbody tr').each(function (index, element) {
            ids.push($(element).find('td:nth-child(' + number + 1 + ')').find('div').text());
        })

        return ids;
    }

    function generateFlushMacAddress()
    {
        if ($('.form-field-box:last').hasClass('even')) {
            var even = 'odd';
        } else {
            var even = 'even';
        }

        var router_id = $('input[name="nasname"]').val();

        var button =
            '<div style="height:40px; margin-top:15px;" class="form-field-box ' + even + '" id="flush_macaddress_row">' +
                '<div class="form-display-as-box">' +
                    'Flush Mac Address :' +
                '</div>' +
                '<div class="form-input-box" id="hotel_id_input_box">' +
                '<button class="btn btn-danger flush_macaddress" data-routerid="'+ router_id +'" type="button">Flush</button>' +
                '</div>' +
            '</div>';

        $(button).insertAfter('.form-field-box:last');

        addClickOnFlushMacAddress();
    }

    function addClickOnFlushMacAddress()
    {
        $('.flush_macaddress').on('click', function(){

            var router_id = $(this).data('routerid');

            $.ajax({
                type: 'POST',
                url:  '/index.php/admin/main/flushMacAddress',
                data: {router_id: router_id},
                dataType: 'json',
                success: function (response) {
                    if(response)
                    {
                        flashMsg('Mac address successfully flushed!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (response) {
                    flashMsg(response.responseText, 'danger');
                }
            });
        });
    }

    function getAllLanguages(hotel_id) {
        $.ajax({
            type: 'POST',
            url:  "/index.php/admin/main/getAllLanguages",
            dataType: 'json',
            data: {hotel_id: hotel_id},
            success: function (response) {
                window.ACTIVE_LANGUAGES = response['active'];

                generateTermBlock(hotel_id, response);
                generateHotelLanguagesCheckBoxes(hotel_id, response);
                addHotelStatsButton(hotel_id);
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function generateHotelLanguagesCheckBoxes(hotel_id, languages) {

        if ($('.form-field-box:last').hasClass('even')) {
            var even = 'odd';
        } else {
            var even = 'even';
        }

        var language_list =
            '<div class="form-field-box ' + even + '" data-hotelid="' + hotel_id + '" style="overflow: hidden">' +
                '<div class="form-display-as-box">' +
                    'Choose Languages :' +
                '</div>' +
                '<div class="col-md-3">';

        language_list +=
            '<table class="table table-striped">' +
                '<thead>' +
                    '<tr>' +
                        '<th>Default</th>' +
                        '<th>Active</th>' +
                        '<th>Language</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>';

        var active_languages = [];
        languages['active'].forEach(function(entry) {
            active_languages.push(entry['language_id']);
        });

        var default_language = languages['default'];

        languages['all'].forEach(function(entry) {
            var active_checked = ''
            var disabled_attr = 'disabled'
            if($.inArray(entry['id'], active_languages) != -1) {
                active_checked = 'checked';
                disabled_attr = '';
            } else {
                active_checked = '';
                disabled_attr = 'disabled'
            }

            var default_checked = '';
            if(entry['id'] == default_language) {
                default_checked = 'checked';
            } else {
                default_checked = '';
            }

            language_list +=
                '<tr>' +
                    '<td><input class="language_default" '+ default_checked +' name="language_default" '+ disabled_attr +' type="radio" data-hotelid="'+ hotel_id +'" value="' + entry['id'] + '"></td>' +
                    '<td><input class="language_active"  '+ active_checked +'  type="checkbox" data-hotelid="'+ hotel_id +'" value="' + entry['id'] + '"></td>' +
                    '<td>' + entry['name'] + '</td>' +
                '</tr>';
        });

        language_list +=
                '</tbody>' +
            '</table>';

        language_list += '</div></div>';

        $(language_list).insertAfter('.form-field-box:last');

        addClickOnLanguageActive();
        addClickOnLanguageDefault();

    }

    function addClickOnLanguageActive()
    {
        $('.language_active').on('change', function() {
            var added_language = $(this);
            var hotel_id    = $(this).data('hotelid');
            var language_id = $(this).val();

            if($(this).is(':checked')) {
                addActiveLanguage(hotel_id, language_id, added_language);
            } else {
                removeActiveLanguage(hotel_id, language_id);
            }


        });
    }

    function addClickOnLanguageDefault()
    {
        $('.language_default').on('change', function() {

            var hotel_id    = $(this).data('hotelid');
            var language_id = $(this).val();

            changeDefaultLanguage(hotel_id, language_id);
        });
    }

    function addActiveLanguage(hotel_id, language_id, added_language)
    {
        $.ajax({
            type: 'POST',
            url:  "/index.php/admin/main/addActiveLanguage",
            dataType: 'json',
            data: {hotel_id: hotel_id, language_id: language_id},
            success: function (response) {
                if(response) {
                    flashMsg('Active language successfully added!', 'success');
                    $(added_language).parent().parent().find('.language_default').attr('disabled', false);
                    location.reload();
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function removeActiveLanguage(hotel_id, language_id)
    {
        $.ajax({
            type: 'POST',
            url:  "/index.php/admin/main/removeActiveLanguage",
            dataType: 'json',
            data: {hotel_id: hotel_id, language_id: language_id},
            success: function (response) {
                if(response) {
                    flashMsg('Active language successfully removed!', 'success');
                    location.reload();
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }


    function setDefaultLanguage(hotel_id, language_id)
    {
        $.ajax({
            type: 'POST',
            url:  "/index.php/admin/main/setDefaultLanguage",
            dataType: 'json',
            data: {hotel_id: hotel_id, language_id: language_id},
            success: function (response) {
                if(response) {
                    flashMsg('Default language successfully added!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function changeDefaultLanguage(hotel_id, language_id)
    {
        $.ajax({
            type: 'POST',
            url:  "/index.php/admin/main/changeDefaultLanguage",
            dataType: 'json',
            data: {hotel_id: hotel_id, language_id: language_id},
            success: function (response) {
                if(response) {
                    flashMsg('Default language successfully changed!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    function generateTermBlock(hotel_id, response)
    {
        if ($('.form-field-box:last').hasClass('even')) {
            var even = 'odd';
        } else {
            var even = 'even';
        }

        var dropdown_li = '';

        window.ACTIVE_LANGUAGES.forEach(function(entry){

            dropdown_li += '<li data-name="'+ entry['name'] +'" data-language_id="'+ entry['language_id'] +'"' +
                                'style="cursor: pointer;"' +
                                'class="term_language_li"><a>'+ entry['name'] +'</a>' +
                            '</li>';
        });

        var dropdown =
            '<div style="height: 255px;" class="form-field-box ' + even + '" data-hotelid="' + hotel_id + '">' +
                '<div class="form-display-as-box">' +
                    'Edit terms :' +
                '</div>' +
                '<div class="col-md-3">'+
                    '<div style="margin-bottom: 5px;">'+
                        '<span>Title: </span>'+
                        '<input type="text" id="term_title" style="width: 200px;" value="'+ response['terms']['title'] +'">' +
                    '</div>'+
                    '<div style="margin-bottom: 5px;">'+
                        '<span>Text: </span>'+
                        '<textarea type="text" id="term_text" style="width: 200px; height: 150px; resize: none;">'+ response['terms']['text'] +'</textarea>' +
                    '</div>'+
                    '<div class="dropdown" style="margin-left: 36px; margin-bottom: 5px;">' +
                        '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">' +
                        '<span class="term_language_title" language_id="1">English</span>'+
                        '<span class="caret" style="margin-top: -2px; margin-left: 7px"></span></button>'+
                        '<ul class="dropdown-menu">'+
                            dropdown_li +
                        '</ul>'+
                    '</div>' +
                        '<button type="button" id="term_edit" style="width:78px; margin-left: 36px;" class="btn btn-success">Edit</button>'+
                '</div>' +
            '</div>';

        $(dropdown).insertAfter('.form-field-box:last');

        termDropDownAction();
        termEditAction();
    }

    function termDropDownAction()
    {
        $('.term_language_li').on('click', function(){
            var language_id = $(this).data('language_id');
            var chosen_lang = $(this).data('name');
            $.ajax({
                type: 'post',
                url: '/index.php/admin/main/getTerm',
                dataType: 'json',
                data: {language_id: language_id},
                success: function (response) {
                    if(response) {
                        if(response.length == 0) {
                            $('#term_title').val('');
                            $('#term_text').val('');
                        } else {
                            $('#term_title').val(response['title']);
                            $('#term_text').val(response['text']);
                        }
                        $('.term_language_title').text(chosen_lang);
                        $('.term_language_title').attr('language_id', language_id);
                    }
                },
                error: function (request) {
//                    flashMsg(request.responseText, 'danger');
                }
            });
        });
    }

    function termEditAction()
    {
        $('#term_edit').on('click', function() {
            var language_id = $('.term_language_title').attr('language_id');
            var title = $('#term_title').val();
            var text = $('#term_text').val();

            $.ajax({
                type: 'post',
                url: '/index.php/admin/main/editTerm',
                dataType: 'json',
                data: {
                    language_id: language_id,
                    title: title,
                    text: text
                },
                success: function (response) {
                    if (response) {
                        console.log(response)
                    }
                },
                error: function (request) {
//                    flashMsg(request.responseText, 'danger');
                }
            });
        });
    }

    // Generate radio_btns template list for editing variables
    function generateHotelTemplatesRadioBtn(hotel_id, templates)
    {
        $("input[name='hotel_id']").remove();

        if ($('.form-field-box:last').hasClass('even')) {
            var even = 'odd';
        } else {
            var even = 'even';
        }

        delete templates['active_template_id'];

        var dropdown =
            '<div class="form-field-box ' + even + '" data-hotelid="' + hotel_id + '" style="overflow: hidden">' +
                '<div class="form-display-as-box">' +
                    'Edit template :' +
                '</div>' +
                '<div class="col-md-3">';
        for (var key in templates) {
            dropdown += '<div class="radio"> <label><input type="radio" class="template_item" data-name="'+templates[key]+'" name="optradio" data-templateid="' + key + '">' + templates[key] + '</label> </div>';
        }

        dropdown += '</div></div>';

        $(dropdown).insertAfter('.form-field-box:last');

        addTemplatesRadioBtnClicks();
    }

    function addTemplatesRadioBtnClicks() {
        $('.template_item').on('change', function () {

            //should send template id
            var template_id = $(this).data('templateid');
            //should send hotel id
            var hotel_id = $(this).parent().parent().parent().parent().data('hotelid');

            getTemplateVariables(hotel_id, template_id);

            if (!$("#template_edit").hasClass("show_edit_template")) {
                $("#template_edit").addClass("show_edit_template");
            }
        });
    }

    function addHotelStatsButton(hotel_id) {
        if ($('.form-field-box:last').hasClass('even')) {
            var even = 'odd';
        } else {
            var even = 'even';
        }

        var statsBtn =
            '<div class="form-field-box ' + even + '" data-hotelid="' + hotel_id + '" style="overflow: hidden">' +
                '<div class="" style="width: 200px; float: left;">' +
                    'Open Hotel Statistics :' +
                '</div>' +
                '<div class="" style="width: 200px; float: left;">' +
                    '<button id="hotel_stats_btn" type="button" class="btn btn-info">Hotel Stats</button>' +
                '</div>' +
                '<div class="" style="width: 200px; float: left;">' +
                    'Open Hotel Mails :' +
                '</div>' +
                '<div class="" style="width: 200px; float: left;">' +
                    '<button id="hotel_emails_btn" type="button" class="btn btn-info">Hotel Mails</button>' +
                '</div>' +
            '</div>';

        $(statsBtn).insertAfter('.form-field-box:last');

        addHotelStatsButtonClick();
    }

    function addHotelStatsButtonClick() {
        $('#hotel_stats_btn').on('click', function () {

            //should send hotel id
            var hotel_id = $(this).parent().parent().data('hotelid');

            getHotelQuestionsStats(hotel_id);
        })

        $('#hotel_emails_btn').on('click', function () {

            //should send hotel id
            var hotel_id = $(this).parent().parent().data('hotelid');

            getHotelEmailsList(hotel_id);
        })
    }

    function getHotelQuestionsStats(hotel_id) {
        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/getHotelQuestionsStats',
            dataType: 'json',
            data: {hotel_id: hotel_id},
            success: function (response) {
                console.log(response);

                $("#hotel_statistics").show();
                $("#hotel_statistics").empty();

                var texts = response['texts'];
                delete response['texts'];

                for (var question_id in response) {
                    console.log(question_id);
                    var data = [0, 0, 0];
                    data[0] += response[question_id]['-1']; //negative responses
                    data[1] += response[question_id]['0'];  //neutral  responses
                    data[2] += response[question_id]['1'];  //positive responses


                    var x = d3.scale.linear()
                        .domain([0, d3.max(data)])
                        .range([0, 300]);



                    d3.select("#hotel_statistics")
                        .append("div")
                        .append("p")
                        .attr("class", "question-name")
                        .html("Question ID: " + question_id + " " + texts[question_id])
                        .select(function () {
                            return this.parentNode;
                        })
                        .append("p")
                        .append("span")
                        .attr("class", "chart-name")
                        .html("Negative")
                        .select(function () {
                            return this.parentNode;
                        })
                        .append("span")
                        .attr("class", "chart-name")
                        .html("Neutral")
                        .select(function () {
                            return this.parentNode;
                        })
                        .append("span")
                        .attr("class", "chart-name")
                        .html("Positive")
                        .select(function () {
                            return this.parentNode;
                        })
                        .select(function () {
                            return this.parentNode;
                        })
                        .selectAll("div")
                        .data(data)
                        .enter().append("div")
                        .attr("class", "bar")
                        .style("height", function (d) {
                            return x(d) + "px";
                        })
                        .append("span")
                        .text(function (d) {
                            return d;
                        });
                }


            }
        });
    }

    function getHotelEmailsList(hotel_id) {
        $.ajax({
            type: 'POST',
            url: '/index.php/admin/main/getHotelEmailsList',
            dataType: 'json',
            data: {hotel_id: hotel_id},
            success: function (response) {
                showHotelEmailsList(response, hotel_id);
            }
        });
    }

    function showHotelEmailsList(emails_list, hotel_id) {

        list_header =
            '<table class="table table-striped" id="emails-list-table">' +
                '<thead>' +
                    '<tr>' +
                        '<th>Email</th>' +
                        '<th>Created_at</th>' +
                        '<th>Updated_at</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>';

        var list_body = '';
        emails_list.forEach(function(entry) {
            list_body +=
                '<tr>' +
                    '<td>'+ entry['email'] +'</td>' +
                    '<td>'+ entry['created_at'] +'</td>' +
                    '<td>'+ entry['updated_at'] +'</td>' +
                '</tr>';
        });

         list_footer =
                '</tbody>' +
            '</table>' +
            '<fieldset class="form-group col-md-3">' +
                '<label for="exampleSelect1">From date</label>' +
                '<input type="date" name="dateFrom" class="form-control" id="dateFrom">' +
            '</fieldset>'+
            '<fieldset class="form-group col-md-3">' +
                '<label for="exampleSelect1">To date</label>' +
                '<input type="date" name="dateTo" class="form-control" id="dateTo">' +
            '</fieldset>' +
            '<fieldset class="form-group col-md-3">' +
                '<label for="exampleSelect1">Update list</label>' +
                '<button class="form-control btn btn-info" id="updateEmailsList">Update</button>' +
            '</fieldset>'+
            '<fieldset class="form-group col-md-3">' +
                '<label for="exampleSelect1">Show next 50th</label>' +
                '<button class="form-control btn btn-info" id="showNextEmails">Next</button>' +
                '<input type="hidden" id="offset" hotel_id="'+ hotel_id +'" limit="50" offset="50">' +
            '</fieldset>';

        var result = list_header + list_body + list_footer;

        $("#hotel_emails").empty().append(result).show();

        $('#updateEmailsList').on('click', function(){
            var date = new Date(document.getElementById('dateFrom').value).getTime()/1000;
            var to   = new Date(document.getElementById('dateTo').value).getTime()/1000;

            $.ajax({
                type: 'POST',
                url: '/index.php/admin/main/getHotelEmailsListRanged',
                dataType: 'json',
                data: {
                    hotel_id: hotel_id,
                    from: date,
                    to: to
                },
                success: function (response) {
                    showHotelEmailsList(response);
                }
            });

        });

        $('#showNextEmails').on('click', function () {
            var limit    = parseInt($('#offset').attr('limit'));
            var offset   = parseInt($('#offset').attr('offset'));
            var hotel_id = parseInt($('#offset').attr('hotel_id'));

            var data = {};
            data.limit    = limit;
            data.offset   = offset;
            data.hotel_id = hotel_id;

            $.post('/index.php/admin/main/getHotelEmailsListPaginated', data, function(response) {
                console.log(response);

                var emails = '';
                $.each(response, function(index, value) {
                    emails +=
                        '<tr>' +
                        '<td>'+ value.email +'</td>' +
                        '<td>'+ value.created_at +'</td>' +
                        '<td>'+ value.updated_at +'</td>' +
                        '</tr>';
                });

                $('#emails-list-table tbody').html(emails);

                $('#offset').attr('offset', offset+limit);

            }, 'json');
        })
    }

    //setHotelActiveQuestion from drop down list of all questions
    function setHotelActiveQuestion(hotel_id, question_id, text) {

        //Set choosen template text in dropdown header
        $(".dropdown.open button").html(text + '<span style="margin: 0px 4px 1px;" class="caret"></span>');

        $.ajax({
            type: "POST",
            url: "/index.php/admin/main/setHotelActiveQuestion",
            dataType: "json",
            data: {hotel_id: hotel_id, question_id: question_id},
            success: function (response) {
                if(response) {
                    flashMsg('First question successfully set!', 'success');
                } else {
                    flashMsg('Some error occurred!', 'danger');
                }
            },
            error: function (request) {
                flashMsg(request.responseText, 'danger');
            }
        });
    }

    //setHotelActiveTemplate from radio buttons list
    function addActiveTemplatesRadioBtnClicks() {
        $('.template_item_active').on('change', function () {

            //should send template id
            var template_id = $(this).data('templateid');

            //should send hotel id
            var hotel_id = $(this).parent().parent().parent().data('hotelid');

            $.ajax({
                type: "POST",
                url: "/index.php/admin/main/setHotelActiveTemplate",
                dataType: "json",
                data: {hotel_id: hotel_id, template_id: template_id},
                success: function (response) {
                    if(response) {
                        flashMsg('Active template successfully set!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (request) {
                    flashMsg(request.responseText, 'danger');
                }
            });

        });
    }

    function getHotelActiveTemplateName(templates) {
        var dropdown_title = 'No active template';

        if (templates) {
            var active_template_id = templates[0];

            dropdown_title = templates[active_template_id];

            delete templates[0];
        }

        return dropdown_title;
    }

    // Generate radio_btns template list for setting active template
    function generateHotelTemplatesActiveRadioBtn(hotel_id, templates) {
        // Delete basic row from Grocery UI and add custom row with radio buttons
        $('#active_template_id_field_box').empty();
        $('#active_template_id_field_box').css('overflow', 'hidden');

        var active_template_id = parseInt(templates['active_template_id']);
        delete templates['active_template_id'];

        var dropdown =
            '<div class="form-display-as-box" id="active_template_id_display_as_box">' +
            'Set active template :' +
            '</div>' +
            '<div class="col-md-3" data-hotelid="' + hotel_id + '">';

        for (var key in templates) {
            if (key == active_template_id) {
                dropdown += '<div class="radio"> <label><input checked type="radio" class="template_item_active" name="active_template" data-templateid="' + key + '">' + templates[key] + '</label> </div>';
            } else {
                dropdown += '<div class="radio"> <label><input type="radio" class="template_item_active" name="active_template" data-templateid="' + key + '">' + templates[key] + '</label> </div>';
            }

        }

        dropdown += '</div></div>';

        $('#active_template_id_field_box').html(dropdown);

        addActiveTemplatesRadioBtnClicks();
    }

    function runOverTemplates(table, templates_number, hotel_ids) {
        table.find('tbody tr').each(function (index, element) {

            var active_template_name = getHotelActiveTemplateName(window.allHotelsAndTemplates[hotel_ids[index]]);

            $(element).find('td:nth-child(' + (templates_number + 1) + ')').css('overflow', 'visible').find('div').text(active_template_name);
        });
    }

    function flashMsg(text, type) {
        var alert_type;

        switch (type) {
            case 'success':
                alert_type = 'alert-success';
                break;
            case 'danger':
                alert_type = 'alert-danger';
                break;
        }

        $("#myAlert").html(text).removeClass('alert-danger').removeClass('alert-success').addClass(alert_type).addClass("in");
        setTimeout(function () {
            $("#myAlert").removeClass("in");
        }, 3000);
    }


</script>
</body>
</html>
