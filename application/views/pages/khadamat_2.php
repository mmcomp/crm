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
    <form action="khadamat_3">
    <div class="col-sm-10" >
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
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                1
            </div>
            <div class="col-sm-1">
                ADULT
            </div>
            <div class="col-sm-1">
                <select name="sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0">مونث<option>
                    <option value="1">مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input name="fname[]" class="form-control" placeholder="نام *">
            </div>
            <div class="col-sm-3">
                <input name="lname[]" class="form-control" placeholder="نام خانوادگی *">
            </div>
            <div class="col-sm-2">
                <input name="code_melli[]" class="form-control" placeholder="کد ملی *">
            </div>
            <div class="col-sm-2">
                <input name="tarikh_tavalod[]" class="form-control dateValue2" placeholder="تاریخ تولد *">
            </div>
        </div>
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                2
            </div>
            <div class="col-sm-1">
                ADULT
            </div>
            <div class="col-sm-1">
                <select name="sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0">مونث<option>
                    <option value="1">مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input name="fname[]" class="form-control" placeholder="نام *">
            </div>
            <div class="col-sm-3">
                <input name="lname[]" class="form-control" placeholder="نام خانوادگی *">
            </div>
            <div class="col-sm-2">
                <input name="code_melli[]" class="form-control" placeholder="کد ملی *">
            </div>
            <div class="col-sm-2">
                <input name="tarikh_tavalod[]" class="form-control dateValue2" placeholder="تاریخ تولد *">
            </div>
        </div>
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                3
            </div>
            <div class="col-sm-1">
                CHILD
            </div>
            <div class="col-sm-1">
                <select name="sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0">مونث<option>
                    <option value="1">مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input name="fname[]" class="form-control" placeholder="نام *">
            </div>
            <div class="col-sm-3">
                <input name="lname[]" class="form-control" placeholder="نام خانوادگی *">
            </div>
            <div class="col-sm-2">
                <input name="code_melli[]" class="form-control" placeholder="کد ملی *">
            </div>
            <div class="col-sm-2">
                <input name="tarikh_tavalod[]" class="form-control dateValue2" placeholder="تاریخ تولد *">
            </div>
        </div>
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                4
            </div>
            <div class="col-sm-1">
                INFANT
            </div>
            <div class="col-sm-1">
                <select name="sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0">مونث<option>
                    <option value="1">مذکر</option>
                </select>
            </div>
            <div class="col-sm-2">
                <input name="fname[]" class="form-control" placeholder="نام *">
            </div>
            <div class="col-sm-3">
                <input name="lname[]" class="form-control" placeholder="نام خانوادگی *">
            </div>
            <div class="col-sm-2">
                <input name="code_melli[]" class="form-control" placeholder="کد ملی *">
            </div>
            <div class="col-sm-2">
                <input name="tarikh_tavalod[]" class="form-control dateValue2" placeholder="تاریخ تولد *">
            </div>
        </div>
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-2">
                تلفن همراه : 
            </div>
            <div class="col-sm-4">
                <input name="mob" class="form-control" placeholder="تلفن همراه" value="09153068145">
            </div>
            <div class="col-sm-1">
                ایمیل :
            </div>
            <div class="col-sm-5">
                <input name="email" class="form-control" placeholder="ایمیل" value="hscomp2002@gmail.com">
            </div>
        </div>
    </div>
    <div class="hs-float-left hs-margin-up-down">
        <button href="" class="btn hs-btn-default btn-lg" >
            ادامه
            <span class="glyphicon glyphicon-chevron-left"></span>
        </button>
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