<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if(isset($_REQUEST['khadamat']))
    {
        //var_dump($_REQUEST);
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
        <div class="row hs-border hs-margin-up-down">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی پرواز
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <select id="city_from" name="city_from" style="width: 100%" >
                    <option value="-1">
                        انتخاب مبدأ
                    </option>
<<<<<<< HEAD
                    <?php
                        echo city_class::loadAll();
                    ?>
=======
                    <option value="1">
                        مشهد
                    </option>
                    <option value="2">
                        تهران
                    </option>
                    <option value="3">
                        شیراز
                    </option>
                    <option value="4">
                        تبریز
                    </option>
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                <select id="city_to" name="city_to" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
<<<<<<< HEAD
                    <?php
                        echo city_class::loadAll();
                    ?>
=======
                    <option value="1">
                        مشهد
                    </option>
                    <option value="2">
                        تهران
                    </option>
                    <option value="3">
                        شیراز
                    </option>
                    <option value="4">
                        تبریز
                    </option>
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" >
            </div>
<<<<<<< HEAD
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
            <div class="col-sm-12" >
                ثبت دستی
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
                <input type="text" placeholder="ایرلاین"  >
            </div>
=======
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
            <div class="col-sm-6 offset6 hs-margin-up-down"  >
                <a class="btn hs-btn-default" onclick="$('#flight_results').toggle()">
                    جستجو
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
        </div>
        <div class="row hs-border">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border"  >
                جستجوی هتل
            </div>
            <div class="col-sm-6 col-sm-offset-6 hs-margin-up-down" >
                <select id="city_to" name="city_to_hotel" style="width: 100%"  >
                    <option value="-1">
                        انتخاب مقصد
                    </option>
                    <option value="1">
                        مشهد
                    </option>
                    <option value="2">
                        تهران
                    </option>
                    <option value="3">
                        شیراز
                    </option>
                    <option value="4">
                        تبریز
                    </option>
                </select>
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="از تاریخ" >
            </div>
            <div class="col-sm-6 hs-margin-up-down"  >
                <input class="dateValue2 form-control" placeholder="تا تاریخ" >
            </div>
<<<<<<< HEAD
            <div class="col-sm-6 hs-margin-up-down"  onclick="$('#hotel_results').toggle()" >
=======
            <div class="col-sm-6 hs-margin-up-down"  >
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
                <a class="btn hs-btn-default" >
                    جستجو
                </a>
            </div>
<<<<<<< HEAD
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
                            ساعت
                        </td>
                        <td>
                            تأمین کننده
                        </td>
                        <td>
                            ظرفیت
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
                            22:40
                        </td>
                        <td>
                            سامان سیر رسپینا
                        </td>
                        <td>
                            7
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
                            22:20
                        </td>
                        <td>
                            سامان سیر رسپینا
                        </td>
                        <td>
                            5
                        </td>
                        <td>
                            سوئیت
                        </td>
                        <td>
                            1,100,000
                        </td>
                    </tr>
                </table>
            </div>        </div>
=======
            <div class="col-sm-12" id="hotel_results"  >
                
            </div>
        </div>
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
    </div>
    <div class="hs-float-left hs-margin-up-down">
        <button href="" class="btn hs-btn-default btn-lg" >
            ادامه
            <span class="glyphicon glyphicon-chevron-left"></span>
        </button>
    </div>
</form>
<<<<<<< HEAD
    <form action="profile">
        <input type="hidden" name="khadamat_back" value="<?php echo implode(',',$_REQUEST["khadamat"]);  ?>" />
    <div class="hs-float-right hs-margin-up-down">
        <button href="" class="btn hs-btn-default btn-lg" >
            <span class="glyphicon glyphicon-chevron-right"></span>
            مرحله قبل
        </button>
    </div>
    </form>
=======
>>>>>>> 53eeea5db37db1b41ca684e859f55d7762ec88a9
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