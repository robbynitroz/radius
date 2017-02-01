<html lang="en">
<head>
    <meta charset="utf-8"/>

    <link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css">
    <title>Edit defaults</title>

</head>
<body>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
        <li>
            <a href='<?php echo site_url('admin/main/hotels') ?>'>Back</a>
        </li>
        <li class="active">
            <a href='<?php echo site_url('admin/main/defaults') ?>'>Edit template defaults</a>
        </li>
        <li>
            <a href='<?php echo site_url('admin/main/icons') ?>'>Edit icon sets</a>
        </li>
    </ul>
</div>

<div class="col-md-4">

    <form role="form" action="/index.php/admin/main/setDefaults" method="post" enctype="multipart/form-data">

        <!-- Login Page -->
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <h4>Login page:</h4>
            </div>
        </div>

        <div class="form-group">
            <label for="login_header_text">Header Text:</label>
            <input type="text" class="form-control" id="login_header_text" name="login_header_text" value="<?=$login_header_text?>">
        </div>

        <div class="form-group">
            <label for="login_btn_text">Button Text:</label>
            <input type="text" class="form-control" id="login_btn_text" name="login_btn_text" value="<?=$login_btn_text?>">
        </div>

        <div class="form-group">
            <label for="login_btn_label">Footer Text:</label>
            <input type="text" class="form-control" id="login_btn_label" name="login_btn_label" value="<?=$login_btn_label?>">
        </div>

        <!-- Email Page -->
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <h4>Email page:</h4>
            </div>
        </div>

        <div class="form-group">
            <label for="email_header_text">Header Text:</label>
            <input type="text" class="form-control" id="email_header_text" name="email_header_text" value="<?=$email_header_text?>">
        </div>

        <div class="form-group">
            <label for="email_btn_text">Button Text:</label>
            <input type="text" class="form-control" id="email_btn_text" name="email_btn_text" value="<?=$email_btn_text?>">
        </div>

        <div class="form-group">
            <label for="email_placeholder_text">Button Placeholder Text:</label>
            <input type="text" class="form-control" id="email_placeholder_text" name="email_placeholder_text" value="<?=$email_placeholder_text?>">
        </div>

        <!-- Question Page -->
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <h4>Question page:</h4>
            </div>
        </div>

        <div class="form-group">
            <label for="question_text">Question Text:</label>
            <input type="text" class="form-control" id="question_text" name="question_text" value="<?=$question_text?>">
        </div>

        <div class="form-group">
            <label for="question_label">Question label:</label>
            <input type="text" class="form-control" id="question_label" name="question_label" value="<?=$question_label?>">
        </div>

        <!-- Terms Page -->
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <h4>Terms:</h4>
            </div>
        </div>

        <div class="form-group">
            <label for="term_title">Terms Title:</label>
            <input type="text" class="form-control" id="term_title" name="term_title" value="<?=$term_title?>">
        </div>

        <div class="form-group">
            <label for="term_text">Terms Text:</label>
            <input type="text" class="form-control" id="term_text" name="term_text" value="<?=$term_text?>">
        </div>

        <!-- Design Page -->
        <div class="row">
            <div class="col-md-4 col-md-offset-5">
                <h4>Design page:</h4>
            </div>
        </div>

        <div class="form-group">
            <label for="hotel_bg_image">Hotel background image:</label>
            <img src="/assets/variables/<?=$hotel_bg_image?>" class="img-thumbnail" style="display: block; margin: 5px 0px;" width="150" height="150">
            <input type="file" class="form-control" id="hotel_bg_image" name="hotel_bg_image" value="<?=$hotel_bg_image?>">
            <?php if(!empty($this->session->flashdata('hotel_bg_image'))):?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('hotel_bg_image'); ?>
            </div>
            <?php endif;?>
        </div>

        <div class="form-group">
            <label for="hotel_logo">Hotel logo image:</label>
            <img src="/assets/variables/<?=$hotel_logo?>" class="img-thumbnail" style="display: block; margin: 5px 0px;" width="150" height="150">
            <input type="file" class="form-control" id="hotel_logo" name="hotel_logo" value="<?=$hotel_logo?>">
            <?php if(!empty($this->session->flashdata('hotel_logo'))):?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('hotel_logo'); ?>
                </div>
            <?php endif;?>
        </div>

        <div class="form-group">
            <label for="hotel_bg_color">Hotel background color:</label>
            <input type="color" class="form-control" id="hotel_bg_color" name="hotel_bg_color" value="<?=$hotel_bg_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_center_color">Hotel central part background color:</label>
            <input type="color" class="form-control" id="hotel_center_color" name="hotel_center_color" value="<?=$hotel_center_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_btn_bg_color">Hotel button background color:</label>
            <input type="color" class="form-control" id="hotel_btn_bg_color" name="hotel_btn_bg_color" value="<?=$hotel_btn_bg_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_header_font_color">Header font color:</label>
            <input type="color" class="form-control" id="hotel_header_font_color" name="hotel_header_font_color" value="<?=$hotel_header_font_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_btn_font_color">Button font color:</label>
            <input type="color" class="form-control" id="hotel_btn_font_color" name="hotel_btn_font_color" value="<?=$hotel_btn_font_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_label_font_color">Label font color:</label>
            <input type="color" class="form-control" id="hotel_label_font_color" name="hotel_label_font_color" value="<?=$hotel_label_font_color?>">
        </div>

        <div class="form-group">
            <label for="hotel_header_font_size">Header font size:</label>
            <input type="number" class="form-control" id="hotel_header_font_size" name="hotel_header_font_size" value="<?=$hotel_header_font_size?>">
        </div>

        <div class="form-group">
            <label for="hotel_btn_font_size">Button font size:</label>
            <input type="number" class="form-control" id="hotel_btn_font_size" name="hotel_btn_font_size" value="<?=$hotel_btn_font_size?>">
        </div>

        <div class="form-group">
            <label for="hotel_label_font_size">Label font size:</label>
            <input type="number" class="form-control" id="hotel_label_font_size" name="hotel_label_font_size" value="<?=$hotel_label_font_size?>">
        </div>


        <button type="submit" class="btn btn-default">Submit</button>
    </form>

</div>

</body>
</html>