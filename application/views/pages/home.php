<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if(isset($_REQUEST['s_code_melli']))
    {
        $user_obj = new user_class;
        $user_obj->loadByCodeMelli(trim($_REQUEST['s_code_melli']));
        if(!isset($user_obj->id))
        {
            $msg = '<div class="alert alert-danger">'."کاربر مورد نظر پیدا نشد".'</div>';
        }
        else
        {
            redirect("profile?s_user_id=".$user_obj->id);
        }
    }

    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $msg = '';
    $menu_links = '';
    foreach($men as $title=>$href)
    {
        $tmp = explode('/', $href);
        $active = ($tmp[2]==$page_addr);
        $active2 = TRUE;
        if(isset($tmp[3]) && trim($p1)!='' && $tmp[3]!=$p1)
            $active2 = FALSE;
        $active = ($active & $active2);
        $menu_links .= "<li role='presentation'".(($active)?" class='active'":"")."><a href='$href'>$title</a></li>";
    }

    $conf = new conf();
    if($conf->home_page!='home' and trim($conf->home_page)!='')
        redirect($conf->home_page);
?>
<div class="row" >
    <div class="col-sm-2" >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
              امکانات
        </div>
        <div class="hs-margin-up-down hs-padding hs-border" >
            <ul class="nav nav-pills nav-stacked">
            <?php
                echo $menu_links;
            ?>
            </ul>
        </div>
    </div>
    <div class="col-sm-8" >
        <div class="hs-margin-up-down" >
       <?php
            //echo $this->contents_model->loadHome();
            echo $msg;
        ?>
        </div>
    </div>
    <!--
    <div class="col-sm-2"  >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
            ورود کد ملی
        </div>
        <div>
            <?php echo form_open('home',array('id'=>'frm1'));  ?>
            <input type="number" name="s_code_melli" class="form-control" >
            <button class="form-control btn btn-default hs-margin-up-down" >
                جستجوی سریع
            </button>
            <?php echo form_close(); ?>
        </div>
    </div>
    -->
</div>