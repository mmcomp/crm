<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    factor_class::marhale((int)$p1,'khadamat_3');
    if(isset($_REQUEST['khadamat_id']))
    {
        //var_dump($_REQUEST);
        taminkonande_class::add($p1, $_REQUEST);
        redirect('khadamat_4/'.$p1);
    }
    if(isset($_REQUEST['khadamat_id_j']))
    {
        $out = '';
        $out .= khadamat_tamin_class::loadByKhadamat((int)$_REQUEST['khadamat_id_j']);
        die($out);
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
    <form action="" method="POST" id="frm_tamin">
    <div class="col-sm-10" >
        <?php
            echo $this->inc_model->loadProgress(3,$p1);
        ?>
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            تامین کنندگان
        </div>
        <div class="row hs-border" >
            <div class="col-sm-12">
                <div class="hs-float-left" >
                    <span class="glyphicon glyphicon-plus-sign" onclick='addV()' ></span>
                </div>
            </div>
            <div id="all_tamin" >
                <?php
                    echo taminkonande_class::loadLast((int)$p1);
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
    var tmp = '<?php echo taminkonande_class::loadView($p1); ?>';
    function addV()
    {
        $("#all_tamin").append(tmp);
        /*
        $('select').select2({
            dir: "rtl"
        });
*/
    }
    function loadKhadamat_tamin(inp)
    {
        var khadamat_id = parseInt($(inp).val(),10);
        if(!isNaN(khadamat_id) && khadamat_id>0)
        {
            //$($(inp).parent().parent().parent().find("select")[1]).hide();
            $($(inp).parent().parent().parent().find("select")[1]).before("<img src='<?php echo asset_url().'img/stat.gif'; ?>' id='khoon_"+khadamat_id+"'/>");
            $.get("<?php echo site_url()."khadamat_3"?>",{"khadamat_id_j":khadamat_id},function(res){
                console.log(res);
                /*
                $('select').select2({
                    dir: "rtl"
                });
                */
                $("#khoon_"+khadamat_id).remove();
                $($(inp).parent().parent().parent().find("select")[1]).html(res);
                //$($(inp).parent().parent().parent().find("select")[1]).show();
            }).fail(function(){
                $("#khoon_"+khadamat_id).remove();
            });
        }
    }
    function contin()
    {
        $("#frm_tamin").submit();
    }
</script>