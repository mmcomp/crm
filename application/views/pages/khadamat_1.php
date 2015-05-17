<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if($this->input->get('s_country_id')!==FALSE)
    {
        $out=city_class::loadAll($this->input->get('s_country_id'));
        die($out);
    }    
    if((int)$p1==0)
    {
        show_404();
    }
    //$include_types=array();
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
    <form action="khadamat_2">
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
                <select id="city_to" name="city_to" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" >
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
                پرواز رفت
            </div>
            <div class="col-sm-2" >
                 <select id="city_from" name="city_from_manual" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
                <select id="city_to" name="city_to" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
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
                <input class="dateValue2 form-control" placeholder="تاریخ" name="tarikh_parvaz" >
            </div>
            <div class="col-sm-2" >
                <select name="hour" style="width: 100%" >
                    <option value="-1">
                         ساعت
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(23,1,1);
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
                <select name="minute" style="width: 100%" >
                    <option value="-1">
                         دقیقه
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(59,1,1);
                    ?>
                </select>
            </div>
            <div class="col-sm-12 hs-margin-up-down"  >
                پرواز برگشت
            </div>
            <div class="col-sm-2" >
                 <select id="city_from" name="city_from_manual_b" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
                <select id="city_to" name="city_to_b" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
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
                <input class="dateValue2 form-control" placeholder="تاریخ" name="tarikh_parvaz_b" >
            </div>
            <div class="col-sm-2" >
                <select name="hour_b" style="width: 100%" >
                    <option value="-1">
                         ساعت
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(23,1,1);
                    ?>
                </select>
            </div>
            <div class="col-sm-2" >
                <select name="minute_b" style="width: 100%" >
                    <option value="-1">
                         دقیقه
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(59,1,1);
                    ?>
                </select>
            </div>
            <div class="col-sm-12 hs-margin-up-down">
                <a class="btn hs-btn-default" >
                    ذخیره
                </a>
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
            <div class="col-sm-6 col-sm-offset-6 hs-margin-up-down" >
                <select id="city_to" name="city_to_hotel" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <?php
                        echo city_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" >
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد بزرگسال: 
                <select name="hotel_adl" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,1,1); ?>
                </select>
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد کودک: 
                <select name="hotel_chd" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>
                </select>
            </div> 
            <div class="col-sm-4 hs-margin-up-down" >
                تعداد نوزاد: 
                <select name="hotel_inf" style="width: 50px;" >
                    <?php echo $this->inc_model->generateOption(9,0,1); ?>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  onclick="$('#hotel_results').toggle()" >
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
            <div class="col-sm-2" >
                <select id="country_to" name="country_to" style="width: 100%" onchange="loadCity(this);" >
                    <option value="-1">
                        کشور مقصد
                    </option>
                    <?php
                        echo country_class::loadAll();
                    ?>
                </select>
            </div>
            <div class="col-sm-2" id="hotel_city_div" >
                <select id="city_to" name="city_to" style="width: 100%"  >
                    <option value="-1">
                        شهر مقصد
                    </option>
                </select>
            </div>
            <div class="col-sm-2" >
                <input class="form-control" name="hotel_name" placeholder="نام هتل" >
            </div>
            <div class="col-sm-2" >
                <input class="dateValue2 form-control" name="hotel_az_tarikh" placeholder="از تاریخ" >
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
            <div class="col-sm-2" >
                <select class="form-control" name="hotel_room_type" style="width: 100%">
                    <option value="-1" >
                        نوع اتاق
                    </option>
                    <option value="1" >
                        دوتخته
                    </option>   
                    <option value="2" >
                        سوئیت
                    </option> 
                </select>
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                ستاره
                <select name="hotel_star" id="hotel_star" title="ستاره" style="width: 100%" >
                    <option value="-1" >
                        انتخاب  
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(5,1,-1);
                    ?>
                </select>
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                سرویس اضافه
                <select name="extra_service" id="hotel_star" title="سرویس اضافه" style="width: 100%" >
                    <option value="-1" >
                        انتخاب  
                    </option>
                    <?php
                        echo $this->inc_model->generateOption(5,1,-1);
                    ?>
                </select>
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                گشت
                <input class="form-control" type="checkbox" >
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                ترانسفر رفت
                <input class="form-control" type="checkbox" >
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                ترانسفر میانی
                <input class="form-control" type="checkbox" >
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                ترانسفر برگشت
                <input class="form-control" type="checkbox" >
            </div>
            <div class="col-sm-2 hs-margin-up-down text-center" >
                پذیرایی
                <input class="form-control" type="checkbox" >
            </div>

            <div class="col-sm-12 hs-margin-up-down">
                <a class="btn hs-btn-default" >
                ذخیره
                </a>
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
    function loadCity(inp)
    {
        ob = { "s_country_id":$(inp).val()};
        $("#hotel_city_div").html("<img src='<?php echo asset_url(); ?>img/stat.gif' >");
        $.get("<?php echo site_url() ?>khadamat_1",ob,function(res){
            console.log(res);
            var tt = '<select id="city_to" name="city_to" style="width: 100%"  ><option value="-1">شهر مقصد</option>'+res+'</select>';
            $("#hotel_city_div").html(tt);
            $('#hotel_city_div select').select2({dir:'rtl'});
        });
    }  
</script>