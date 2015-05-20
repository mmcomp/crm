<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

    function replaceHashWithInput($hash,$body1,$data)
    {
        $vis_pos = -1;
        while($vis_pos!==FALSE)
        {
            $vis_pos = strpos($body1,"#".$hash."_",$vis_pos+1);
            if($vis_pos!==FALSE)
            {
                $vis_end = strpos($body1,"#",$vis_pos+2);
                $vis = substr($body1,$vis_pos+1,$vis_end-$vis_pos-1);
                $body1 = substr($body1, 0, $vis_pos-1).'<input class="visa_input"  name="'.$vis.'" value="'.((isset($data[$vis]))?$data[$vis]:'').'"/>'.substr($body1, $vis_end+1);
            }
        }
        return($body1);
    }
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    $form_id = 1;
    if(trim($p2)!='')
        $form_id = (int)$p2;
    $body='';
    /*
    $body = <<<BOD
        <p dir="rtl" lang="en-US" style="text-align: center;" align="right"><strong><span lang="fa-IR">به</span> <span lang="fa-IR">نام</span> <span lang="fa-IR">خدا</span></strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">كشـور</span></span>:#visa_country#</strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">نوع</span> <span lang="fa-IR">ويزا</span></span>:#visa_type#</strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">مدت</span> <span lang="fa-IR">ويزا</span> </span>:#visa_time#</strong></p>
        <p dir="rtl" style="text-align: left;" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">شماره</span> </span>:#visa_number#</strong></p>
        <p dir="rtl" style="text-align: left;" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">تاريخ</span> </span>:#visa_tarikh#</strong></p>
        <p dir="rtl" align="center"> </p>
        <p dir="rtl" align="center"><span style="font-size: 14pt;"><strong>( <span lang="ar-SA"><span lang="fa-IR">توافقنـامه</span></span>)</strong></span></p>
        <p dir="rtl" align="right"> </p>
        <p dir="rtl" align="center"><strong><span lang="fa-IR">جهت اخذ رواديد </span>/<span lang="fa-IR">توافقنامه به صورت عادي فوري ،ترانزيت ،توريستي،تجاري</span></strong></p>
        <p dir="rtl" align="center"><strong><span lang="ar-SA"><span lang="fa-IR">لطفا</span></span>"<span lang="ar-SA"><span lang="fa-IR">قبل</span> <span lang="fa-IR">از</span> <span lang="fa-IR">تقاضاي</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">متن</span> <span lang="fa-IR">توافقنامه</span> <span lang="fa-IR">و</span> <span lang="fa-IR">شرايط</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">را</span> <span lang="fa-IR">مطالعه</span> <span lang="fa-IR">نمائيد</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">اين</span> <span lang="fa-IR">توافقنامه</span> <span lang="fa-IR">بين</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">و</span> <span lang="fa-IR">يانماينده</span> <span lang="fa-IR">ايشان</span> <span lang="fa-IR">و</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">درخواست</span> <span lang="fa-IR">كننده</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">با</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">منبعد</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">ناميده</span> <span lang="fa-IR">ميشود</span> <span lang="fa-IR">از</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">طرف</span> <span lang="fa-IR">و</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">خدمات</span> <span lang="fa-IR">مسافرتي</span> <span lang="fa-IR">دنيا</span> <span lang="fa-IR">سير</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">منبعد</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">ناميده</span> <span lang="fa-IR">ميشود</span> <span lang="fa-IR">به</span> <span lang="fa-IR">شرح</span> <span lang="fa-IR">زير</span> <span lang="fa-IR">و</span> <span lang="fa-IR">ادامه</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">در</span> <span lang="fa-IR">پشت</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">برگ</span> <span lang="fa-IR">منعقدمي</span> <span lang="fa-IR">گردد</span></span>:</strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">آدرس</span> <span lang="fa-IR">و</span> <span lang="fa-IR">تلفن</span> <span lang="fa-IR">محل</span> <span lang="fa-IR">سكونت</span> </span>:#visa_address# #visa_tel#</strong></p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">آدرس</span> <span lang="fa-IR">و</span> <span lang="fa-IR">تلفن</span> <span lang="fa-IR">محل</span> <span lang="fa-IR">كار</span></span>:#visa_jaddress# #visa_jtel#</strong></p>
        <p dir="rtl" align="right"> </p>
        <p dir="rtl" align="right"> </p>
        <p dir="rtl" align="right"><strong><span lang="ar-SA"><span lang="fa-IR">تقاضا</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">جهت</span> <span lang="fa-IR">خودم</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">همراه</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">همراهان</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">افراد</span> <span lang="fa-IR">ديگربه</span> <span lang="fa-IR">شرح</span> <span lang="fa-IR">زير</span> <span lang="fa-IR">دريك</span> <span lang="fa-IR">پاسپورت</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">در</span> <span lang="fa-IR">پاسپورتهاي</span> <span lang="fa-IR">جداگانه</span> <span lang="fa-IR">رادارم</span></span>: </strong></p>
        <p dir="rtl" align="right"> </p>
        <table dir="rtl" style="width: 100%; margin-left: auto; margin-right: auto;" width="594" cellspacing="1" cellpadding="7">
        <tbody>
        <tr valign="top">
        <td bgcolor="#e0e0e0" width="25" height="13">
        <p align="center"><strong><span lang="fa-IR">رديف</span></strong></p>
        </td>
        <td bgcolor="#e0e0e0" width="124">
        <p align="center"><strong><span lang="fa-IR">نام ونام خانوادگي</span></strong></p>
        </td>
        <td bgcolor="#e0e0e0" width="69">
        <p align="center"><strong><span lang="fa-IR">نام پدر</span></strong></p>
        </td>
        <td bgcolor="#e0e0e0" width="88">
        <p align="center"><strong><span lang="fa-IR">شماره پاسپورت</span></strong></p>
        </td>
        <td bgcolor="#e0e0e0" width="210">
        <p align="center"><strong><span lang="fa-IR">هزينه ويزا</span></strong></p>
        </td>
        </tr>
        #hamrahan#
        </tbody>
        </table>
        <p dir="rtl" align="right"> </p>
        <p dir="rtl" align="right"><strong>1-<span lang="ar-SA"><span lang="fa-IR">اينجانب #fname1# #lname1# </span></span><span lang="ar-SA"><span lang="fa-IR">به</span> <span lang="fa-IR">عنوان</span> <span lang="fa-IR">درخواست</span> <span lang="fa-IR">كننده</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">به</span> <span lang="fa-IR">عنوان</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">نماينده</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">شناخته</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">گردم</span></span>.</strong></p>
        <p dir="rtl" align="right"><strong>2-<span lang="ar-SA"><span lang="fa-IR">متقاضي</span> <span lang="fa-IR">متعهد</span> <span lang="fa-IR">ميگردد</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">خودش</span> <span lang="fa-IR">و</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">افرادي</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">برايشان</span> <span lang="fa-IR">تقاضاي</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">گردد</span> <span lang="fa-IR">پيش</span> <span lang="fa-IR">از</span> <span lang="fa-IR">انقضاءمدت</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">از</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مقصد</span> <span lang="fa-IR">خارج</span> <span lang="fa-IR">گردد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">در</span> <span lang="fa-IR">غير</span> <span lang="fa-IR">اينصورت</span> <span lang="fa-IR">مسئوليت</span> <span lang="fa-IR">هرگونه</span> <span lang="fa-IR">ضرر</span> <span lang="fa-IR">و</span> <span lang="fa-IR">زيان</span> <span lang="fa-IR">ناشي</span> <span lang="fa-IR">از</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">را</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">شخصا</span></span>"<span lang="ar-SA"><span lang="fa-IR">بعهده</span> <span lang="fa-IR">خواهد</span> <span lang="fa-IR">داشت</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>3-<span lang="ar-SA"><span lang="fa-IR">هرگونه</span> <span lang="fa-IR">جرائم</span> <span lang="fa-IR">و</span> <span lang="fa-IR">هزينه</span> <span lang="fa-IR">هاي</span> <span lang="fa-IR">مالي</span> <span lang="fa-IR">ناشي</span> <span lang="fa-IR">از</span> <span lang="fa-IR">اقامت</span> <span lang="fa-IR">غيرمجاز</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">ناشي</span> <span lang="fa-IR">از</span> <span lang="fa-IR">اعمال</span> <span lang="fa-IR">غير</span> <span lang="fa-IR">مجاز</span> <span lang="fa-IR">به</span> <span lang="fa-IR">عهده</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">ملزم</span> <span lang="fa-IR">به</span> <span lang="fa-IR">جبران</span> <span lang="fa-IR">و</span> <span lang="fa-IR">پرداخت</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">ميباشد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">چنانچه</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">نيزهزينه</span> <span lang="fa-IR">هايي</span> <span lang="fa-IR">را</span> <span lang="fa-IR">پرداخت</span> <span lang="fa-IR">نمايد</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">ملزم</span> <span lang="fa-IR">به</span> <span lang="fa-IR">جبران</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> </span></strong></p>
        <p dir="rtl" align="right"><strong>4-<span lang="ar-SA"><span lang="fa-IR">درخواست</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">با</span> <span lang="fa-IR">ارائه</span> <span lang="fa-IR">اصل</span> <span lang="fa-IR">پاسپورت</span> <span lang="fa-IR">وپرداخت</span> <span lang="fa-IR">تمام</span> <span lang="fa-IR">وجه</span> <span lang="fa-IR">الزامي</span> <span lang="fa-IR">است</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>5- <span lang="ar-SA"><span lang="fa-IR">در</span> <span lang="fa-IR">صورت</span> <span lang="fa-IR">تقاضاي</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">گروه</span> <span lang="fa-IR">بيش</span> <span lang="fa-IR">از</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">يا</span> </span>(<span lang="ar-SA"><span lang="fa-IR">چند</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">با</span> <span lang="fa-IR">يكديگر</span> </span>)<span lang="ar-SA"><span lang="fa-IR">شخص</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">و</span> <span lang="fa-IR">پرداخت</span> <span lang="fa-IR">كننده</span> <span lang="fa-IR">وجه</span> <span lang="fa-IR">نماينده</span> <span lang="fa-IR">ساير</span> <span lang="fa-IR">ين</span> <span lang="fa-IR">شناخته</span> <span lang="fa-IR">ميشود</span> </span>. <span lang="ar-SA"><span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">صرفا</span></span>"<span lang="ar-SA"><span lang="fa-IR">به</span> <span lang="fa-IR">همان</span> <span lang="fa-IR">شخص</span> <span lang="fa-IR">ارائه</span> <span lang="fa-IR">خدمات</span> <span lang="fa-IR">و</span> <span lang="fa-IR">پاسخگويي</span> <span lang="fa-IR">خواهد</span> <span lang="fa-IR">نمود</span> <span lang="fa-IR">و</span> <span lang="fa-IR">با</span> <span lang="fa-IR">امضاءاين</span> <span lang="fa-IR">قرارداد</span> <span lang="fa-IR">تمامي</span> <span lang="fa-IR">مفادآن</span> <span lang="fa-IR">و</span> <span lang="fa-IR">مسئوليتها</span> <span lang="fa-IR">را</span> <span lang="fa-IR">از</span> <span lang="fa-IR">جانب</span> <span lang="fa-IR">خود</span> <span lang="fa-IR">و</span> <span lang="fa-IR">همراهان</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">پذيرد</span></span>.</strong></p>
        <p dir="rtl" align="right"><strong>6-<span lang="ar-SA"><span lang="fa-IR">در</span> <span lang="fa-IR">صورت</span> <span lang="fa-IR">تقاضاي</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">بيش</span> <span lang="fa-IR">از</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">با</span> <span lang="fa-IR">پاسپورت</span> <span lang="fa-IR">جداگانه</span> <span lang="fa-IR">در</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">واحد</span> </span>(<span lang="ar-SA"><span lang="fa-IR">مانند</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">زوج</span> <span lang="fa-IR">با</span> <span lang="fa-IR">پاسپورتهاي</span> <span lang="fa-IR">جداگانه</span> <span lang="fa-IR">–</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">خانواده</span> <span lang="fa-IR">با</span> <span lang="fa-IR">پاسپورتهاي</span> <span lang="fa-IR">جداگانه</span> <span lang="fa-IR">–</span> <span lang="fa-IR">چند</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">همراه</span> <span lang="fa-IR">و</span> <span lang="fa-IR">آشنا</span> <span lang="fa-IR">و</span> <span lang="fa-IR">غيره</span> </span>)<span lang="ar-SA"><span lang="fa-IR">در</span> <span lang="fa-IR">صورت</span> <span lang="fa-IR">مرفوض</span> <span lang="fa-IR">شدن</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">عدم</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">براي</span> <span lang="fa-IR">بعضي</span> <span lang="fa-IR">از</span> <span lang="fa-IR">ايشان</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">هيچگونه</span> <span lang="fa-IR">مسئوليتي</span> <span lang="fa-IR">را</span> <span lang="fa-IR">نمي</span> <span lang="fa-IR">پذيرد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">منوط</span> <span lang="fa-IR">نمودن</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">به</span> <span lang="fa-IR">يكديگر</span> <span lang="fa-IR">از</span> <span lang="fa-IR">نظر</span> <span lang="fa-IR">مقامات</span> <span lang="fa-IR">آن</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">اعتباري</span> <span lang="fa-IR">ندارد</span></span>.</strong></p>
        <p dir="rtl" align="right"><strong>7-<span lang="ar-SA"><span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">جهت</span> <span lang="fa-IR">تامين</span> <span lang="fa-IR">جاي</span> <span lang="fa-IR">پرواز</span> <span lang="fa-IR">تلاش</span> <span lang="fa-IR">خود</span> <span lang="fa-IR">را</span> <span lang="fa-IR">معطوف</span> <span lang="fa-IR">ميدارد</span> <span lang="fa-IR">ولي</span> <span lang="fa-IR">هيچگونه</span> <span lang="fa-IR">تعهد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">مسئوليتي</span> <span lang="fa-IR">را</span> <span lang="fa-IR">نمي</span> <span lang="fa-IR">پذيرد</span> <span lang="fa-IR">،منوط</span> <span lang="fa-IR">نمودن</span> <span lang="fa-IR">رواديدبه</span> <span lang="fa-IR">تاريخ</span> <span lang="fa-IR">پرواز</span> <span lang="fa-IR">به</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">ارتباطي</span> <span lang="fa-IR">نخواهد</span> <span lang="fa-IR">داشت</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>8- <span lang="ar-SA"><span lang="fa-IR">مدت</span> <span lang="fa-IR">اعتبار</span> <span lang="fa-IR">استفاده</span> <span lang="fa-IR">ازويزا</span> <span lang="fa-IR">و</span> <span lang="fa-IR">مدت</span> <span lang="fa-IR">اقامت</span> <span lang="fa-IR">در</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مقصد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">نقطه</span> <span lang="fa-IR">ترانزيت</span> <span lang="fa-IR">بسته</span> <span lang="fa-IR">به</span> <span lang="fa-IR">نوع</span> <span lang="fa-IR">درخواست</span> <span lang="fa-IR">و</span> <span lang="fa-IR">موافقت</span> <span lang="fa-IR">ويزاي</span> <span lang="fa-IR">صادره</span> <span lang="fa-IR">از</span> <span lang="fa-IR">طرف</span> <span lang="fa-IR">مقامات</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مورد</span> <span lang="fa-IR">نظر</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>9-<span lang="ar-SA"><span lang="fa-IR">متقاضي</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">پذيرد</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> </span>/<span lang="ar-SA"><span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">و</span> <span lang="fa-IR">مدت</span> <span lang="fa-IR">اقامت</span> <span lang="fa-IR">بستگي</span> <span lang="fa-IR">به</span> <span lang="fa-IR">مقامات</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مورد</span> <span lang="fa-IR">نظر</span> <span lang="fa-IR">دارد</span> <span lang="fa-IR">لذا</span> <span lang="fa-IR">عدم</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">با</span> <span lang="fa-IR">تاريخ</span> <span lang="fa-IR">اعتبار</span> <span lang="fa-IR">متفاوت</span> <span lang="fa-IR">بستگي</span> <span lang="fa-IR">به</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مربوطه</span> <span lang="fa-IR">دارد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">حتي</span> <span lang="fa-IR">گاهي</span> <span lang="fa-IR">اوقات</span> <span lang="fa-IR">با</span> <span lang="fa-IR">وجود</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">از</span> <span lang="fa-IR">ورود</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">عبور</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">به</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مربوطه</span> <span lang="fa-IR">ممانعت</span> <span lang="fa-IR">به</span> <span lang="fa-IR">عمل</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">آيدكه</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">امرصرفا</span></span>"<span lang="ar-SA"><span lang="fa-IR">به</span> <span lang="fa-IR">كشور</span> <span lang="fa-IR">مربوطه</span> <span lang="fa-IR">بستگي</span> <span lang="fa-IR">دارد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">از</span> <span lang="fa-IR">حيطه</span> <span lang="fa-IR">عمل</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">خارج</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> <span lang="fa-IR">،لذا</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">هيچگونه</span> <span lang="fa-IR">مسئوليتي</span> <span lang="fa-IR">در</span> <span lang="fa-IR">قبال</span> <span lang="fa-IR">اهداف</span> <span lang="fa-IR">سفر</span> <span lang="fa-IR">مانند</span> <span lang="fa-IR">وقت</span> <span lang="fa-IR">سفارت</span> <span lang="fa-IR">،آزمون</span> <span lang="fa-IR">و</span> <span lang="fa-IR">مسائل</span> <span lang="fa-IR">كاري</span> <span lang="fa-IR">،مسائل</span> <span lang="fa-IR">مالي</span> <span lang="fa-IR">نمي</span> <span lang="fa-IR">تواند</span> <span lang="fa-IR">عهده</span> <span lang="fa-IR">دار</span> <span lang="fa-IR">باشد</span></span>.</strong></p>
        <p dir="rtl" align="right"><strong>10-<span lang="ar-SA"><span lang="fa-IR">حداكثر</span> <span lang="fa-IR">مدت</span> <span lang="fa-IR">اخذ</span> <span lang="fa-IR">رواديد</span></span>30 <span lang="ar-SA"><span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">پس</span> <span lang="fa-IR">از</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">مدت</span> <span lang="fa-IR">در</span> <span lang="fa-IR">صورت</span> <span lang="fa-IR">عدم</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">رواديد</span> <span lang="fa-IR">تمام</span> <span lang="fa-IR">وجه</span> <span lang="fa-IR">پرداختي</span> <span lang="fa-IR">پس</span> <span lang="fa-IR">از</span> <span lang="fa-IR">كسر</span> <span lang="fa-IR">هزينه</span> <span lang="fa-IR">هاي</span> <span lang="fa-IR">مربو</span> <span lang="fa-IR">طه</span> <span lang="fa-IR">استرداد</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">گردد</span></span>. <span lang="ar-SA"><span lang="fa-IR">هزينه</span> <span lang="fa-IR">كسري</span> <span lang="fa-IR">درصورت</span> <span lang="fa-IR">عدم</span> <span lang="fa-IR">صدور</span> <span lang="fa-IR">ويزا</span> <span lang="fa-IR">از</span> <span lang="fa-IR">سوي</span> <span lang="fa-IR">سفارت</span> <span lang="fa-IR">مربوطه</span> <span lang="fa-IR">مبلغ</span> <span lang="fa-IR">جمعاً</span> #visa_kasr_sefarat#</span> <span lang="ar-SA"><span lang="fa-IR">ريال</span></span> <span lang="fa-IR">به</span> <span lang="fa-IR">ازاي</span> <span lang="fa-IR">هر</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span>.</strong></p>
        <p dir="rtl" align="right"><strong>11-<span lang="fa-IR">پس از درخواست دعوتنامه </span>/ <span lang="fa-IR">رواديد استرداد وجه امكان پذير نمي باشد و دلايل بيماري ،فوت ،اشكال در پاسپورت انصراف ممنوعيت خروج از كشور و غيره قابل قبول نخواهد بود</span>.</strong></p>
        <p dir="rtl" align="right"><strong>12- <span lang="fa-IR">متقاضي توجه و قبول مي نمايد كه گاهي اوقات صدور رواديد منوط به تاييد مقامات امنيتي كشور مربوطه مي باشد كه اين امر ممكن است تا </span>40 <span lang="fa-IR">روز طول بكشد.</span></strong></p>
        <p dir="rtl" align="right"><strong>13- <span lang="ar-SA"><span lang="fa-IR">از</span> <span lang="fa-IR">متقاضي</span> <span lang="fa-IR">درخواست</span> <span lang="fa-IR">ميگردد</span> <span lang="fa-IR">در</span> <span lang="fa-IR">هنگام</span> <span lang="fa-IR">دريافت</span> <span lang="fa-IR">دعوت</span> <span lang="fa-IR">نامه</span> </span>/<span lang="ar-SA"><span lang="fa-IR">رواديد</span> <span lang="fa-IR">مشخصات</span> <span lang="fa-IR">پاسپورت</span> <span lang="fa-IR">خود</span> <span lang="fa-IR">و</span> <span lang="fa-IR">همراهان</span> <span lang="fa-IR">تطبيق</span> <span lang="fa-IR">دهد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">هرگونه</span> <span lang="fa-IR">اشتباه</span> <span lang="fa-IR">يا</span> <span lang="fa-IR">اختلاف</span> <span lang="fa-IR">مشخصات</span> <span lang="fa-IR">ر</span> <span lang="fa-IR">ا</span> <span lang="fa-IR">اطلاع</span> <span lang="fa-IR">دهد</span> <span lang="fa-IR">در</span> <span lang="fa-IR">غير</span> <span lang="fa-IR">اينصورت</span> <span lang="fa-IR">دفتر</span> <span lang="fa-IR">مسئوليتي</span> <span lang="fa-IR">را</span> <span lang="fa-IR">نمي</span> <span lang="fa-IR">پذيرد</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>14-<span lang="fa-IR">ممنوع الخروج يا ممنوع الورود بودن متقاضي از كشور مبداءبه مقصد و يا بالعكس به اين دفتر ارتباطي نداشته و وظيفه اين دفترانجام شده تلقي مي گردد</span>.</strong></p>
        <p dir="rtl" align="right"><strong>15-<span lang="fa-IR">اشتباهات و اشكالات مندرج در پاسپورت به عهد ه متقاضي مي باشد</span>.</strong></p>
        <p dir="rtl" align="right"><strong>16-<span lang="ar-SA"><span lang="fa-IR">در</span> <span lang="fa-IR">مورد</span> <span lang="fa-IR">ويزاهاي</span> <span lang="fa-IR">گروهي</span> <span lang="fa-IR">چين</span> <span lang="fa-IR">حداقل</span> <span lang="fa-IR">نفرات</span> </span>5 <span lang="ar-SA"><span lang="fa-IR">نفر</span> <span lang="fa-IR">و</span> <span lang="fa-IR">ورود</span> <span lang="fa-IR">و</span> <span lang="fa-IR">خروج</span> <span lang="fa-IR">از</span> <span lang="fa-IR">مرزها</span> <span lang="fa-IR">نيزبايد</span> <span lang="fa-IR">با</span> <span lang="fa-IR">هم</span> <span lang="fa-IR">باشد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">حداكثر</span> <span lang="fa-IR">زمان</span> <span lang="fa-IR">تهيه</span> <span lang="fa-IR">ويزا</span> </span>15<span lang="ar-SA"><span lang="fa-IR">تا</span> </span>20 <span lang="ar-SA"><span lang="fa-IR">روز</span> <span lang="fa-IR">كاري</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">باشد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">در</span> <span lang="fa-IR">صورت</span> <span lang="fa-IR">رد</span> <span lang="fa-IR">شدن</span> <span lang="fa-IR">هر</span> <span lang="fa-IR">يك</span> <span lang="fa-IR">از</span> <span lang="fa-IR">نفرات</span> <span lang="fa-IR">اگرحد</span> <span lang="fa-IR">نصاب</span> <span lang="fa-IR">گروه</span> <span lang="fa-IR">به</span> <span lang="fa-IR">كمتر</span> <span lang="fa-IR">از</span> </span>5 <span lang="ar-SA"><span lang="fa-IR">نفر</span> <span lang="fa-IR">برسد</span> <span lang="fa-IR">ويزاي</span> <span lang="fa-IR">گروهي</span> <span lang="fa-IR">صادر</span> <span lang="fa-IR">نخواهد</span> <span lang="fa-IR">شد</span> <span lang="fa-IR">و</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">شركت</span> <span lang="fa-IR">هيچگونه</span> <span lang="fa-IR">مسئوليتي</span> <span lang="fa-IR">دراين</span> <span lang="fa-IR">قبال</span> <span lang="fa-IR">نخواهد</span> <span lang="fa-IR">داشت</span> <span lang="fa-IR">وجه</span> <span lang="fa-IR">دعوتنامه</span> <span lang="fa-IR">كسر</span> <span lang="fa-IR">شده</span> <span lang="fa-IR">و</span> <span lang="fa-IR">باقيمانده</span> <span lang="fa-IR">به</span> <span lang="fa-IR">مسافر</span> <span lang="fa-IR">برگردانده</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">شود</span> </span>.</strong></p>
        <p dir="rtl" align="right"><strong>17- <span lang="ar-SA"><span lang="fa-IR">مبلغ</span> #visa_ghimat_nafar#</span> <span lang="ar-SA"><span lang="fa-IR">در</span> <span lang="fa-IR">ازاي</span> <span lang="fa-IR">هر</span> <span lang="fa-IR">نفر</span> <span lang="fa-IR">تحويل</span> <span lang="fa-IR">مسئول</span> <span lang="fa-IR">ويزاي</span> <span lang="fa-IR">شركت</span> <span lang="fa-IR">جهانگردي</span> <span lang="fa-IR">دنياسير</span> <span lang="fa-IR">گرديد</span></span>.</strong></p>
        <p dir="rtl" align="right"><strong>18-<span lang="fa-IR">مسئوليت صدور بليط و رزرو هتل و</span>....<span lang="fa-IR">قبل از صدور ويزا به عهده مسافر ميباشدو اين آژانس هيچگونه مسئوليتي ندارد</span>.</strong></p>
        <p dir="rtl" align="right"><strong>19-<span lang="ar-SA"><span lang="fa-IR">شركت</span> <span lang="fa-IR">دنيا</span> <span lang="fa-IR">سير</span> <span lang="fa-IR">صرفا</span></span>" <span lang="ar-SA"><span lang="fa-IR">اقدام</span> <span lang="fa-IR">كننده</span> <span lang="fa-IR">جهت</span> <span lang="fa-IR">ويزا</span> <span lang="fa-IR">ميباشد</span> <span lang="fa-IR">نه</span> <span lang="fa-IR">صادر</span> <span lang="fa-IR">كننده</span> <span lang="fa-IR">ويزا</span></span></strong></p>
        <p dir="rtl" align="right"><strong>20- <span lang="ar-SA"><span lang="fa-IR">آژانس #visa_ajancy#</span></span> <span lang="ar-SA"><span lang="fa-IR">يا</span> <span lang="fa-IR">جناب</span> #fname1# #lname1#</span> <span lang="ar-SA"><span lang="fa-IR">متعهد</span> <span lang="fa-IR">مي</span> <span lang="fa-IR">گردد</span> <span lang="fa-IR">كه</span> <span lang="fa-IR">كليه</span> <span lang="fa-IR">مفاد</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">توافقنامه</span> <span lang="fa-IR">را</span> <span lang="fa-IR">بطور</span> <span lang="fa-IR">كامل</span> <span lang="fa-IR">مطالعه</span> <span lang="fa-IR">كرده</span> <span lang="fa-IR">و</span> <span lang="fa-IR">بعد</span> <span lang="fa-IR">تصميم</span> <span lang="fa-IR">به</span> <span lang="fa-IR">عقد</span> <span lang="fa-IR">اين</span> <span lang="fa-IR">توافقنامه</span> <span lang="fa-IR">گرفته</span> <span lang="fa-IR">اند</span></span>.</strong></p>
        <p dir="rtl" align="right"> </p>
        <table style="height: 59px; width: 100%; margin-left: auto; margin-right: auto;" width="789">
        <tbody>
        <tr>
        <td style="text-align: right; vertical-align: middle;"><span style="font-size: 12pt;"><strong><span lang="fa-IR">مهر</span> <span lang="fa-IR">و</span> <span lang="fa-IR">امضاءمسئول</span> <span lang="fa-IR">بخش</span> <span lang="fa-IR">ويزا</span> </strong></span></td>
        <td style="text-align: left; vertical-align: middle;"><span style="font-size: 12pt;"><strong><span lang="fa-IR">نام</span> <span lang="fa-IR">ونام</span> <span lang="fa-IR">خانوادگي</span> <span lang="fa-IR">مسافر</span></strong></span></td>
        </tr>
        <tr style="text-align: center;">
        <td style="text-align: right; vertical-align: middle;"><span style="font-size: 12pt;"><strong><span lang="fa-IR">آژانس</span> <span lang="fa-IR">دنيا</span> <span lang="fa-IR">سير</span> </strong></span></td>
        <td style="text-align: left; vertical-align: middle;"><span style="font-size: 12pt;"><strong>امضاء</strong></span></td>
        </tr>
        </tbody>
        </table>
        <p dir="rtl" style="text-align: right;" align="right"> </p>
        <p dir="rtl" style="text-align: right;" align="right"> </p>
        <p dir="rtl" align="right"> </p>
BOD;
    */
    $ham_tmp = '';
    $data = array();
    $my = new mysql_class;
    $my->ex_sql("select matn,matn2 from print_theme where id=$form_id", $q);
    if(isset($q[0]))
    {
        $body = $q[0]['matn'];
        $ham_tmp = $q[0]['matn2'];
        $my->ex_sql("select data from print_factor where factor_id = $factor_id and print_theme_id = $form_id order by tarikh desc",$qq);
        if(isset($qq[0]))
        {
            $data1 = ((trim($qq[0]['data'])!='')?json_decode($qq[0]['data']):array());
            foreach ($data1 as $obj)
            {
                $vars = get_object_vars($obj);
                foreach ($vars as $key=>$value)
                    $data[$key] = $value;
            }
        }
    }
    $hamrahan = '';
    /*
    $ham_tmp = <<<HAM
    <tr valign="top">
        <td width="25" height="2">
        <p align="center"><strong>#index#</strong></p>
        </td>
        <td width="124">
        <p align="center">#name#</p>
        </td>
        <td width="69">
        <p align="center">#pedar#</p>
        </td>
        <td width="88">
        <p dir="ltr" align="center">#passport#</p>
        </td>
        <td width="210">
        <p align="center"> #visa_hazine_mosafer[]# </p>
        </td>
    </tr>
HAM;
    */
    $f = new factor_class($factor_id);
    $body1 = 'اطلاعاتی موجود نیست';
    if(isset($f->id))
    {
        $mos = mosafer_class::loadByFactor($factor_id);
        $ham_out = '';
        foreach($mos as $i=>$mo)
        {
            $ham_tmp1 = str_replace("#index#", ($i+1), $ham_tmp);
            $ham_tmp1 = str_replace("#name#", $mo['fname'].' '.$mo['lname'], $ham_tmp1);
            $ham_tmp1 = str_replace("#pedar#", '', $ham_tmp1);
            $ham_tmp1 = str_replace("#passport#", $mo['passport'], $ham_tmp1);
            $ham_out .= $ham_tmp1;
        }
        $u = new user_class($f->user_id);
        $fname1 = $u->fname;
        $lname1 = $u->lname;
        $body1 = str_replace("#fname1#", $fname1, $body);
        $body1 = str_replace("#hamrahan#", $ham_out, $body1);
        $body1 = str_replace("#lname1#", $lname1, $body1);
        $body1 = replaceHashWithInput("visa",$body1,$data);

    }
    //var_dump($_REQUEST);
    if(isset($_REQUEST['save_form']))
    {
        $data = array();
        foreach($_REQUEST as $key=>$value)
        {
            if(strpos($key, "visa_")!==FALSE)
            {
                $data[$key]=$value;
            }
        }
        //$data = $_REQUEST;
        $form_id = (int)$_REQUEST['save_form'];
        $tarikh = date("Y-m-d H:i:s");
        $my->ex_sqlx("insert into print_factor (`print_theme_id`, `factor_id`, `tarikh`, `user_id`,`data`) values ($form_id,$factor_id,'$tarikh',$user_id,'". json_encode($value)."')");
    }
    //var_dump($data);
?>
<style>
    .visa_input{
        border : none;
    }
    .visa_input:hover{
        border : red 1px dashed;
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
    <form method="post">
    <div class="col-sm-10" >
        <?php echo $body1; ?>
        <input type="hidden" name="save_form" value="<?php echo $form_id; ?>"/>
        <button>ثبت</button>
    </div>
    </form>


</div>
<script>
</script>