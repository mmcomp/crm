<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function hamed_jalalitomiladi($str)
    {
            $s=explode('/',$str);
            $out = "";
            if(count($s)==3){
                    $y = (int)$s[0];
                    $m = (int)$s[1];
                    $d = (int)$s[2];
                    if($d > $y)
                    {
                            $tmp = $d;
                            $d = $y;
                            $y = $tmp;
                    }
                    $y = (($y<1000)?$y+1300:$y);
                    $miladi=jalali_to_jgregorian($y,$m,$d);
                    $out=$miladi[0]."-".$miladi[1]."-".$miladi[2];
            }
            return $out;
            //jalali_to_gregorian()
    }
    function perToEn($inNum){
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
    $next = FALSE;
    $msg='';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    factor_class::marhale((int)$p1,'khadamat_1');
    if($this->input->post('city_from')!==FALSE)
    {
        //var_dump($_REQUEST);
        //echo $this->inc_model->jalaliToMiladi($_REQUEST['']);
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('city_from','مبدأ ', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('city_to','مقصد ', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('az_tarikh','از تاریخ', 'required');
        if($this->input->post('two_way')!==FALSE)
        {    
            $this->form_validation->set_rules('ta_tarikh','تا تاریخ', 'required');
        }    
        $this->form_validation->set_rules('airline','ایرلاین ', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('class_parvaz','کلاس پرواز', 'required');
        $this->form_validation->set_rules('shomare','شماره پرواز', 'required');
        $this->form_validation->set_rules('airplain','هواپیما', 'required');
        
        $az_tar=  strtotime(hamed_jalalitomiladi(perToEn($this->input->post('az_tarikh'))));
        $ta_tar=strtotime(hamed_jalalitomiladi(perToEn($this->input->post('ta_tarikh'))));
        //$this->form_validation->set_rules('parvaz_lname[]', 'پرواز : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else if($ta_tar<=$az_tar && $this->input->post('two_way')!==FALSE)
        {
            $msg ='<div class="alert alert-danger" >'. 'تاریخ رفت از تاریخ برگشت بزرگتر است'.'</div>';
        }    
        else
        {    
            $parvaz1['mabda_id']= (int)$this->input->post('city_from');
            $parvaz1['maghsad_id']= (int)$this->input->post('city_to');
            $parvaz1['adl']= (int)$this->input->post('adl');
            $parvaz1['chd']= (int)$this->input->post('chd');
            $parvaz1['inf']= (int)$this->input->post('inf');
            $parvaz1['airline']= ($this->input->post('airline'));
            $parvaz1['tarikh']= hamed_jalalitomiladi(perToEn($this->input->post('az_tarikh')));
            $parvaz1['airplain']= ($this->input->post('airplain'));
            $parvaz1['saat']= (int)$this->input->post('hour').':'.(int)$this->input->post('minute');
            $parvaz1['saat_vorood']= (int)$this->input->post('hour_v').':'.(int)$this->input->post('minute_v');
            $parvaz1['shomare'] = ($this->input->post('shomare'));
            $parvaz1['is_bargasht'] = 0;
            $parvaz1['class_parvaz']= ($this->input->post('class_parvaz'));
            $parvaz1['factor_id'] = (int)$p1;
            $parvaz1['khadamat_factor_id'] = parvaz_class::loadKhadamat_factor_id((int)$p1);
            $gohar_voucher_id=11111;
            $parvaz1['gohar_voucher_id'] = ($this->input->post('raft_check')!==FALSE?-1:$gohar_voucher_id);
            $parvaz1['parvaz_id'] =(int) $this->input->post('parvaz_id');
            parvaz_class::add($parvaz1);

            $parvaz2['mabda_id']= (int)$this->input->post('city_to');
            $parvaz2['maghsad_id']= (int)$this->input->post('city_from');
            $parvaz2['adl']= (int)$this->input->post('adl');
            $parvaz2['chd']= (int)$this->input->post('chd');
            $parvaz2['inf']= (int)$this->input->post('inf');
            $parvaz2['airline']= ($this->input->post('airline_b'));
            $parvaz2['tarikh']=hamed_jalalitomiladi(perToEn($this->input->post('tarikh_parvaz_b')));// $this->inc_model->jalaliToMiladi($this->input->post('tarikh_parvaz_b'));
            $parvaz2['airplain']= ($this->input->post('airplain_b'));
            $parvaz2['saat']= (int)$this->input->post('hour_b').':'.(int)$this->input->post('minute_b');
            $parvaz2['saat_vorood']= (int)$this->input->post('hour_v_b').':'.(int)$this->input->post('minute_v_b');
            $parvaz2['shomare'] = ($this->input->post('shomare_b'));
            $parvaz2['is_bargasht'] = 1;
            $parvaz2['class_parvaz']= ($this->input->post('class_parvaz_b'));
            $parvaz2['factor_id'] = (int)$p1;
            $parvaz2['khadamat_factor_id'] = parvaz_class::loadKhadamat_factor_id((int)$p1);
            $gohar_voucher_id_b=11111;
            $parvaz2['gohar_voucher_id'] = ($this->input->post('bargasht_check')!==FALSE?-1:$gohar_voucher_id_b);
            $parvaz2['parvaz_id'] =(int) $this->input->post('parvaz_id_b');
            parvaz_class::add($parvaz2);
            $next = TRUE;
        }
        //var_dump($parvaz2);
    }
    if($this->input->post('city_to_hotel')!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('hotel_room_count','تعداد اتاق', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('city_to_hotel','مقصد هتل', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('hotel_name','نام هتل', 'required');
        $this->form_validation->set_rules('room_name[]','نام کلیه اتاق ها', 'required');
        $this->form_validation->set_rules('zarfiat[]','ظرفیت اتاق ها', 'required|is_natural_no_zero');
        $az_tar=  strtotime(hamed_jalalitomiladi(perToEn($this->input->post('az_tarikh_hotel'))));
        $ta_tar=strtotime(hamed_jalalitomiladi(perToEn($this->input->post('ta_tarikh_hotel'))));//  strtotime($this->inc_model->jalaliToMiladi($this->input->post('ta_tarikh_hotel')));
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else if($ta_tar<=$az_tar)
        {
            $msg ='<div class="alert alert-danger" >'. 'تاریخ رفت هتل از تاریخ برگشت هتل بزرگتر است'.'</div>';
        }
        else
        {     
            $hotel['maghsad_id'] = (int)$this->input->post('city_to_hotel');
            $hotel['az_tarikh'] = hamed_jalalitomiladi(perToEn($this->input->post('az_tarikh_hotel')));
            $hotel['ta_tarikh'] = hamed_jalalitomiladi(perToEn($this->input->post('ta_tarikh_hotel')));
            $hotel['adl'] = 0;
            $hotel['chd'] = 0;
            $hotel['inf'] = 0;
            foreach($this->input->post('hotel_adl') as $val)
            {
                $hotel['adl'] += $val;
            }    
            foreach($this->input->post('hotel_chd') as $val)
            {
                $hotel['chd'] += $val;
            }
            foreach($this->input->post('hotel_inf') as $val)
            {
                $hotel['inf'] += $val;
            }
            //$hotel['adl'] = (int)$this->input->post('hotel_adl')[0];
            //$hotel['chd'] = (int)$this->input->post('hotel_chd')[0];
            //$hotel['inf'] = (int)$this->input->post('hotel_inf')[0];
            $hotel['name'] = trim($this->input->post('hotel_name'));
            $hotel['star'] = (int)$this->input->post('hotel_star');
            $hotel['room_count'] = (int)$this->input->post('hotel_room_count');
            $hotel['factor_id'] = (int)$p1;
            $hotel['khadamat_factor_id'] = hotel_class::loadKhadamat_factor_id((int)$p1);
            $hotel['hotel_id'] = (int)$this->input->post('hotel_id');
            //
            $hotel_room_count = (int)$this->input->post('hotel_room_count');
            $hotel_room=array();
            for($i=0;$i<$hotel_room_count;$i++)
            {
                $hotel_room[$i]['adl'] = (int)$this->input->post('hotel_adl')[$i];
                $hotel_room[$i]['chd'] = (int)$this->input->post('hotel_chd')[$i];
                $hotel_room[$i]['inf'] = (int)$this->input->post('hotel_inf')[$i];
                $hotel_room[$i]['name'] = trim($this->input->post('room_name')[$i]);
                $hotel_room[$i]['zarfiat'] = (int)$this->input->post('zarfiat')[$i];
                $hotel_room[$i]['extra_service'] =(int) $this->input->post('extra_service')[$i];
                $hotel_room[$i]['extra_service_chd'] =(int) $this->input->post('extra_service_chd')[$i];
                $hotel_room[$i]['gasht'] = $this->input->post('gasht')!==FALSE ? (isset($this->input->post('gasht')[$i])?'1':'0') :'0';
                $hotel_room[$i]['transfer_raft'] = $this->input->post('transfer_raft')!==FALSE ? (isset($this->input->post('transfer_raft')[$i])?'1':'0') :'0';
                $hotel_room[$i]['transfer_vasat'] = $this->input->post('transfer_vasat')!==FALSE ? (isset($this->input->post('transfer_vasat')[$i])?'1':'0') :'0';
                $hotel_room[$i]['transfer_bargasht'] = $this->input->post('transfer_bargasht')!==FALSE ? (isset($this->input->post('transfer_bargasht')[$i])?'1':'0') :'0';
                $hotel_room[$i]['paziraii'] = $this->input->post('paziraii')!==FALSE ? (isset($this->input->post('paziraii')[$i])?'1':'0') :'0';            
                $hotel_room[$i]['hotel_khadamat_id'] = trim($this->input->post('hotel_khadamat_id')[$i]);
                $hotel_room[$i]['factor_id'] = (int)$p1;
                $hotel_room[$i]['khadamat_factor_id'] = $hotel['khadamat_factor_id'];
            }
            //var_dump($hotel);
            hotel_class::add($hotel,$hotel_room);
            $next = TRUE;
        }    
    }
    if($next)
    {
        redirect('khadamat_2/'.$p1);        //$my->ex_sql("select id from khadamat_factor where factor_id=$factor_id and khadamat_id=1",$q);

    }    
    if((int)$p1==0)
    {
        show_404();
    }
    $p1=(int)$p1;
    $include_types = factor_class::loadTypes($p1);
    if( !in_array('1', $include_types) && !in_array('2', $include_types) && !in_array('3', $include_types))
    {
        redirect('khadamat_2/'.$p1);
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
    $par = new parvaz_class;
    $parvaz = $par->loadByFactor_id($p1);
    $hot = new hotel_class;
    $hot->loadByFactor_id($p1);
    $hot_room = hotel_room_class::loadByFactorId($p1);
    $hot_det = '';
    $nafarat = '';
    $shab = 0;
    if(isset($hot->az_tarikh))
    {
        $tshab = strtotime($hot->ta_tarikh)- strtotime($hot->az_tarikh);
        echo $hot->az_tarikh;
        $shab = floor($tshab/(60*60*24));
    }    
    for($j=0;$j<count($hot_room);$j++)
    {
        $hot_det .= "<div id='extra_info_".$hot_room[$j]['id']."' >
                <div class='col-sm-2 hs-margin-up-down text-center' >
               نام اتاق       
                    <input type='text' class='form-control' name='room_name[]' value='".($hot_room[$j]['name'])."'>
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>ظرفیت </small>
                    <select name='zarfiat[]' class='hotel_extra' title='ظرفیت' style='width: 100%' >".$this->inc_model->generateOption(5,0,1,$hot_room[$j]['zarfiat'])."
                    </select> 
                </div>
                <div class='col-sm-2 hs-margin-up-down text-center' >
                    <small>
                        سرویس اضافه بزرگسال </small>
                    <select name='extra_service[]' class='hotel_extra' title='سرویس اضافه بزرگسال' style='width: 100%' >".$this->inc_model->generateOption(5,0,1,$hot_room[$j]['extra_service'])."
                    </select> 
                </div>
                <div class='col-sm-2 hs-margin-up-down text-center' >
                    <small>
                        سرویس اضافه کودک </small>
                    <select name='extra_service_chd[]' class='hotel_extra' title='سرویس اضافه کودک' style='width: 100%' >".$this->inc_model->generateOption(5,0,1,$hot_room[$j]['extra_service_chd'])."
                    </select>
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>
                    گشت
                    </small>
                    <input class='form-control' type='checkbox' name='gasht[$j]' ".((int)$hot_room[$j]['gasht']>0?'checked="checked"':'')." >
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>
                    ت. رفت
                    </small>
                    <input class='form-control' type='checkbox' name='transfer_raft[$j]' ".((int)$hot_room[$j]['transfer_raft']>0?'checked="checked"':'')." >
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>
                    ت. میانی
                    </small>
                    <input class='form-control' type='checkbox' name='transfer_vasat[$j]' ".((int)$hot_room[$j]['transfer_vasat']>0?'checked="checked"':'')." >
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>
                    ت. برگشت
                    </small>
                    <input class='form-control' type='checkbox' name='transfer_bargasht[$j]' ".((int)$hot_room[$j]['transfer_bargasht']>0?'checked="checked"':'')." >
                </div>
                <div class='col-sm-1 hs-margin-up-down text-center' >
                    <small>
                    پذیرایی
                    </small>
                    <input class='form-control' type='checkbox' name='paziraii[$j]' ".((int)$hot_room[$j]['paziraii']>0?'checked="checked"':'')." >
                </div>
                </div>
                ";
        $nafarat.='<div id="hotel_nafar_old_'.$hot_room[$j]['id'].'" >
                <div class="col-sm-4 hs-margin-up-down" > 
                تعداد بزرگسال: 
                <select name="hotel_adl[]" style="width: 50px;" class="hotel_extra" >
                    '.$this->inc_model->generateOption(9,0,1,(int)$hot_room[$j]['adl']).'
                </select>
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد کودک:
                <select name="hotel_chd[]" style="width: 50px;" class="hotel_extra" >
                    '.$this->inc_model->generateOption(9,0,1,(int)$hot_room[$j]['chd']).'
                </select>
            </div>
            <div class="col-sm-3 hs-margin-up-down" >
                تعداد نوزاد: 
                <select name="hotel_inf[]" style="width: 50px;" class="hotel_extra" >
                    '.$this->inc_model->generateOption(9,0,1,(int)$hot_room[$j]['inf']).'
                </select>
            </div>
            <div class="col-sm-1 hs-margin-up-down">
                <big><span class="glyphicon glyphicon-minus-sign" onclick="remove_row(this)"></span></big>
                <input type="hidden" name="hotel_khadamat_id[]" value="'.$hot_room[$j]['id'].'" >
            </div>
            </div>';
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
    <?php
    echo $this->inc_model->loadProgress(1,$p1);
    ?>
    </div>
    <form action="" method="POST" id="frm_khadamat_1" >
    <div class="col-sm-10" >
        <?php
            echo validation_errors();
            echo $msg;
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 
        ?>
        
        <?php 
        if(in_array('1',$include_types) || in_array('3',$include_types)): { ?>
        <div class="row hs-border hs-margin-up-down">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی پرواز
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="zoor" type="hidden" name="parvaz_id" value="<?php echo isset($parvaz['raft'])?$parvaz['raft']->id:-1; ?>">
                <input class="zoor" type="hidden" name="parvaz_id_b" value="<?php echo isset($parvaz['bargasht'])?$parvaz['bargasht']->id:-1; ?>" >
                <select class="zoor" id="city_from" name="city_from" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
                    <?php
                        echo city_class::loadAll(isset($parvaz['raft']->mabda_id)?$parvaz['raft']->mabda_id:'');
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select class="zoor" id="city_to" name="city_to" style="width: 100%" onchange="changeHotelCity();" >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll(isset($parvaz['raft']->maghsad_id)?$parvaz['raft']->maghsad_id:'');
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control zoor" autocomplete="off" placeholder="از تاریخ" onblur="fillRaft(this)" name="az_tarikh" id="az_tarikh" value="<?php echo isset($parvaz['raft']->tarikh)?jdate("Y/m/d",strtotime($parvaz['raft']->tarikh)):'';?>" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" autocomplete="off" placeholder="تا تاریخ" onblur="fillBargasht(this)" name="ta_tarikh" id="ta_tarikh" value="<?php echo (isset($parvaz['bargasht']->tarikh) && $parvaz['bargasht']->tarikh!='0000-00-00 00:00:00')?jdate("Y/m/d",strtotime($parvaz['bargasht']->tarikh)):'';?>" >
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                دوطرفه:
                <input type="checkbox" name="two_way" id="two_way" <?php echo (isset($parvaz['bargasht']->tarikh) && $parvaz['bargasht']->tarikh!='0000-00-00 00:00:00')?'checked':''; ?> >
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد بزرگسال: 
                <select name="adl" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,1,1,$parvaz['raft']->adl); ?>
                </select>
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد کودک: 
                <select name="chd" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1,$parvaz['raft']->chd); ?>
                </select>
            </div> 
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد نوزاد: 
                <select name="inf" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1,$parvaz['raft']->inf); ?>
                </select>
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                <a class="btn hs-btn-default" onclick="$('#flight_results').toggle()">
                    جستجو درگوهر
                </a>
            </div>
            <div class="col-sm-12" id="flight_results" style="display: none;"  >
                
            </div>
            <div class="col-sm-12 hs-gray hs-padding hs-border hs-margin-up-down" >
                ثبت دستی
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                <input type="checkbox" id="raft_check" name="raft_check" onchange="toggle_raft();" >
                پرواز رفت
            </div>
            <div id="raft_div" >
                <div class="col-sm-2" >
                    ایرلاین
                    <select class="zoor" name="airline" style="width:100%" >
                        <option value="-1">
                            انتخاب 
                        </option>
                        <?php
                            echo airline_class::loadAll(isset($parvaz['raft']->airline)?$parvaz['raft']->airline:'');
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    کلاس پرواز
                    <input name="class_parvaz" class="form-control zoor" placeholder="کلاس" value="<?php echo isset($parvaz['raft']->class_parvaz)?$parvaz['raft']->class_parvaz:''; ?>"  >
                </div>
                <div class="col-sm-2" >
                    شماره پرواز
                    <input name="shomare" class="form-control zoor" placeholder="شماره پرواز" value="<?php echo isset($parvaz['raft']->shomare)?$parvaz['raft']->shomare:''; ?>"  >
                </div>
                <div class="col-sm-6" >
                    هواپیما
                    <input name="airplain" class="form-control zoor" placeholder="هواپیما"  value="<?php echo isset($parvaz['raft']->airplain)?$parvaz['raft']->airplain:''; ?>" >
                </div>
                <div class="col-sm-2" >
                    تاریخ
                    <input name="tarikh_parvaz" id="tarikh_parvaz" readonly="readonly" class="form-control" placeholder="تاریخ" value="<?php echo isset($parvaz['raft']->tarikh)?jdate("Y/m/d",strtotime($parvaz['raft']->tarikh)):'';?>" >
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه خروج
                    </small>
                    <select name="minute" style="width: 100%" >
                        <?php
                            $min = '';
                            if(isset($parvaz['raft']->saat))
                            {
                                $tt = explode(':',$parvaz['raft']->saat);
                                $min = $tt[1];
                            }    
                            echo $this->inc_model->generateOption(59,0,1,$min);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت خروج
                    </small>
                    <select name="hour" style="width: 100%" >                
                        <?php
                            $sa = '';
                            if(isset($parvaz['raft']->saat))
                            {
                                $tt = explode(':',$parvaz['raft']->saat);
                                $sa = $tt[0];
                            }
                            echo $this->inc_model->generateOption(23,0,1,$sa);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه ورود
                    </small>
                    <select name="minute_v" style="width: 100%" >
                        <?php
                            $min = '';
                            if(isset($parvaz['raft']->saat_vorood))
                            {
                                $tt = explode(':',$parvaz['raft']->saat_vorood);
                                $min = $tt[1];
                            }
                            echo $this->inc_model->generateOption(59,0,1,$min);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت ورود
                    </small>
                    <select name="hour_v" style="width: 100%" >
                        <?php
                            $sa = '';
                            if(isset($parvaz['raft']->saat_vorood))
                            {
                                $tt = explode(':',$parvaz['raft']->saat_vorood);
                                $sa = $tt[0];
                            }
                            echo $this->inc_model->generateOption(23,0,1,$sa);
                        ?>
                    </select>
                    <input type="hidden" name="gohar_voucher_id" id="gohar_voucher_id" >
                </div>
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                <input type="checkbox" id="bargasht_check" name="bargasht_check" onchange="toggle_bargasht();" >
                پرواز برگشت
            </div>
            <div id="bargasht_div" >
                <div class="col-sm-2" >
                    ایرلاین
                    <select name="airline_b" style="width:100%" >
                        <option value="-1">
                            انتخاب 
                        </option>
                        <?php
                            echo airline_class::loadAll(isset($parvaz['bargasht']->airline)?$parvaz['bargasht']->airline:'');
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    کلاس پرواز
                    <input name="class_parvaz_b" class="form-control" placeholder="کلاس" value="<?php echo isset($parvaz['bargasht']->class_parvaz)?$parvaz['bargasht']->class_parvaz:''; ?>" >
                </div>
                <div class="col-sm-2" >
                    شماره پرواز
                    <input name="shomare_b" class="form-control" placeholder="شماره پرواز" value="<?php echo isset($parvaz['bargasht']->shomare)?$parvaz['bargasht']->shomare:''; ?>"  >
                </div>
                <div class="col-sm-6" >
                    هواپیما
                    <input name="airplain_b" class="form-control" placeholder="هواپیما" value="<?php echo isset($parvaz['bargasht']->airplain)?$parvaz['bargasht']->airplain:''; ?>" >
                </div>
                <div class="col-sm-2" >
                    تاریخ
                    <input name="tarikh_parvaz_b" id="tarikh_parvaz_b" readonly="readonly" class="form-control" placeholder="تاریخ" value="<?php echo isset($parvaz['bargasht']->tarikh)?jdate("Y/m/d",strtotime($parvaz['bargasht']->tarikh)):'';?>" >
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه خروج
                    </small>
                    <select name="minute_b" style="width: 100%" >
                        <?php
                            $min = '';
                            if(isset($parvaz['bargasht']->saat))
                            {
                                $tt = explode(':',$parvaz['bargasht']->saat);
                                $min = $tt[1];
                            }  
                            echo $this->inc_model->generateOption(59,0,1,$min);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت خروج
                    </small>
                    <select name="hour_b" style="width: 100%" >                
                        <?php
                            $sa = '';
                            if(isset($parvaz['bargasht']->saat))
                            {
                                $tt = explode(':',$parvaz['bargasht']->saat);
                                $sa = $tt[0];
                            }
                            echo $this->inc_model->generateOption(23,0,1,$sa);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه ورود
                    </small>
                    <select name="minute_v_b" style="width: 100%" >
                        <?php
                            $min = '';
                            if(isset($parvaz['bargasht']->saat_vorood))
                            {
                                $tt = explode(':',$parvaz['bargasht']->saat_vorood);
                                $min = $tt[1];
                            }
                            echo $this->inc_model->generateOption(59,0,1,$min);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت ورود
                    </small>
                    <select name="hour_v_b" style="width: 100%" >
                        <?php
                            $sa = '';
                            if(isset($parvaz['bargasht']->saat_vorood))
                            {
                                $tt = explode(':',$parvaz['bargasht']->saat_vorood);
                                $sa = $tt[0];
                            }
                            echo $this->inc_model->generateOption(23,0,1,$sa);
                        ?>
                    </select>
                    <input type="hidden" name="gohar_voucher_id_b" id="gohar_voucher_id_b" >
                </div>
            </div>
        </div>
        <?php
        } endif;
        if(in_array('2',$include_types) || in_array('3',$include_types)): {
        ?>
        <div class="row hs-border" id="hotel_div" >
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی هتل
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <small>
                تعداد اتاق:
                </small>
                <input readonly="readonly" class="hs-border" name="hotel_room_count" style="width: 40%" id="hotel_room_count" value="<?php echo isset($hot->room_count)?$hot->room_count:'0'; ?>" >
                <big><span class="glyphicon glyphicon-plus-sign pointer" onclick="showHotelExtra()" ></span></big>
                <input type="hidden" name="gohar_hotel_id" id="gohar_flight_id" >
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select class="zoor" id="city_to_hotel" name="city_to_hotel" style="width: 100%" <?php echo isset($parvaz['raft']->maghsad_id)?'disabled':''; ?>  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll(isset($parvaz['raft']->maghsad_id)?$parvaz['raft']->maghsad_id:(isset($hot->maghsad_id)?$hot->maghsad_id:''));
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control zoor" placeholder="از تاریخ" name="az_tarikh_hotel" id="az_tarikh_hotel" onblur="fillHotel(this)" value="<?php echo isset($parvaz['raft']->tarikh)?jdate("Y/m/d",strtotime($parvaz['raft']->tarikh)):(isset($hot->az_tarikh)?jdate("Y/m/d",strtotime($hot->az_tarikh)):'');?>" <?php echo isset($parvaz['raft']->tarikh)?'disabled':''; ?> >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control zoor" placeholder="تا تاریخ" name="ta_tarikh_hotel" id="ta_tarikh_hotel" onblur="fillShab(this)" value="<?php echo isset($parvaz['bargasht']->tarikh)?jdate("Y/m/d",strtotime($parvaz['bargasht']->tarikh)):(isset($hot->ta_tarikh)?jdate("Y/m/d",strtotime($hot->ta_tarikh)):'');?>" <?php echo isset($parvaz['bargasht']->tarikh)?'disabled':''; ?> >
            </div>
            <div id="nafarat_div" class="col-sm-12 hs-margin-up-down" >
                <?php
                    echo $nafarat;
                ?>
            </div>
            <div class="col-sm-12 hs-margin-up-down"  onclick="$(\'#hotel_results\').toggle()" >
                <a class="btn hs-btn-default" >
                    جستجوی هتل در گوهر
                </a>
            </div>
            <div class="col-sm-12" id="hotel_results" style="display: none;"  >
                
            </div>        
            <div class="col-sm-12 hs-gray hs-padding hs-border hs-margin-up-down" >
                ثبت دستی
            </div>
            <div class="col-sm-6" >
                <input type="hidden" name="hotel_id" value="<?php echo isset($hot->id)?$hot->id:'-1'; ?>">
                <input class="form-control zoor" name="hotel_name" placeholder="نام هتل" value="<?php echo isset($hot->name)?$hot->name:''; ?>" >
            </div>
            <div class="col-sm-1 text-left" >
                <select name="hotel_star" id="hotel_star" title="ستاره" style="width: 100%" >
                    <?php
                        echo $this->inc_model->generateOption(5,1,-1,isset($hot->star)?$hot->star:-1);
                    ?>
                </select>
            </div>
            <div class="col-sm-1 text-right" >
                ستاره
            </div>
            <div class="col-sm-2" >
                <input readonly="readonly" class="form-control" name="hotel_az_tarikh" id="hotel_az_tarikh" placeholder="از تاریخ" value="<?php echo isset($parvaz['raft']->tarikh)?jdate("Y/m/d",strtotime($parvaz['raft']->tarikh)):(isset($hot->az_tarikh)?jdate("Y/m/d",strtotime($hot->az_tarikh)):''); ?>" >
            </div>
            <div class="col-sm-2" >
                <input readonly="readonly" class="form-control" name="hotel_shab" placeholder="تعداد شب" value="<?php echo $shab; ?>" >
            </div>
            <div id="hotel_extra_div" >
                <?php
                    echo $hot_det;
                ?>
            </div>
        </div>
        <?php
        } endif;
        ?>
        <div class="hs-float-left hs-margin-up-down">
            <a class="btn hs-btn-default btn-lg" onclick="contin()" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        </div>
    </form>
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
    var hotel_info_index = 0;
    $(document).ready(function(){
        $("#raft_div :input").prop("disabled",true);
        $("#bargasht_div :input").prop("disabled",true);
    });
    function loadCity(inp)
    {
        ob = { "s_country_id":$(inp).val()};
        $("#hotel_city_div").html("<img src='<?php echo asset_url(); ?>img/stat.gif' >");
        $.get("<?php echo site_url() ?>khadamat_1",ob,function(res){
            console.log(res);
            var tt = '<select id="city_to" name="city_to" style="width: 100%"  ><option value="-1">شهر مقصد</option>'+res+'</select>';
            $("#hotel_city_div").html(tt);
            $('#hotel_city_div :select').select2({dir:'rtl'});
        });
    }
    function fillRaft(inp)
    {
        setTimeout(function(){
            var tt  = $(inp).val().split('/');
            if(tt.length>1)
            {    
                var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
                $(inp).val(newd);
                $("#tarikh_parvaz").val(newd);
                if($("#az_tarikh_hotel").length>0)
                {
                    $("#az_tarikh_hotel").val(newd);
                    $("#az_tarikh_hotel").prop("disabled",true);
                    $("#hotel_az_tarikh").val(newd);
                    $("#hotel_az_tarikh").prop("disabled",true);
                }    
            }    
        },300);
    }
    function fillBargasht(inp)
    {
        setTimeout(function(){
            var tt  = $(inp).val().split('/');
            if(tt.length>1)
            {
                var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
                $(inp).val(newd);
                $("#tarikh_parvaz_b").val(newd);
                if($("#ta_tarikh_hotel").length>0)
                {
                    $("#ta_tarikh_hotel").val(newd);
                    $("#ta_tarikh_hotel").prop("disabled",true);
                } 
            }
        },300);
    }
    function toggle_raft()
    {
        var tt  = $("#az_tarikh").val().split('/');
        if(tt.length>1)
        {
            var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
            $("#az_tarikh").val(newd);
            $("#tarikh_parvaz").val(newd);
            if($("#az_tarikh_hotel").length>0)
            {
                $("#az_tarikh_hotel").val(newd);
                $("#az_tarikh_hotel").prop("disabled",true);
                $("#hotel_az_tarikh").val(newd);
                $("#hotel_az_tarikh").prop("disabled",true);
            } 
        }
        if($("#raft_div :input").prop("disabled"))
        {    
            $("#raft_div :input").prop("disabled",false);
            $("#raft_div :input").css("border","1px solid #3c6e8f");
            $("#raft_div").find(".select2-selection").css("border","solid 1px #3c6e8f");
        }    
        else
        {    
            $("#raft_div :input").prop("disabled",true);
            $("#raft_div :input").css("border","1px solid rgb(169, 169, 169)");
            $("#raft_div").find(".select2-selection").css("border","1px solid rgb(169, 169, 169)");
        }    
    }
    function toggle_bargasht()
    {
        var tt  = $("#ta_tarikh").val().split('/');
        if(tt.length>1)
        {
            var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
            $("#ta_tarikh").val(newd);
            $("#tarikh_parvaz_b").val(newd);
            if($("#ta_tarikh_hotel").length>0)
            {
                $("#ta_tarikh_hotel").val(newd);
                $("#ta_tarikh_hotel").prop("disabled",true);
            } 
        }
        if($("#bargasht_div :input").prop("disabled"))
        {    
            $("#bargasht_div :input").prop("disabled",false);
            $("#bargasht_div :input").css("border","1px solid #3c6e8f");
            $("#bargasht_div").find(".select2-selection").css("border","solid 1px #3c6e8f");
        }    
        else
        {    
            $("#bargasht_div :input").prop("disabled",true);
            $("#bargasht_div :input").css("border","1px solid rgb(169, 169, 169)");
            $("#bargasht_div").find(".select2-selection").css("border","1px solid rgb(169, 169, 169)");
        }    
    }
    function showHotelExtra()
    {
        var i = parseInt($("#hotel_room_count").val(),10)+1;
        $("#hotel_room_count").val(i);
        i--;
        hotel_info_index++;
        var tt = "<div class='col-sm-2 hs-margin-up-down text-center' >\
                    نام اتاق \
                    <input type='text' class='form-control zoor' name='room_name[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>ظرفیت </small>\
                    <select name='zarfiat[]' class='hotel_extra zoor' title='ظرفیت' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
                    </select> \
                </div>\
                <div class='col-sm-2 hs-margin-up-down text-center' >\
                    <small>\
                        سرویس اضافه بزرگسال </small>\
                    <select name='extra_service[]' class='hotel_extra' title='سرویس اضافه بزرگسال' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
                    </select> \
                </div>\
                <div class='col-sm-2 hs-margin-up-down text-center' >\
                    <small>\
                        سرویس اضافه کودک </small>\
                    <select name='extra_service_chd[]' class='hotel_extra' title='سرویس اضافه کودک' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
                    </select> \
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    گشت\
                    </small>\
                    <input class='form-control' type='checkbox' name='gasht[#inx#]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. رفت\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_raft[#inx#]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. میانی\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_vasat[#inx#]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. برگشت\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_bargasht[#inx#]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    پذیرایی\
                    </small>\
                    <input class='form-control' type='checkbox' name='paziraii[#inx#]' >\
                </div>";
        var nafarat = '<div class="col-sm-4 hs-margin-up-down" > \
                تعداد بزرگسال: \
                <select name="hotel_adl[]" style="width: 50px;" class="hotel_extra" >\
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>\
                </select>\
            </div>\
            <div class="col-sm-4 hs-margin-up-down" >\
                تعداد کودک: \
                <select name="hotel_chd[]" style="width: 50px;" class="hotel_extra" >\
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>\
                </select>\
            </div> \
            <div class="col-sm-3 hs-margin-up-down" >\
                تعداد نوزاد: \
                <select name="hotel_inf[]" style="width: 50px;" class="hotel_extra" >\
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>\
                </select>\
            </div>\
            <div class="col-sm-1 hs-margin-up-down" >\
                <big><span class="glyphicon glyphicon-minus-sign" onclick="remove_row(this)" ></span></big>\n\
                <input type="hidden" name="hotel_khadamat_id[]" value="-1" >\
            </div>';                
        var tedad = parseInt($("#hotel_room_count").val(),10);
        var tmp1='';
        //$("#hotel_extra_div").html('');
        //$("#nafarat_div").html('');
        
        tmp1 = "<div id='extra_info_new_"+hotel_info_index+"' >"+tt.replace(/#inx#/g,i)+"</div>";
        $("#hotel_extra_div").append(tmp1);
        $("#nafarat_div").append('<div id="hotel_nafar_new_'+hotel_info_index+'" >'+nafarat+'</div>');
        
        $(".hotel_extra") .select2({
            dir:"rtl"
        });
    }
    function changeHotelCity()
    {
        if($("#city_to_hotel").length>0)
        {
            $("#city_to_hotel").val($("#city_to").val());
            $("#city_to_hotel").prop("disabled",true);
            $("#city_to_hotel").select2({
                dir:"rtl"
            });
        }   
    }
    function fillHotel(inp)
    {
        setTimeout(function(){
            var tt  = $(inp).val().split('/');
            if(tt.length>1)
            {    
                var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
                $(inp).val(newd);
                $("#hotel_az_tarikh").val(newd);
                $("#hotel_az_tarikh").prop("disabled",true);   
            }    
        },100);
    }
    function remove_row(inp)
    {
        var tmp = ($(inp).parent().parent().parent().prop('id'));
        $(inp).parent().parent().parent().remove();
        if(tmp.split('_')[2]==='new')
        {
            hotel_info_index--;
        }
        var i = parseInt($("#hotel_room_count").val(),10)-1;
        $("#hotel_room_count").val(i);
        $("#extra_info_new_"+tmp.split('_')[3]).remove();
        $("#extra_info_"+tmp.split('_')[3]).remove();
    }
    function fillShab(inp)
    {
        setTimeout(function(){
            var tt  = $(inp).val().split('/');
            if(tt.length>1)
            {    
                var newd = tt[2]+'/'+tt[1]+'/'+tt[0];
                $(inp).val(newd);
                $("#hotel_az_tarikh").val(newd);
                $("#hotel_az_tarikh").prop("disabled",true);   
            }    
        },100);
    }
    function contin()
    {
        if(valid_frm())
        {    
            if($("az_tarikh").length>0)
            {
                $("az_tarikh_hotel").val($("az_tarikh").val());
            }
            if($("ta_tarikh").length>0)
            {
                $("ta_tarikh_hotel").val($("az_tarikh").val());
            }
            $("#raft_div :input").prop("disabled",false);
            $("#bargasht_div :input").prop("disabled",false);
            $("#hotel_div :input").prop("disabled",false);;
            $("#frm_khadamat_1").submit();
        }
        else
            alert('موارد مشخص شده را وارد کنید');
    }
    function valid_frm()
    {
        var ou= true;
        $(".zoor").css("border","1px solid rgb(204, 204, 204)");
        $(".select2-selection").css("border","1px solid rgb(204, 204, 204)");
        $.each($(".zoor"),function(id,field){
            if($(field).is("input"))
            {
                if($(field).val()==='')
                {
                    $(field).css("border","solid 1px #ff0000");
                    ou=false;
                }
                if($("#hotel_room_count").val()==='0')
                {
                    $("#hotel_room_count").css("border","solid 1px #ff0000");
                    ou=false;
                }    
            }
            else if($(field).is("select"))
            {
                if($(field).val()==='-1')
                {
                    console.log($(field).val());
                    $(field).parent().find(".select2-selection").css("border","solid 1px #ff0000");
                    ou=false;
                }    
            }
        });
        return (ou);
    }
</script>