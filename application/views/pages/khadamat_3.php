<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    factor_class::marhale((int)$p1,'khadamat_3');
    if(isset($_REQUEST['khadamat']))
    {
        //var_dump($_REQUEST);
    }
 
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $this->profile_model->loadUser($user_id1);
    $user_obj = $this->profile_model->user;
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
    //$taminkonande = new taminkonande_class;
    
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
    <form action="khadamat_4">
    <div class="col-sm-10" >
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            تامین کنندگان
        </div>
        <div class="row hs-border" >
            <div id="all_tamin" >
                <?php
                    echo taminkonande_class::loadView((int)$p1);
                ?>
            </div>
        </div>
        <div class="hs-float-left hs-margin-up-down">
        <button href="" class="btn hs-btn-default btn-lg" >
            ادامه
            <span class="glyphicon glyphicon-chevron-left"></span>
        </button>
    </div>
    </div>    
    </form>
</div>
<script>
</script>