<?php
    function dotarafeGen($selected=1)
    {
        $selected = (int)$selected;
        $out = '<option '.(($selected==0)?'selected':'').' value="0">یکطرفه</option>';
        $out .= '<option '.(($selected==1)?'selected':'').' value="1">دوطرفه</option>';
        return($out);
    }
    function smallValidateSelect($p,$name)
    {
        $mmsg = '';
        foreach($p as $mabda)
        {
            if((int)$mabda<=0)
            {
                $mmsg = '<div class="alert alert-danger">فیلد '.$name.' می بایست انتخاب شود</div>';
            }
        }
        return($mmsg);
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $red_url = 'profile?factor_id='.$p1;
    $refer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strpos($refer,'profile')!==FALSE)
    {
        $red_url = 'khadamat_2/'.$p1;
    }
    factor_class::marhale((int)$p1,'khadamat_1');
    $p1=(int)$p1;
    $msg = '';
    $include_types = factor_class::loadTypes($p1);
    if( !in_array('1', $include_types) && !in_array('2', $include_types) && !in_array('3', $include_types))
    {
        redirect($red_url);
    } 
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
    $parvaz_temp = <<<PTMP
            <div class="hs-border hs-padding row hs-margin-up-down parva_box">
                <div>
                    <span class="glyphicon glyphicon-minus pointer" onclick="removePar(this);"></span>
                </div>
                <div class="row">
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[mabda_id][]"><option value="-1">مبدا</option>#mabda_id#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[maghsad_id][]"><option value="-1">مقصد</option>#maghsad_id#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[dotarafe][]" style="width:100px;" onchange="dotarafeChange(this);">#dotarafe#</select>
                    </div>                
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[adl][]" style="width:100px;"><option value="-1">بزرگسال</option>#adl#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[chd][]" style="width:100px;"><option value="-1">کودک</option>#chd#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[inf][]" style="width:100px;"><option value="-1">نوزاد</option>#inf#</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[tarikh][]" class="form-control dateValue2" value="#tarikh#" placeholder="تاریخ" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[airline][]" class="form-control"><option value="-1">ایرلاین</option>#airline#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[class][]" class="form-control" value="#class#"  placeholder="کلاس پروازی" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[flight_number][]" class="form-control" value="#flight_number#"  placeholder="شماره پرواز" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[havapeima][]" class="form-control" value="#havapeima#"  placeholder="هواپیما" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1 hs-padding">
                        خروج : 
                    </div>
                    <div class="col-sm-1 hs-padding" style="text-align:left;">
                        <select name="parvaz[khorooj_daghighe][]" >#khorooj_daghighe#</select>
                    </div>
                    <div class="col-sm-1 hs-padding" style="width:2px;">
                        :
                    </div>
                    <div class="col-sm-1 hs-padding">
                        <select name="parvaz[khorooj_saat][]">#khorooj_saat#</select>
                    </div>                

                    <div class="col-sm-1 hs-padding">
                        ورود :‌
                    </div>
                    <div class="col-sm-1 hs-padding" style="text-align:left;">
                        <select name="parvaz[vorood_daghighe][]" >#khorooj_daghighe#</select>
                    </div>
                    <div class="col-sm-1 hs-padding" style="width:2px;">
                        :
                    </div>
                    <div class="col-sm-1 hs-padding">
                        <select name="parvaz[vorood_saat][]">#vorood_saat#</select>
                    </div>                

                </div>
            </div>
PTMP;
    $parvaz_det = array(
        "mabda_id" => -1,
        "maghsad_id" => -1,
        "tarikh" => '',
        "adl" => -1,
        "chd" => -1,
        "inf" => -1,
        "dotarafe" => 0,
        "airline" => -1,
        "class" => '',
        "flight_number" => '',
        "havapeima" => '',
        "khorooj_saat" => '00',
        "khorooj_daghighe" => '00',
        "vorood_saat" => '00',
        "vorood_daghighe" => '00'
    );
    $parvaz = array();
    if(isset($_REQUEST['parvaz']))
    {
        $p = $_REQUEST['parvaz'];
        for($i = 0;$i < count($p['mabda_id']);$i++)
        {
            $parvaz[] = $parvaz_det;
        }

        foreach($p as $key => $vals)
        {
            for($i = 0;$i < count($vals);$i++)
            {
                $parvaz[$i][$key] = $vals[$i];
            }
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('parvaz[tarikh][]','تاریخ','required|min_length[8]|max_length[10]');
        $this->form_validation->set_rules('parvaz[flight_number][]','شماره پرواز','required|min_length[3]');
        $this->form_validation->set_rules('parvaz[class][]','کلاس پرواز','required|min_length[1]');
        $this->form_validation->set_rules('parvaz[class][]','هواپیما','required|min_length[3]');
        $otherError = FALSE;
        $msg .= smallValidateSelect($p['mabda_id'],'مبدا');
        $msg .= smallValidateSelect($p['maghsad_id'],'مقصد');
        $msg .= smallValidateSelect($p['airline'],'ایرلاین');
        $msg .= smallValidateSelect($p['adl'],'بزرگسال ');
        $msg .= smallValidateSelect($p['adl'],'کودک ');
        $msg .= smallValidateSelect($p['adl'],'نوزاد ');
        $otherError = (trim($msg)!=='');
        if($this->form_validation->run()==FALSE || $otherError)
        {
            
        }
        else
        {
            //add to database
        }
    }
    else
    {
        $parvaz = array($parvaz_det);
    }
    $parvazs = '';
    $parvaz_tmp1 = str_replace("#mabda_id#",city_class::loadAll(),$parvaz_temp);
    $parvaz_tmp1 = str_replace("#maghsad_id#",city_class::loadAll(),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#tarikh#",'',$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#adl#",$this->inc_model->generateOption(9,1,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#chd#",$this->inc_model->generateOption(9,0,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#inf#",$this->inc_model->generateOption(9,0,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#dotarafe#",dotarafeGen(),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#airline#",airline_class::loadAll(),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#class#",'',$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#flight_number#",'',$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#havapeima#",'',$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
    $parvaz_tmp1 = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
    $parvaz_tmp2 = str_replace("#airline#",airline_class::loadAll(),$parvaz_temp);
    $parvaz_tmp2 = str_replace("#class#",'',$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#flight_number#",'',$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#havapeima#",'',$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1),$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
    $parvaz_tmp2 = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
    for($i = 0;$i < count($parvaz);$i++)
    {
        $parvazak = str_replace("#mabda_id#",city_class::loadAll($parvaz[$i]['mabda_id']),$parvaz_temp);
        $parvazak = str_replace("#maghsad_id#",city_class::loadAll($parvaz[$i]['maghsad_id']),$parvazak);
        $parvazak = str_replace("#tarikh#",$parvaz[$i]['tarikh'],$parvazak);
        $parvazak = str_replace("#adl#",$this->inc_model->generateOption(9,1,1,$parvaz[$i]['adl']),$parvazak);
        $parvazak = str_replace("#chd#",$this->inc_model->generateOption(9,0,1,$parvaz[$i]['chd']),$parvazak);
        $parvazak = str_replace("#inf#",$this->inc_model->generateOption(9,0,1,$parvaz[$i]['inf']),$parvazak);
        $parvazak = str_replace("#dotarafe#",dotarafeGen($parvaz[$i]['dotarafe']),$parvazak);
        $parvazak = str_replace("#airline#",airline_class::loadAll($parvaz[$i]['airline']),$parvazak);
        $parvazak = str_replace("#class#",$parvaz[$i]['class'],$parvazak);
        $parvazak = str_replace("#flight_number#",$parvaz[$i]['flight_number'],$parvazak);
        $parvazak = str_replace("#havapeima#",$parvaz[$i]['havapeima'],$parvazak);
        $parvazak = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['khorooj_saat']),$parvazak);
        $parvazak = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1,$parvaz[$i]['khorooj_daghighe']),$parvazak);
        $parvazak = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['vorood_saat']),$parvazak);
        $parvazak = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['vorood_daghighe']),$parvazak);
        $parvazs .= $parvazak;
    }
?>
<style>
    .parva_box:nth-child(even){
        background: #cccccc;
    }
</style>
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
    <?php
    echo $this->inc_model->loadProgress(1,$p1);
    ?>
    </div>
    <div class="col-sm-10" >
        <?php
            echo validation_errors().$msg;
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 
        ?>
        
        <div class="row hs-border hs-margin-up-down" id="parvaz_header">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border">
                اطلاعات مسیر پروازی
                &nbsp;&nbsp;&nbsp;
                <button class="btn" onclick="addPar();"><span class="glyphicon glyphicon-plus" style="color:#000000;font-size: 12px;"></span></button>
            </div>
        </div>
            <form id="frm1_khadamat_1" action="<?php echo site_url().'khadamat_1/'.$p1;  ?>" method="POST">
            <?php echo $parvazs; ?>
            </form>
    </div>
        <div class="hs-float-left hs-margin-up-down">
            <a class="btn hs-btn-default btn-lg" onclick="contin()" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        </div>
    <form action="<?php echo site_url(); ?>profile" method="POST" >
        <input type="hidden" name="factor_id" value="<?php echo $p1;  ?>" />
        <div class="hs-float-right hs-margin-up-down">
            <button href="" class="btn hs-btn-default btn-lg" >
                <span class="glyphicon glyphicon-chevron-right"></span>
                مرحله قبل
            </button>
        </div>
    </form>
    </div>
</div>
<script>
    var parvaz_temp = '<?php echo str_replace("\n", "\\\n", $parvaz_tmp1); ?>';
    var parvaz_temp_dotarafe = '<?php echo str_replace("\n", "\\\n", $parvaz_tmp2); ?>';
    function contin()
    {
        $("#frm1_khadamat_1").submit();
    }
    function addPar()
    {
        var ptmp = parvaz_temp;
        $("#frm1_khadamat_1").append(ptmp);
        $('select').select2({
            dir: "rtl"
        });
        $(".dateValue2").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true
        });
    }
    function removePar(dobj)
    {
        $(dobj).parent().parent().remove();
    }
    function dotarafeChange(dobj)
    {
        var obj = $(dobj);
        if(obj.val()===1)
        {
            var ptmp = parvaz_temp_dotarafe;
            $("#frm1_khadamat_1").append(ptmp);
            $('select').select2({
                dir: "rtl"
            });
            $(".dateValue2").datepicker({
                numberOfMonths: 2,
                showButtonPanel: true
            });
        }
    }
</script>