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
        $parvaz1['airline']= mysql_real_escape_string($this->input->post('airline'));
        $parvaz1['tarikh']= $this->inc_model->jalaliToMiladi($this->input->post('tarikh_parvaz'));
        $parvaz1['airplain']= mysql_real_escape_string($this->input->post('airplain'));
        $parvaz1['saat']= (int)$this->input->post('hour').':'.(int)$this->input->post('minute');
        $parvaz1['saat_vorood']= (int)$this->input->post('hour_v').':'.(int)$this->input->post('minute_v');
        $parvaz1['shomare'] = mysql_real_escape_string($this->input->post('shomare'));
        $parvaz1['is_bargasht'] = 0;
        $parvaz1['class_parvaz']= mysql_real_escape_string($this->input->post('class_parvaz'));
        $parvaz1['factor_id'] = (int)$p1;
        $parvaz1['khadamat_factor_id'] = parvaz_class::loadKhadamat_factor_id((int)$p1);
        $gohar_voucher_id=11111;
        $parvaz1['gohar_voucher_id'] = ($this->input->post('raft_check')!==FALSE?-1:$gohar_voucher_id);
        parvaz_class::add($parvaz1);
        
        $parvaz2['mabda_id']= (int)$this->input->post('city_to');
        $parvaz2['maghsad_id']= (int)$this->input->post('city_from');
        $parvaz2['adl']= (int)$this->input->post('adl');
        $parvaz2['chd']= (int)$this->input->post('chd');
        $parvaz2['inf']= (int)$this->input->post('inf');
        $parvaz2['airline']= mysql_real_escape_string($this->input->post('airline_b'));
        $parvaz2['tarikh']= $this->inc_model->jalaliToMiladi($this->input->post('tarikh_parvaz_b'));
        $parvaz2['airplain']= mysql_real_escape_string($this->input->post('airplain_b'));
        $parvaz2['saat']= (int)$this->input->post('hour_b').':'.(int)$this->input->post('minute_b');
        $parvaz2['saat_vorood']= (int)$this->input->post('hour_v_b').':'.(int)$this->input->post('minute_v_b');
        $parvaz2['shomare'] = mysql_real_escape_string($this->input->post('shomare_b'));
        $parvaz2['is_bargasht'] = 1;
        $parvaz2['class_parvaz']= mysql_real_escape_string($this->input->post('class_parvaz_b'));
        $parvaz2['factor_id'] = (int)$p1;
        $parvaz2['khadamat_factor_id'] = parvaz_class::loadKhadamat_factor_id((int)$p1);
        $gohar_voucher_id_b=11111;
        $parvaz1['gohar_voucher_id'] = ($this->input->post('bargasht_check')!==FALSE?-1:$gohar_voucher_id_b);
        parvaz_class::add($parvaz2);
    }
    if($this->input->post('city_to_hotel')!==FALSE)
    {
        $hotel['maghsad_id'] = (int)$this->input->post('city_to_hotel');
        $hotel['az_tarikh'] = $this->inc_model->jalaliToMiladi($this->input->post('az_tarikh_hotel'));
        $hotel['ta_tarikh'] = $this->inc_model->jalaliToMiladi($this->input->post('ta_tarikh_hotel'));
        $hotel['adl'] = (int)$this->input->post('hotel_adl');
        $hotel['chd'] = (int)$this->input->post('hotel_chd');
        $hotel['inf'] = (int)$this->input->post('hotel_inf');
        $hotel['name'] = trim($this->input->post('hotel_name'));
        $hotel['star'] = (int)$this->input->post('hotel_star');
        $hotel['room_count'] = (int)$this->input->post('room_count');
        $hotel['factor_id'] = (int)$p1;
        $hotel['khadamat_factor_id'] = hotel_class::loadKhadamat_factor_id((int)$p1);
        hotel_class::add($hotel);
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
    <form action="" method="POST" >
    <div class="col-sm-10" >
        <?php if(in_array('1',$include_types) || in_array('3',$include_types)): { ?>
        <div class="row hs-border hs-margin-up-down">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی پرواز
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <select id="city_from" name="city_from" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select id="city_to" name="city_to" style="width: 100%" onchange="changeHotelCity();" >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" onblur="fillRaft(this);" name="az_tarikh" id="az_tarikh" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" onblur="fillBargasht(this)" name="ta_tarikh" id="ta_tarikh" >
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
                <select class="form-control" name="hotel_room_count" id="hotel_room_count" style="width: 100%" onchange="showHotelExtra()" >
                    <option value="-1" >
                        تعداد اتاق
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(6,1,1);
                    ?>
                </select>
                <input type="hidden" name="gohar_hotel_id" id="gohar_flight_id" >
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select id="city_to_hotel" name="city_to_hotel" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" name="az_tarikh_hotel" id="az_tarikh_hotel" onblur="fillHotel(this)" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" name="ta_tarikh_hotel" id="ta_tarikh_hotel" onblur="fillShab(this)" >
            </div>
            <div id="nafarat_div" class="col-sm-12 hs-margin-up-down" >
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
                <input class="form-control" name="hotel_name" placeholder="نام هتل" >
            </div>
            <div class="col-sm-1 text-left" >
                <select name="hotel_star" id="hotel_star" title="ستاره" style="width: 100%" >
                    <?php
                        echo $this->inc_model->generateOption(5,1,-1);
                    ?>
                </select>
            </div>
            <div class="col-sm-1 text-right" >
                ستاره
            </div>
            <div class="col-sm-2" >
                <input class="dateValue2 form-control" name="hotel_az_tarikh" id="hotel_az_tarikh" placeholder="از تاریخ" >
            </div>
            <div class="col-sm-2" >
                <select class="form-control" name="hotel_shab" style="width: 100%">
                    <option value="-1" >
                        تعداد شب
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(9,1,1);
                    ?>
                </select>
            </div>
            
            <div id="hotel_extra_div" ></div>
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
        var tt = "<div class='col-sm-3 hs-margin-up-down text-center' >\
                    نام اتاق \
                    <input type='text' class='form-control' name='room_name[]' >\
                </div>\
                <div class='col-sm-2 hs-margin-up-down text-center' >\
                    ظرفیت بزرگسال\
                    <select name='extra_service[]' class='hotel_extra' title='سرویس اضافه' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
                    </select> \
                </div>\
                <div class='col-sm-2 hs-margin-up-down text-center' >\
                    ظرفیت کودک\
                    <select name='extra_service[]' class='hotel_extra' title='سرویس اضافه' style='width: 100%' > <?php echo str_replace('"','\"',$this->inc_model->generateOption(5,0,1)); ?>\
                    </select> \
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    گشت\
                    </small>\
                    <input class='form-control' type='checkbox' name='gasht[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. رفت\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_raft[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. میانی\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_vasat[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    ت. برگشت\
                    </small>\
                    <input class='form-control' type='checkbox' name='transfer_bargasht[]' >\
                </div>\
                <div class='col-sm-1 hs-margin-up-down text-center' >\
                    <small>\
                    پذیرایی\
                    </small>\
                    <input class='form-control' type='checkbox' name='paziraii[]' >\
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
            <div class="col-sm-4 hs-margin-up-down" >\
                تعداد نوزاد: \
                <select name="hotel_inf[]" style="width: 50px;" class="hotel_extra" >\
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>\
                </select>\
            </div>\
            ';                
        var tedad = parseInt($("#hotel_room_count").val(),10);
        $("#hotel_extra_div").html('');
        $("#nafarat_div").html('');
        for(var i=0;i<tedad;i++)
        {
            $("#hotel_extra_div").append(tt);
            $("#nafarat_div").append(nafarat);
        }
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
</script>