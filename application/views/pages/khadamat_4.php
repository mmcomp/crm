<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$user_id1 = $user_id;
factor_class::marhale((int) $p1, 'khadamat_4');
$out = '';
$fac = new factor_class((int) $p1);
if ($this->input->post('khadamat_id') !== FALSE) {

    //$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    //$this->form_validation->set_rules('mablagh[]','قیمت ', 'required|is_natural_no_zero');
//        if($this->form_validation->run()==FALSE)
//        {
//            $valid = FALSE;
//            echo 'EDIT';
//        }
//        else
//        {   
    if (trim($_REQUEST['code_hesab']) != '') {
        $my = new mysql_class;
        $my->ex_sqlx("update factor set code_hesab = '" . $_REQUEST['code_hesab'] . "' where id = " . ((int) $p1));
        khadamat_class::updateGhimat($p1, $_REQUEST);
        redirect('khadamat_5/' . $p1);
    } else {
        $out = '<div class="alert alert-danger">' . "لطفا کد حساب وارد شود" . '</div>';
    }

//        }    
}
$this->profile_model->loadUser($user_id);
$men = $this->profile_model->loadMenu();
$this->profile_model->loadUser($user_id);
$user_obj = $this->profile_model->user;
$menu_links = '';
foreach ($men as $title => $href) {
    $tmp = explode('/', $href);
    $active = ($tmp[2] == $page_addr);
    $active2 = TRUE;
    if (isset($tmp[3]) && trim($p1) != '' && $tmp[3] != $p1)
        $active2 = FALSE;
    $active = ($active & $active2);
    $menu_links .= "<li role='presentation'" . (($active) ? " class='active'" : "") . "><a href='$href'>$title</a></li>";
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
echo $this->inc_model->loadProgress(4, $p1);
echo validation_errors();
echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>";
?>
            <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
                قیمت ها
            </div>
            <div class="row" >
<?php
echo $out;
?>
                <div class="col-sm-4 col-sm-offset-4 hs-padding hs-margin-up-down hs-border mm-center">
                    کد حساب مشتری : <input name="code_hesab" class="form-control" value="<?php echo $fac->code_hesab; ?>"/>
                </div>
            </div>
            <div class="row">
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
    </form>
    <div class="hs-float-right hs-margin-up-down">
        <a href="<?php echo site_url() . 'khadamat_3/' . $p1; ?>" class="btn hs-btn-default btn-lg" >
            <span class="glyphicon glyphicon-chevron-right"></span>
            مرحله قبلی
        </a>
    </div>
</div>
</div>
<script>
    function contin()
    {
        $("#frm_tamin").submit();
    }
</script>