<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>

    <link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css">
    <title>Edit defaults</title>

    <script src="/assets/js/jquery-1.10.2.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

</head>
<body>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li>
                <a href='<?php echo site_url('admin/main/hotels') ?>'>Back</a>
            </li>
            <li>
                <a href='<?php echo site_url('admin/main/defaults') ?>'>Edit template defaults</a>
            </li>
            <li class="active">
                <a href='<?php echo site_url('admin/main/icons') ?>'>Edit icon sets</a>
            </li>
        </ul>
    </div>

    <div id="myAlert" class="alert fade" data-alert="alert">This is the alert.</div>

    <div class="col-lg-6">
        <div class="col-lg-12">
            <h3 class="page-header">Add new Icon Set</h3>
        </div>

        <?php

            $icon_set_name = '';
            $icon_set_id   = '';
            $icon_1 = 'undefined.png';
            $icon_2 = 'undefined.png';
            $icon_3 = 'undefined.png';

            $submit_btn_text = "Add";

            $required = 'required';

            if(isset($_POST['icon_set_id']))
            {
                $icon_set_id   = $_POST['icon_set_id'];
                $icon_set_name = $_POST['icon_set_name'];
                $icon_1 = $_POST['icon_1'];
                $icon_2 = $_POST['icon_2'];
                $icon_3 = $_POST['icon_3'];

                $submit_btn_text = "Edit";

                $required = '';

                unset($_POST['icon_set_id']);
                unset($_POST['icon_1']);
                unset($_POST['icon_2']);
                unset($_POST['icon_3']);
            }
        ?>
        <form role="form" action="/index.php/admin/main/setIcons" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="icon_set_name">Icon set name:</label>
                <input type="text" class="form-control" id="icon_set_name" name="name" value="<?=$icon_set_name?>" <?=$required?>>
                <?php  if($submit_btn_text == "Edit"): ?>
                    <input type="hidden" name="icon_set_id" value="<?=$icon_set_id?>">
                <?php  endif; ?>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6 thumb">
                <a class="thumbnail" href="#">
                    <img class="img-responsive" src="/assets/variables/<?=$icon_1?>" alt="">
                </a>
                <input type="file" class="form-control" id="icon_1" name="icon_1" value="" <?=$required?>>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6 thumb">
                <a class="thumbnail" href="#">
                    <img class="img-responsive" src="/assets/variables/<?=$icon_2?>" alt="">
                </a>
                <input type="file" class="form-control" id="icon_2" name="icon_2" value="" <?=$required?>>
            </div>

            <div class="col-lg-4 col-md-4 col-xs-6 thumb">
                <a class="thumbnail" href="#">
                    <img class="img-responsive" src="/assets/variables/<?=$icon_3?>" alt="">
                </a>
                <input type="file" class="form-control" id="icon_3" name="icon_3" value="" <?=$required?>>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-default" style="margin: 20px 0px;"><?=$submit_btn_text?></button>
            </div>

        </form>

        <div class="col-lg-12">
            <h3 class="page-header">Uploaded sets</h3>
        </div>

        <div class="col-lg-12" style="height: 400px; overflow: scroll;">
            <?php foreach($icons as $key => $value) { ?>
                <div class="row" style="margin-bottom: 15px; padding-bottom: 5px; border-bottom: 1px solid rgba(128, 128, 128, 0.27);">
                    <form action="/index.php/admin/main/icons" method="post">
                        <div class="form-group">
                            <label for="question_text">Icon set name: <?=$value['name']?></label>
                            <input type="hidden" name="icon_set_name" value="<?=$value['name']?>">
                            <input type="hidden" name="icon_set_id" value="<?=$value['id']?>">
                        </div>

                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="#">
                                <img class="img-responsive" style="width: 80px; height: 80px;" src="/assets/variables/<?=$value['icon_1']?>" alt="">
                                <input type="hidden" name="icon_1" value="<?=$value['icon_1']?>">
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="#">
                                <img class="img-responsive" style="width: 80px; height: 80px;" src="/assets/variables/<?=$value['icon_2']?>" alt="">
                                <input type="hidden" name="icon_2" value="<?=$value['icon_2']?>">
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a class="thumbnail" href="#">
                                <img class="img-responsive" style="width: 80px; height: 80px;" src="/assets/variables/<?=$value['icon_3']?>" alt="">
                                <input type="hidden" name="icon_3" value="<?=$value['icon_3']?>">
                            </a>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-info">Edit</button>
                            <button type="button" class="btn btn-danger delete_icon_set">Delete</button>
                            <label style="margin-left: 3px;">
                                Set as default
                                <?php $is_default = ($value['default'] == 1)?'checked':''; ?>
                                <input class="icon_set_radio" style="margin: 3px 10px;" <?=$is_default?> data-icon-set-id="<?=$value['id']?>" type="radio" name="icon_set_radio">
                            </label>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>

    </div>

<script>
    $(document).on('ready', function(){

        $('.delete_icon_set').on('click', function(){
            var icon_set_id = $('input[name="icon_set_id"]').val();

            $.ajax({
                type: 'POST',
                url: '/index.php/admin/main/deleteIconSet',
                dataType: 'json',
                data: {icon_set_id: icon_set_id},
                success: function (response) {
                    if (response) {
                        flashMsg('Icon set successfully deleted!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (response) {
                    flashMsg(response.responseText, 'danger');
                }
            });
        });

        $('.icon_set_radio').on('change', function () {
            $('.icon_set_radio').prop('checked',false);
            $(this).prop('checked',true);
            var icon_set_id = $(this).data('icon-set-id');

            $.ajax({
                type: 'POST',
                url: '/index.php/admin/main/setIconSetDefault',
                dataType: 'json',
                data:{icon_set_id: icon_set_id},
                success: function (response) {
                    if (response) {
                        flashMsg('Default icon set successfully set!', 'success');
                    } else {
                        flashMsg('Some error occurred!', 'danger');
                    }
                },
                error: function (response) {
                    flashMsg(response.responseText, 'danger');
                }
            });

        })

    });

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