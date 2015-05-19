<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if($this->input->post('city_from')!==FALSE)
    {
        $parvaz1['mabda_id']= (int)$this->input->post('city_from');
        $parvaz1['maghsad_id']= (int)$this->input->post('city_to');
        $parvaz1['adl']= (int)$this->input->post('adl');
        $parvaz1['chd']= (int)$this->input->post('chd');
        $parvaz1['inf']= (int)$this->input->post('inf');
        $parvaz1['airline']= ($this->input->post('airline'));
        $parvaz1['tarikh']= $this->inc_model->jalaliToMiladi($this->input->post('tarikh_parvaz'));
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
        $parvaz2['tarikh']= $this->inc_model->jalaliToMiladi($this->input->post('tarikh_parvaz_b'));
        $parvaz2['airplain']= ($this->input->post('airplain_b'));
        $parvaz2['saat']= (int)$this->input->post('hour_b').':'.(int)$this->input->post('minute_b');
        $parvaz2['saat_vorood']= (int)$this->input->post('hour_v_b').':'.(int)$this->input->post('minute_v_b');
        $parvaz2['shomare'] = ($this->input->post('shomare_b'));
        $parvaz2['is_bargasht'] = 1;
        $parvaz2['class_parvaz']= ($this->input->post('class_parvaz_b'));
        $parvaz2['factor_id'] = (int)$p1;
        $parvaz2['khadamat_factor_id'] = parvaz_class::loadKhadamat_factor_id((int)$p1);
        $gohar_voucher_id_b=11111;
        $parvaz1['gohar_voucher_id'] = ($this->input->post('bargasht_check')!==FALSE?-1:$gohar_voucher_id_b);
        $parvaz1['parvaz_id'] =(int) $this->input->post('parvaz_id_b');
        parvaz_class::add($parvaz2);
    }
    if($this->input->post('city_to_hotel')!==FALSE)
    {
        //var_dump($_REQUEST);
        $hotel['maghsad_id'] = (int)$this->input->post('city_to_hotel');
        $hotel['az_tarikh'] = $this->inc_model->jalaliToMiladi($this->input->post('az_tarikh_hotel'));
        $hotel['ta_tarikh'] = $this->inc_model->jalaliToMiladi($this->input->post('ta_tarikh_hotel'));
        $hotel['adl'] = (int)$this->input->post('hotel_adl');
        $hotel['chd'] = (int)$this->input->post('hotel_chd');
        $hotel['inf'] = (int)$this->input->post('hotel_inf');
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
        hotel_class::add($hotel,$hotel_room);
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
                    '.$this->inc_model->generateOption(9,1,1,(int)$hot_room[$j]['adl']).'
                </select>
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد کودک:
                <select name="hotel_chd[]" style="width: 50px;" class="hotel_extra" >
                    '.$this->inc_model->generateOption(9,1,1,(int)$hot_room[$j]['chd']).'
                </select>
            </div>
            <div class="col-sm-3 hs-margin-up-down" >
                تعداد نوزاد: 
                <select name="hotel_inf[]" style="width: 50px;" class="hotel_extra" >
                    '.$this->inc_model->generateOption(9,1,1,(int)$hot_room[$j]['inf']).'
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
    <form action="" method="POST" >
    <div class="col-sm-10" >
        <?php if(in_array('1',$include_types) || in_array('3',$include_types)): { ?>
        <div class="row hs-border hs-margin-up-down">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی پرواز
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input type="hidden" name="parvaz_id" value="<?php echo isset($parvaz['raft'])?$parvaz['raft']->id:-1; ?>">
                <input type="hidden" name="parvaz_id_b" value="<?php echo isset($parvaz['bargasht'])?$parvaz['bargasht']->id:-1; ?>" >
                <select id="city_from" name="city_from" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
                    <?php
                        echo city_class::loadAll(isset($parvaz['raft']->mabda_id)?$parvaz['raft']->mabda_id:'');
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select id="city_to" name="city_to" style="width: 100%" onchange="changeHotelCity();" >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll(isset($parvaz['bargasht']->mabda_id->maghsad_id)?$parvaz['bargasht']->maghsad_id:'');
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" onblur="fillRaft(this);" name="az_tarikh" id="az_tarikh" value="<?php echo isset($parvaz['raft']->tarikh)?jdate("Y/m/d",strtotime($parvaz['raft']->tarikh)):'';?>" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" onblur="fillBargasht(this)" name="ta_tarikh" id="ta_tarikh" value="<?php echo isset($parvaz['bargasht']->tarikh)?jdate("Y/m/d",strtotime($parvaz['bargasht']->tarikh)):'';?>" >
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد بزرگسال: 
                <select name="adl" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,1,1); ?>
                </select>
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد کودک: 
                <select name="chd" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>
                </select>
            </div> 
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد نوزاد: 
                <select name="inf" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>
                </select>
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                <a class="btn hs-btn-default" onclick="$('#flight_results').toggle()">
                    جستجو درگوهر
                </a>
            </div>
            <div class="col-sm-12" id="flight_results" style="display: none;"  >
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td>
                            
                        </td>
                        <td>
                            ایرلاین
                        </td>
                        <td>
                            شماره
                        </td>
                        <td>
                            تاریخ
                        </td>
                        <td>
                            ساعت
                        </td>
                        <td>
                            تأمین کننده
                        </td>
                        <td>
                            ظرفیت
                        </td>
                        <td>
                            قسمت
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" >
                        </td>
                        <td>
                            آتا
                        </td>
                        <td>
                            5264
                        </td>
                        <td>
                            1394-02-23
                        </td>
                        <td>
                            22:40
                        </td>
                        <td>
                            سامان سیر رسپینا
                        </td>
                        <td>
                            7
                        </td>
                        <td>
                            1,080,000
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" >
                        </td>
                        <td>
                            ایران ایر
                        </td>
                        <td>
                            269
                        </td>
                        <td>
                            1394-02-23
                        </td>
                        <td>
                            22:20
                        </td>
                        <td>
                            سامان سیر رسپینا
                        </td>
                        <td>
                            5
                        </td>
                        <td>
                            1,100,000
                        </td>
                    </tr>
                </table>
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
                    <select name="airline" style="width:100%" >
                        <option value="-1">
                            انتخاب ایرلاین
                        </option>
                        <option value="ایران ایر">
                            ایران ایر
                        </option>
                        <option value="آتا">
                            آتا
                        </option>
                    </select>
                </div>
                <div class="col-sm-2" >
                    کلاس پرواز
                    <input name="class_parvaz" class="form-control" placeholder="کلاس"  >
                </div>
                <div class="col-sm-2" >
                    شماره پرواز
                    <input name="shomare" class="form-control" placeholder="شماره پرواز"  >
                </div>
                <div class="col-sm-6" >
                    هواپیما
                    <input name="airplain" class="form-control" placeholder="هواپیما"  >
                </div>
                <div class="col-sm-2" >
                    تاریخ
                    <input name="tarikh_parvaz" id="tarikh_parvaz" readonly="readonly" class="form-control" placeholder="تاریخ"  >
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه خروج
                    </small>
                    <select name="minute" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(59,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت خروج
                    </small>
                    <select name="hour" style="width: 100%" >                
                        <?php
                            echo $this->inc_model->generateOption(23,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه ورود
                    </small>
                    <select name="minute_v" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(59,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت ورود
                    </small>
                    <select name="hour_v" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(23,0,1);
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
                            انتخاب ایرلاین
                        </option>
                        <option value="ایران ایر">
                            ایران ایر
                        </option>
                        <option value="آتا">
                            آتا
                        </option>
                    </select>
                </div>
                <div class="col-sm-2" >
                    کلاس پرواز
                    <input name="class_parvaz_b" class="form-control" placeholder="کلاس"  >
                </div>
                <div class="col-sm-2" >
                    شماره پرواز
                    <input name="shomare_b" class="form-control" placeholder="شماره پرواز"  >
                </div>
                <div class="col-sm-6" >
                    هواپیما
                    <input name="airplain_b" class="form-control" placeholder="هواپیما"  >
                </div>
                <div class="col-sm-2" >
                    تاریخ
                    <input name="tarikh_parvaz_b" id="tarikh_parvaz_b" readonly="readonly" class="form-control" placeholder="تاریخ"  >
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه خروج
                    </small>
                    <select name="minute_b" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(59,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت خروج
                    </small>
                    <select name="hour_b" style="width: 100%" >                
                        <?php
                            echo $this->inc_model->generateOption(23,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    دقیقه ورود
                    </small>
                    <select name="minute_v_b" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(59,0,1);
                        ?>
                    </select>
                </div>
                <div class="col-sm-2" >
                    <small>
                    ساعت ورود
                    </small>
                    <select name="hour_v_b" style="width: 100%" >
                        <?php
                            echo $this->inc_model->generateOption(23,0,1);
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
        <div class="row hs-border">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی هتل
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <small>
                تعداد اتاق:
                </small>
                <input readonly="readonly" class="hs-border" name="hotel_room_count" style="width: 40%" id="hotel_room_count" value="<?php echo isset($hot->room_count)?$hot->room_count:''; ?>" >
                <big><span class="glyphicon glyphicon-plus-sign pointer" onclick="showHotelExtra()" ></span></big>
                <input type="hidden" name="gohar_hotel_id" id="gohar_flight_id" >
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select id="city_to_hotel" name="city_to_hotel" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll(isset($hot->maghsad_id)?$hot->maghsad_id:'');
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" name="az_tarikh_hotel" id="az_tarikh_hotel" onblur="fillHotel(this)" value="<?php echo isset($hot->az_tarikh)?jdate("Y/m/d",strtotime($hot->az_tarikh)):'';?>" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" name="ta_tarikh_hotel" id="ta_tarikh_hotel" onblur="fillShab(this)" value="<?php echo isset($hot->ta_tarikh)?jdate("Y/m/d",strtotime($hot->ta_tarikh)):'';?>" >
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
                <table class="table table-bordered table-responsive">
                    <tr>
                        <td>
                            
                        </td>
                        <td>
                            نام هتل
                        </td>
                        <td>
                            تاریخ
                        </td>
                        <td>
                            نوع اتاق
                        </td>
                        <td>
                            قیمت
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" >
                        </td>
                        <td>
                            شایان
                        </td>
                        <td>
                            1394-02-23
                        </td>
                        <td>
                            دوتخته
                        </td>
                        <td>
                            1,080,000
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" >
                        </td>
                        <td>
                         آراد
                        </td>
                        <td>
                            1394-02-23
                        </td>
                        <td>
                            سوئیت
                        </td>
                        <td>
                            1,100,000
                        </td>
                    </tr>
                </table>
            </div>        
            <div class="col-sm-12 hs-gray hs-padding hs-border hs-margin-up-down" >
                ثبت دستی
            </div>
            <div class="col-sm-6" >
                <input type="hidden" name="hotel_id" value="<?php echo isset($hot->id)?$hot->id:'-1'; ?>">
                <input class="form-control" name="hotel_name" placeholder="نام هتل" value="<?php echo isset($hot->name)?$hot->name:''; ?>" >
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
                <input readonly="readonly" class="form-control" name="hotel_az_tarikh" id="hotel_az_tarikh" placeholder="از تاریخ" value="<?php echo isset($hot->az_tarikh)?jdate("Y/m/d",strtotime($hot->az_tarikh)):''; ?>" >
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
            <button href="" class="btn hs-btn-default btn-lg" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
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
        },100);
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
        },100);
    }
    function toggle_raft()
    {
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
                    <input type='text' class='form-control' name='room_name[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>ظرفیت </small>\
                    <select name='zarfiat[]' class='hotel_extra' title='ظرفیت' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
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
                    <?php echo $this->inc_model->generateOption(9,1,1); ?>\
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
</script>