<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css">

<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
 
<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
</style>
</head>
<body>
<!-- Beginning header -->
    <!--<div>-->
    <!--    <a href='--><?php //echo site_url('admin/main/hotels')?><!--'>Manage hotels</a> |-->
    <!--    <a href='--><?php //echo site_url('admin/main/nas')?><!--'>Manage hotel routers</a> |-->
    <!--    <a href='--><?php //echo site_url('admin/main/nas')?><!--'>Manage hotels</a> | -->
    <!--    <a href='--><?php //echo site_url('admin/main/active_users')?><!--'>Active users</a> |-->
    <!--    <a href='--><?php //echo site_url('admin/main/users')?><!--'>User management</a> |-->
    <!--    <a href='--><?php //echo site_url('admin/main/templates')?><!--'>Templates management</a> |-->
    <!--<a href='--><?php //echo site_url('admin/logout')?><!--'>Logout</a> |-->
    <!--</div>-->

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href='<?php echo site_url('admin/main/hotels') ?>'>Manage hotels</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/main/nas') ?>'>Manage hotel routers</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/main/defaults') ?>'>Edit template defaults</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/main/emails') ?>'>Emails</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/main/active_users') ?>'>Active users</a>
                    </li>
                    <li class="active">
                        <a href='<?php echo site_url('admin/main/users') ?>'>User management</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/main/templates') ?>'>Templates management</a>
                    </li>
                    <li>
                        <a href='<?php echo site_url('admin/change-pass') ?>'>Change Admin password</a>
                    </li>
                    <li>
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
<!-- Beginning footer -->
<div>
<footer>
  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</footer>
<script src="assets/js/jQuery-1.10.2.js""></script>
<script src="assets/js/bootstrap.min.js"></script>
<?php echo $before_body;?>
</div>
<!-- End of Footer -->
</body>
</html>
