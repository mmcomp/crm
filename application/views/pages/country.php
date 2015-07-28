<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
    $gname1 = "gname_country";
    $input =array($gname1=>array('table'=>'country','div'=>'div_country'));
    $xgrid1 = new xgrid($input,site_url().'country?');
    $xgrid1->pageRows[$gname1]=10;
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'نام';
    $xgrid1->canEdit[$gname1]=TRUE;
    $xgrid1->canAdd[$gname1]=TRUE;
    $xgrid1->canDelete[$gname1]=TRUE;
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        intialGrid(args);
    });
</script>
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
        <div class="col-sm-12">
            <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            مدیریت کشورها
            </div>
            <div id="div_country" ></div>
        </div>
    </div>
</div>