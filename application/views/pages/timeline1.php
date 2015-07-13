<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
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
    $msg = '';
    if(trim($p1)=='' || (int)$p1<=0)
    {
        $msg = '<div class="alert alert-danger">کاربری انتخاب نشده</div>';
    }
    else
    {
        
    }
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
    <div class="col-sm-10" >
        <div class="hs-gray hs-border hs-margin-up-down hs-padding">
            تاریخچه عملکرد مشتری(TimeLine)
        </div>
        <?php echo $msg; ?>
    </div>
</div>
