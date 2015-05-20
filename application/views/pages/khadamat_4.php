<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $user_id1 = $user_id;
    factor_class::marhale((int)$p1,'khadamat_4');
    if($this->input->post('khadamat_id')!==FALSE)
    {
        khadamat_class::updateGhimat($p1, $_REQUEST);
    }    
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $this->profile_model->loadUser($user_id);
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
    <form action="" method="POST" id="frm_tamin">
    <div class="col-sm-10" >
        <?php
            echo $this->inc_model->loadProgress(4,$p1);
        ?>
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            قیمت ها
        </div>
        <div class="row" >
            <div id="foroosh_all" >
                <?php
                    echo khadamat_class::loadForooshView($p1);
                ?>
            </div>
        </div>
        <div class="hs-float-left hs-margin-up-down">
            <a class="btn hs-btn-default btn-lg" onclick="contin()" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        </div>
    </div>    
    </form>
</div>
<script>
    function contin()
    {
        $("#frm_tamin").submit();
    }
</script>