<?php
    function generateOption($inp,$start,$order,$selected=-1)
    {
        $ou='';
	if($order == 1)
	{
		for($i=$start;$i<=$inp;$i++)
		{
		    $ou.='<option '.($i==$selected?'selected="selected"':'').' value="'.$i.'">'.$i.'</option>';
		}
	}
	else
	{
		for($i=$inp;$i>$start;$i--)
		{
		    $ou.='<option '.($i==$selected?'selected="selected"':'').' value="'.$i.'">'.$i.'</option>';
		}
	}
        return($ou);
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//    var_dump($_REQUEST);
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    if(isset($_REQUEST['mob']))
    {
        $m = new mysql_class;
        $m->ex_sqlx("update `factor` set `mob` = '".$_REQUEST['mob']."' , `email` = '".$_REQUEST['email']."' where id = $factor_id");
        
    }
    $msg = '';
    $user_id1 = $user_id;
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
    $cur_sh_sal = $this->inc_model->perToEnNums(jdate("Y"));
    $f = new factor_class($factor_id);
    $mos = mosafer_class::loadByFactor($factor_id);
    $typs = array();
    foreach($mos as $mo)
    {
        if(!isset($typs[$mo['khadamat_type']]))
        {
            $typs[$mo['khadamat_type']] = array();
        }
        $typs[$mo['khadamat_type']][] = $mo;
    }
    //var_dump($typs);
    $parvaz = '';
    $mob = $f->mob;
    $email = $f->email;
    if(isset($typs[1]))
    {
        $pdet = '';
        $pindex = 1;
        foreach($typs[1] as $mo)
        {
            $age = $mo['age'];
            $gender_0 = ($mo['gender']==0)?' selected':'';
            $gender_1 = ($mo['gender']==1)?' selected':'';
            $age_adl = ($mo['age']=='adl')?' selected':'';
            $age_chd = ($mo['age']=='chd')?' selected':'';
            $age_inf = ($mo['age']=='inf')?' selected':'';
            $fname = $mo['fname'];
            $lname = $mo['lname'];
            $code_melli = $mo['code_melli'];
            $ptav_rooz = $this->inc_model->perToEnNums(jdate("d",strtotime($mo['tarikh_tavalod'])));
            $ptav_mah = $this->inc_model->perToEnNums(jdate("m",strtotime($mo['tarikh_tavalod'])));
            $ptav_sal = $this->inc_model->perToEnNums(jdate("Y",strtotime($mo['tarikh_tavalod'])));
            $tav_rooz = generateOption(31, 1, 1,$ptav_rooz);
            $tav_mah = generateOption(12, 1, 1,$ptav_mah);
            $tav_sal = generateOption($cur_sh_sal, 1300, -1,$ptav_sal);
            $id = $mo['id'];
        $par_det = <<<PARDET
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                $pindex
            </div>
            <div class="col-sm-1">
                <select name="gender[]" style="width:80px;">
                    <option>سن</option>
                    <option value="adl"$age_adl>Adult<option>
                    <option value="chd"$age_chd>Child</option>
                    <option value="inf"$age_inf>Infant</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0"$gender_0>مونث<option>
                    <option value="1"$gender_1>مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="mosafer_id[]" value="$id" />
                <input name="fname[]" class="form-control same same_fname same_master" placeholder="نام *" value="$fname">
            </div>
            <div class="col-sm-2">
                <input name="lname[]" class="form-control same same_lname same_master" placeholder="نام خانوادگی *" value="$lname">
            </div>
            <div class="col-sm-2">
                <input name="code_melli[]" class="form-control same same_codemelli same_master" placeholder="کد ملی *" value="$code_melli">
            </div>
            <div class="col-sm-3">
                <select name="tarikh_tavalod-rooz[]" style="width:50px;">
                    <option>روز</option>
                    $tav_rooz
                </select>
                <select name="tarikh_tavalod-mah[]" style="width:50px;">
                    <option>ماه</option>
                    $tav_mah
                </select>
                <select name="tarikh_tavalod-sal[]" style="width:70px;">
                    <option>سال</option>
                    $tav_sal
                </select>
            </div>
        </div>

PARDET;
            $pdet .= $par_det;
            $pindex++;
        }
        $parvaz1 = <<<PAR
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#flight_div').toggle();">
            پرواز
        </div>
        <div id="flight_div">
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    ردیف
                </div>
                <div class="col-sm-1">
                    سن
                </div>
                <div class="col-sm-1">
                    جنسیت
                </div>
                <div class="col-sm-2">
                    نام 
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-3">
                    نام خانوادگی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    کد ملی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    تاریخ تولد
                    <span class="mm-font-red">*</span>
                </div>
            </div>

PAR;
        $parvaz2 = <<< PAR2
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-2">
                    تلفن همراه : 
                </div>
                <div class="col-sm-4">
                    <input name="mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="$mob">
                </div>
                <div class="col-sm-1">
                    ایمیل :
                </div>
                <div class="col-sm-5">
                    <input name="email" class="form-control same same_email same_master" placeholder="ایمیل" value="$email">
                </div>
            </div>
        </div>
PAR2;
        $parvaz = $parvaz1.$pdet.$parvaz2;
    }
    $hotel = '';
    if(isset($typs[2]))
    {
        $hot_det = '';
        $hdet = '';
        $hindex = 1;
        foreach($typs[2] as $mo)
        {
            $age = $mo['age'];
            $gender_0 = ($mo['gender']==0)?' selected':'';
            $gender_1 = ($mo['gender']==1)?' selected':'';
            $age_adl = ($mo['age']=='adl')?' selected':'';
            $age_chd = ($mo['age']=='chd')?' selected':'';
            $age_inf = ($mo['age']=='inf')?' selected':'';
            $fname = $mo['fname'];
            $lname = $mo['lname'];
            $code_melli = $mo['code_melli'];
            $ptav_rooz = $this->inc_model->perToEnNums(jdate("d",strtotime($mo['tarikh_tavalod'])));
            $ptav_mah = $this->inc_model->perToEnNums(jdate("m",strtotime($mo['tarikh_tavalod'])));
            $ptav_sal = $this->inc_model->perToEnNums(jdate("Y",strtotime($mo['tarikh_tavalod'])));
            $tav_rooz = generateOption(31, 1, 1,$ptav_rooz);
            $tav_mah = generateOption(12, 1, 1,$ptav_mah);
            $tav_sal = generateOption($cur_sh_sal, 1300, -1,$ptav_sal);
            $id = $mo['id'];
           $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    $hindex
                </div>
                <div class="col-sm-1">
                    <select name="sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"$gender_0>مونث<option>
                        <option value="1"$gender_1>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="hotel_mosafer_id[]" value="$id" />
                    <input name="hotel_fname[]" class="form-control same same_fname" placeholder="نام *" value="$fname">
                </div>
                <div class="col-sm-5">
                    <input name="hotel_lname[]" class="form-control same same_lname" placeholder="نام خانوادگی *" value="$lname">
                </div>
                <div class="col-sm-2">
                    <input name="hotel_code_melli[]" class="form-control same same_codemelli" placeholder="کد ملی *" value="$code_melli">
                </div>
            </div>
HODET;
            
            $hot_det .= $ho_det;
            $hindex++;
        }
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#hotel_div').toggle();">
                هتل
            </div>
            <div id="hotel_div">
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-1">
                        ردیف
                    </div>
                    <div class="col-sm-1">
                        جنسیت
                    </div>
                    <div class="col-sm-3">
                        نام 
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-5">
                        نام خانوادگی
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-2">
                        کد ملی
                        <span class="mm-font-red">*</span>
                    </div>
                </div>
HOT1;
        $hotel2 = <<<HOT2
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-2">
                        تلفن همراه : 
                    </div>
                    <div class="col-sm-4">
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="$mob">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="$email">
                    </div>
                </div>
            </div>

HOT2;
        $hotel = $hotel1.$hot_det.$hotel2;
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
    <form method="post">
    <div class="col-sm-10" >
        <?php
            echo $this->inc_model->loadProgress(2);
        ?>

        <?php echo $parvaz; ?>
    </div>
    <div class="col-sm-10" >
        <?php echo $hotel; ?>
        <div class="hs-float-left hs-margin-up-down">
            <button href="" class="btn hs-btn-default btn-lg" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
        </div>
        <div class="hs-float-right hs-margin-up-down">
            <a href="<?php echo site_url().'khadamat_1/'.$factor_id; ?>" class="btn hs-btn-default btn-lg" >
                <span class="glyphicon glyphicon-chevron-right"></span>
                مرحله قبلی
            </a>
        </div>
    </div>
    </form>
</div>
<script>
    function toggle_profile()
    {
        var is_visible = ($("#profile_div:visible").length>0);
        if(is_visible!==false)
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-down" ></span>');
        else
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-up" ></span>');
        $("#profile_div").toggle('fast');
    }
</script>