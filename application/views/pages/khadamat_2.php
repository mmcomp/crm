<?php
    function perToEnNums($inNum){
        $outp = $inNum;
        $outp = str_replace('۰', '0', $outp);
        $outp = str_replace('۱', '1', $outp);
        $outp = str_replace('۲', '2', $outp);
        $outp = str_replace('۳', '3', $outp);
        $outp = str_replace('۴', '4', $outp);
        $outp = str_replace('۵', '5', $outp);
        $outp = str_replace('۶', '6', $outp);
        $outp = str_replace('۷', '7', $outp);
        $outp = str_replace('۸', '8', $outp);
        $outp = str_replace('۹', '9', $outp);
        return($outp);
    }
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
    function generateInputBlock($startStr,$endStr,$midStr,$inp,$factor,$cur_sh_sal)
    {
        $mob = $factor->mob;
        $email = $factor->email;
        $pdet = '';
        $pindex = 1;
        foreach($inp as $mo)
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
            $ptav_rooz = perToEnNums(jdate("d",strtotime($mo['tarikh_tavalod'])));
            $ptav_mah = perToEnNums(jdate("m",strtotime($mo['tarikh_tavalod'])));
            $ptav_sal = perToEnNums(jdate("Y",strtotime($mo['tarikh_tavalod'])));
            $tav_rooz = generateOption(31, 1, 1,$ptav_rooz);
            $tav_mah = generateOption(12, 1, 1,$ptav_mah);
            $tav_sal = generateOption($cur_sh_sal, 1300, -1,$ptav_sal);
            $id = $mo['id'];
            $khadamat_name = $mo['khadamat_name'];
            $passport = $mo['passport'];
            $midStr = str_replace('#pindex#', $pindex, $midStr);
            $midStr = str_replace('#age_adl#', $age_adl, $midStr);
            $midStr = str_replace('#age_chd#', $age_chd, $midStr);
            $midStr = str_replace('#age_inf#', $age_inf, $midStr);
            $midStr = str_replace('#gender_0#', $gender_0, $midStr);
            $midStr = str_replace('#gender_1#', $gender_1, $midStr);
            $midStr = str_replace('#id#', $id, $midStr);
            $midStr = str_replace('#fname#', $fname, $midStr);
            $midStr = str_replace('#lname#', $lname, $midStr);
            $midStr = str_replace('#code_melli#', $code_melli, $midStr);
            $midStr = str_replace('#passport#', $passport, $midStr);
            $midStr = str_replace('#tav_rooz#', $tav_rooz, $midStr);
            $midStr = str_replace('#tav_mah#', $tav_mah, $midStr);
            $midStr = str_replace('#tav_sal#', $tav_sal, $midStr);
            $pdet .= $midStr;
            $pindex++;
        }
        $endStr = str_replace('#mob#', $mob, $endStr);
        $endStr = str_replace('#email#', $email, $endStr);
        $startStr = str_replace('#khadamat_name#', $khadamat_name, $startStr);
        $out = $startStr.$pdet.$endStr;
        return($out);

    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
//----------UPDATING Start--------    
    if(isset($_REQUEST['mob']))
    {
        $m = new mysql_class;
        $m->ex_sqlx("update `factor` set `mob` = '".$_REQUEST['mob']."' , `email` = '".$_REQUEST['email']."' where id = $factor_id");
        
    }
    if(isset($_REQUEST['parvaz_mosafer_id']))
    {
        $gender = $_REQUEST['parvaz_gender'];
        $sex = $_REQUEST['parvaz_sex'];
        $mosafer_id = $_REQUEST['parvaz_mosafer_id'];
        $fname = $_REQUEST['parvaz_fname'];
        $lname = $_REQUEST['parvaz_lname'];
        $code_melli = $_REQUEST['parvaz_code_melli'];
        $tarikh_tavalod = $this->inc_model->jalaliToMiladi($_REQUEST['parvaz_tarikh_tavalod-sal'].'/'.$_REQUEST['parvaz_tarikh_tavalod-mah'].'/'.$_REQUEST['parvaz_tarikh_tavalod-rooz']);
        foreach ($mosafer_id as $mosafer_id0)
        {
            mosafer_class::add($fname, $lname, $code_melli, '', '', $gender, $age, $tarikh_tavalod, $khadamat_factor_id);
        }
    }
//----------UPDATING End----------    
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
//----------DRAWING Start---------
    $my = new mysql_class;
    $mosafer_to_delete = array();
    $my->ex_sql("select mosafer.id from mosafer left join khadamat_factor on (khadamat_factor.id=khadamat_factor_id) where khadamat_factor.id is null",$q);
    foreach($q as $r)
        $mosafer_to_delete[] = (int)$r['id'];
    if(count($mosafer_to_delete)>0)
        $my->ex_sqlx("delete from `mosafer` where `id` in (".implode (",", $mosafer_to_delete).")");
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
    $parvaz = '';
    if(isset($typs[1]))
    {
        $khadamat_factor_id = $typs[1][0]['khadamat_factor_id'];
        $par_obj = new parvaz_class();
        $par_obj->loadByKhadamatFactor($typs[1][0]['khadamat_factor_id']);
        $tmp = new city_class($par_obj->mabda_id);
        $mabda = $tmp->name;
        $tmp = new city_class($par_obj->maghsad_id);
        $maghsad = $tmp->name;
        $tit = '<div class="col-sm-2 hs-padding">'.$mabda.'...'.$maghsad.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">شماره:'.$par_obj->shomare.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">تاریخ:'.jdate("d-m-Y",strtotime($par_obj->tarikh)).'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">ساعت:'.jdate("H:i",strtotime($par_obj->saat)).'</div>';
        $par_det = <<<PARDET
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                #pindex#
            </div>
            <div class="col-sm-1">
                <select name="parvaz_gender[]" style="width:80px;">
                    <option>سن</option>
                    <option value="adl"#age_adl#>Adult<option>
                    <option value="chd"#age_chd#>Child</option>
                    <option value="inf"#age_inf#>Infant</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="parvaz_sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0"#gender_0#>مونث<option>
                    <option value="1"#gender_1#>مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="parvaz_mosafer_id[]" value="#id#" />
                <input name="parvaz_fname[]" class="form-control same same_fname same_master" placeholder="نام *" value="#fname#">
            </div>
            <div class="col-sm-2">
                <input name="parvaz_lname[]" class="form-control same same_lname same_master" placeholder="نام خانوادگی *" value="#lname#">
            </div>
            <div class="col-sm-2">
                <input name="parvaz_code_melli[]" class="form-control same same_codemelli same_master" placeholder="کد ملی *" value="#code_melli#">
            </div>
            <div class="col-sm-3">
                <select name="parvaz_tarikh_tavalod-rooz[]" style="width:50px;">
                    <option>روز</option>
                    #tav_rooz#
                </select>
                <select name="parvaz_tarikh_tavalod-mah[]" style="width:50px;">
                    <option>ماه</option>
                    #tav_mah#
                </select>
                <select name="parvaz_tarikh_tavalod-sal[]" style="width:70px;">
                    <option>سال</option>
                    #tav_sal#
                </select>
            </div>
        </div>

PARDET;
        $parvaz1 = <<<PAR
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#flight_div').toggle();">
            <div class="col-sm-2 hs-padding">
                #khadamat_name#
            </div>
            $tit <input type="hidden1" name="khadamat_factor_id" value="" />
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
                    <input name="mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                </div>
                <div class="col-sm-1">
                    ایمیل :
                </div>
                <div class="col-sm-5">
                    <input name="email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                </div>
            </div>
        </div>
PAR2;
        $parvaz = generateInputBlock($parvaz1, $parvaz2, $par_det, $typs[1], $f,$cur_sh_sal);
    }
    $hotel = '';
    if(isset($typs[2]))
    {
        $hot_obj = new hotel_class();
        $hot_obj->loadByKhadamatFactor($typs[2][0]['khadamat_factor_id']);
        $tmp = new city_class($hot_obj->maghsad_id);
        $maghsad = $tmp->name;
        $tit = '<div class="col-sm-2 hs-padding">'.$maghsad.'</div>';
        $tit .='<div class="col-sm-2 hs-padding">'.$hot_obj->name.'</div>';
        $tit .='<div class="col-sm-2 hs-padding">'.$hot_obj->shab.'شب'.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">'.'تاریخ:'.jdate("d-m-Y",strtotime($par_obj->tarikh)).'</div>';
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="hotel_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث<option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="hotel_mosafer_id[]" value="#id#" />
                    <input name="hotel_fname[]" class="form-control same same_fname" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-5">
                    <input name="hotel_lname[]" class="form-control same same_lname" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="hotel_code_melli[]" class="form-control same same_codemelli" placeholder="کد ملی *" value="#code_melli#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#hotel_div').toggle();">
                <div class="col-sm-2 hs-padding">#khadamat_name#</div>$tit
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
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;

        $hotel = generateInputBlock($hotel1, $hotel2,$ho_det, $typs[2], $f, $cur_sh_sal);
    }
    $tour = '';
    if(isset($typs[3]))
    {
        $par_obj = new parvaz_class();
        $par_obj->loadByKhadamatFactor($typs[3][0]['khadamat_factor_id']);
        $tmp = new city_class($par_obj->mabda_id);
        $mabda = $tmp->name;
        $tmp = new city_class($par_obj->maghsad_id);
        $maghsad = $tmp->name;
        $hot_obj = new hotel_class();
        $hot_obj->loadByKhadamatFactor($typs[3][0]['khadamat_factor_id']);
        $tit = '<div class="col-sm-2 hs-padding">'.$mabda.'...'.$maghsad.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">شماره:'.$par_obj->shomare.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">تاریخ:'.jdate("d-m-Y",strtotime($par_obj->tarikh)).'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">ساعت:'.jdate("H:i",strtotime($par_obj->saat)).'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">هتل:'.$hot_obj->name.'('.$hot_obj->shab.'شب)'.'</div>';
        $par_det = <<<PARDET
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                #pindex#
            </div>
            <div class="col-sm-1">
                <select name="tour_gender[]" style="width:80px;">
                    <option>سن</option>
                    <option value="adl"#age_adl#>Adult<option>
                    <option value="chd"#age_chd#>Child</option>
                    <option value="inf"#age_inf#>Infant</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="tour_sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0"#gender_0#>مونث<option>
                    <option value="1"#gender_1#>مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="tour_mosafer_id[]" value="#id#" />
                <input name="tour_fname[]" class="form-control same same_fname same_master" placeholder="نام *" value="#fname#">
            </div>
            <div class="col-sm-2">
                <input name="tour_lname[]" class="form-control same same_lname same_master" placeholder="نام خانوادگی *" value="#lname#">
            </div>
            <div class="col-sm-2">
                <input name="tour_code_melli[]" class="form-control same same_codemelli same_master" placeholder="کد ملی *" value="#code_melli#">
            </div>
            <div class="col-sm-3">
                <select name="tour_tarikh_tavalod-rooz[]" style="width:50px;">
                    <option>روز</option>
                    #tav_rooz#
                </select>
                <select name="tour_tarikh_tavalod-mah[]" style="width:50px;">
                    <option>ماه</option>
                    #tav_mah#
                </select>
                <select name="tour_tarikh_tavalod-sal[]" style="width:70px;">
                    <option>سال</option>
                    #tav_sal#
                </select>
            </div>
        </div>

PARDET;
        $parvaz1 = <<<PAR
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#flight_div').toggle();">
            <div class="col-sm-2 hs-padding">#khadamat_name#</div>$tit
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
                    <input name="mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                </div>
                <div class="col-sm-1">
                    ایمیل :
                </div>
                <div class="col-sm-5">
                    <input name="email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                </div>
            </div>
        </div>
PAR2;
        $tour = generateInputBlock($parvaz1, $parvaz2, $par_det, $typs[3], $f,$cur_sh_sal);
    }
    $visa_melli = '';
    if(isset($typs[4]))
    {
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="visamelli_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث<option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="visamelli_mosafer_id[]" value="#id#" />
                    <input name="visamelli_fname[]" class="form-control same same_fname" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-5">
                    <input name="visamelli_name[]" class="form-control same same_lname" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="visamelli_code_melli[]" class="form-control same same_codemelli" placeholder="کد ملی *" value="#code_melli#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#hotel_div').toggle();">
                #khadamat_name#
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
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;

        $visa_melli = generateInputBlock($hotel1, $hotel2,$ho_det, $typs[4], $f, $cur_sh_sal);
    }
    $visa_pass = '';
    if(isset($typs[5]))
    {
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="visapass_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث<option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="visapass_mosafer_id[]" value="#id#" />
                    <input name="visapass_fname[]" class="form-control same same_fname" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-5">
                    <input name="visapass_lname[]" class="form-control same same_lname" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="visapass_passport[]" class="form-control same same_passport" placeholder="شماره پاسپورت*" value="#passport#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="$('#hotel_div').toggle();">
                #khadamat_name#
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
                        پاسپورت
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
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;

        $visa_pass = generateInputBlock($hotel1, $hotel2,$ho_det, $typs[5], $f, $cur_sh_sal);
    }
    //var_dump($typs);
//----------DRAWING End------------
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
        <?php echo $hotel.$tour.$visa_melli.$visa_pass; ?>
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