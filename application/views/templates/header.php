<!DOCTYPE html>
<html>
<head>
        <?php
            
            $this->load->helper('html');
            $this->load->helper('url');
            
            $this->load->library('user_agent');

            if ($this->agent->is_browser())
            {
                $agent = $this->agent->browser();//.' '.$this->agent->version();
            }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }
            if(strtolower($agent)!='chrome')
            {
                //die('NOK');
            }
//echo $agent;

//echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
            
            echo meta($meta);
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
        <?php echo $title; ?>
        </title>
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-rtl.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/crm.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/font-awesome.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-select.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/select2.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/xgrid.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/fileinput.min.css" type="text/css" />
     <!--<link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap.min.css" />-->
     <link rel="stylesheet" href="<?php echo asset_url(); ?>css/bootstrap-datepicker.min.css" />
     <script src=" <?php echo asset_url().'js/jquery-1.11.1.min.js' ?>" ></script>
     <script src=" <?php echo asset_url().'js/grid.min.js' ?>" ></script>
     <script src=" <?php echo asset_url().'js/bootstrap-datepicker.min.js' ?>"></script>
     <script src=" <?php echo asset_url().'js/bootstrap-datepicker.fa.min.js' ?>"></script>
     <script src=" <?php echo asset_url().'js/fileinput.min.js' ?>"></script>
     <script src=" <?php echo asset_url().'js/jquery.PrintArea.js' ?>"></script>
    <?php
        if(isset($has_ckeditor) && $has_ckeditor) // if in edit_content ckedotr is activeted
        {    
            echo '<script src="'.asset_url().'js/ckeditor/ckeditor.js"></script>'."\n";
        }    
    ?>
</head>
<body>
    <div class="container" >
        <div class="row hs-border" >
            <div class="col-sm-10 hs-logo hs-float-right" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content='' >     
            </div>
            <div class="col-sm-2 hs-margin-up-down hs-padding" >
                <?php
                    if(isset($user_id) && $user_id>0)
                    {
                        $us = new user_class($user_id);
                        echo '<small>
                            <div class="hs-margin-up-down" >
                            <span class="glyphicon glyphicon-user" ></span>
                             '.$us->fname.' '.$us->lname.' 
                            <a href="'.site_url().'profile" ><span class="glyphicon glyphicon-pencil" ></span></a> 
                            <a href="'.site_url().'login?logout=12344" ><span class="glyphicon glyphicon-log-out" ></span></a>
                            </div>
                            <div>
                                خوش آمدید
                            </div>    
                        </small>';
                    }    
                ?>
            </div>
        </div>
        <div class="row hs-margin-up-down" >
        <nav class="navbar navbar-default" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed hs-default" data-toggle="collapse" data-target="#main_menu">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse hs-default hs-border" id="main_menu" >
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url(); ?>" ><span class="glyphicon glyphicon-home" ></span>  صفحه نخست</a></li>
                    <li><a href="<?php echo site_url() ?>aboutus" ><span class="glyphicon glyphicon-check" ></span>    درباره ما</a></li>
                    <li><a href="<?php echo site_url() ?>contactus" ><span class="glyphicon glyphicon-envelope" ></span>  تماس با ما</a></li>
                    <?php if($is_logged){ ?>
                    <li><a href="<?php echo site_url() ?>login?logout=12344" ><span class="glyphicon glyphicon-log-out" ></span> خروج</a></li>
                    <?php
                    }
                    else{
                    ?>
                    <li><a href="<?php echo site_url() ?>login" ><span class="glyphicon glyphicon-log-in" ></span> ورود</a></li>
                    <?php
                    }
                    ?>
                </ul>
                <?php if($is_logged){ ?>
                <form class="navbar-form navbar-left" action="<?php echo site_url(); ?>home" id="frm1">
                  <div class="form-group">
                      <input type="text" class="form-control" placeholder="جستجوی فاکتور" name="s_factor_id" onkeypress="$('#s_code_melli').val('');" id="s_factor_id">
                    <input type="text" class="form-control" placeholder="جستجوی کد ملی" name="s_code_melli" id="s_code_melli" onkeypress="$('#s_factor_id').val('');">
                  </div>
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </form>
                <?php
                }
                ?>
            </div>   
        </nav>
        </div>
        
    