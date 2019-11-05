<!DOCTYPE html>
<html>
<head>
    <base href="<?=base_url()?>"></base>
    <link rel="shorcut icon" href="assets/imgs/ignite-logo-circle.png" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ignite Source</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="semantic/semantic.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/jquery-confirm.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/login.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css" />
</head>
<body>
   
   <?php if($this->session->userdata('loginState')):?>
    <div class="ui fixed  menu">
        
        <div class="ui container">
            <a href="ignite/dashboard" class="header item">
            <img src="assets/imgs/ignite-logo-circle.png" />
            &nbsp; &nbsp; IGNITE SOURCE &nbsp;
            <small class="text-grey">Gasoline POS</small>
            </a>
            <a href="home" class="item <?php if($this->uri->segment(1) == 'home' || $this->uri->segment(1) == ''){echo 'active';}?>">
                <i class="desktop icon"></i> HOME
            </a>

            <a href="rate" class="item">
                <i class="dollar sign icon"></i> RATE
            </a>

            <div class="ui simple dropdown item">
                <i class="file alternate outline icon"></i> REPORTS <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="report-daily"><i class="chart line icon teal"></i> Daily</a>
                <a class="item" href="report-monthly"><i class="chart line icon violet"></i> Monthly</a>
                <a class="item" href="report-yearly"><i class="chart line icon purple"></i> Yearly</a>
            </div>
            </div>

            <div class="right menu">
                <!-- Username -->
                <div class="borderless item">
                    <div class="ui dropdown">
                        <div class="default text"><?=$this->session->userdata('username')?></div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a href="ignite/logout" class="item" data-value="female">Logout</a>
                        </div>
                        </div>
                </div>

                <!-- Setting -->
                <div class="borderless item">
                    <div class="ui dropdown">
                        <div class="default icon"><i class="icon cog"></i></div>
                        
                        <div class="menu">
                            <a href="users" class="item" data-value="female">Users</a>
                        </div>
                        </div>
                </div>
            </div>

        </div>

    </div>

    <div id="maincontent" class="ui main container">
        <?php $this->load->view($content)?>
    </div>

    <?php else:?>
        <?php $this->load->view('errors/error_401')?>
    <?php endif;?>

    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="semantic/semantic.min.js"></script>
    <script src="assets/js/jquery.datetimepicker.js"></script>
    <script src="assets/js/jquery-confirm.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>