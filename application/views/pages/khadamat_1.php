<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $red_url = 'profile?factor_id='.$p1;
    $refer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strpos($refer,'profile')!==FALSE)
    {
        $red_url = 'khadamat_2/'.$p1;
    }
    factor_class::marhale((int)$p1,'khadamat_1');
    $p1=(int)$p1;
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
    $parvaz = array(
        array(
            "mabda_id" => -1,
            "maghsad_id" => -1,
            "tarikh" => '',
            "adl" => 1,
            "chd" => 0,
            "inf" => 0,
            "dotarafe" => true,
            "airline" => -1,
            "class" => '',
            "flight_number" => '',
            "havapeima" => '',
            "khorooj_saat" => '00',
            "khorooj_daghighe" => '00'
        )
    );
    //var_dump($_REQUEST);
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
    <div class="col-sm-10" >
        <?php
            echo validation_errors();
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 
        ?>
        
        <div class="row hs-border hs-margin-up-down">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border">
                اطلاعات مسیر پروازی
            </div>
            <form id="frm1_khadamat_1" action="<?php echo site_url().'khadamat_1/'.$p1;  ?>" method="POST">
            <div class="hs-border hs-padding">
                <div class="col-sm-2 hs-padding">
                    مبدا
                </div>
                <div class="col-sm-2 hs-padding">
                    مقصد
                </div>
                <div class="col-sm-2 hs-padding">
                    تاریخ
                </div>
                <div class="col-sm-2 hs-padding">
                    بزرگسال
                </div>
                <div class="col-sm-2 hs-padding">
                    کودک
                </div>
                <div class="col-sm-2 hs-padding">
                    نوزاد
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['mabda_id']"><option value="-1">مبدا</option><?php echo city_class::loadAll($parvaz[0]['mabda_id']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['maghsad_id']"><option value="-1">مقصد</option><?php echo city_class::loadAll($parvaz[0]['maghsad_id']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <input type="text" name="parvaz[]['tarikh']" class="form-control dateValue2" value="<?php echo $parvaz[0]['tarikh']; ?>" />
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['adl']"><?php echo $this->inc_model->generateOption(9,1,1,$parvaz[0]['adl']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['chd']"><?php echo $this->inc_model->generateOption(9,0,1,$parvaz[0]['chd']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['inf']"><?php echo $this->inc_model->generateOption(9,0,1,$parvaz[0]['inf']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    دوطرفه
                </div>
                <div class="col-sm-2 hs-padding">
                    ایرلاین
                </div>
                <div class="col-sm-2 hs-padding">
                    کلاس پروازی
                </div>
                <div class="col-sm-1 hs-padding">
                    شماره پرواز
                </div>
                <div class="col-sm-1 hs-padding">
                    هواپیما
                </div>
                <div class="col-sm-2 hs-padding">
                    ساعت‌خروج
                </div>                
                <div class="col-sm-2 hs-padding">
                    ساعت‌ورود
                </div>
                <div class="col-sm-2 hs-padding">
                    <input type="checkbox" name="parvaz[]['dotarafe']" <?php echo isset($parvaz[0]['dotarafe'])?"checked=\"checked\"":""; ?> />
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="parvaz[]['airline']" class="form-control"><option value="-1">ایرلاین</option><?php echo airline_class::loadAll($parvaz[0]['airline']); ?></select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <input type="text" name="parvaz[]['class']" class="form-control" value="<?php echo $parvaz[0]['class']; ?>" />
                </div>
                <div class="col-sm-1 hs-padding">
                    <input type="text" name="parvaz[]['flight_number']" class="form-control" value="<?php echo $parvaz[0]['flight_number']; ?>" />
                </div>
                <div class="col-sm-1 hs-padding">
                    <input type="text" name="parvaz[]['havapeima']" class="form-control" value="<?php echo $parvaz[0]['havapeima']; ?>" />
                </div>
                <div class="col-sm-1 hs-padding">
                    <select name="parvaz[]['khorooj_saat']"><?php echo $this->inc_model->generateOption(23,0,1,$parvaz[0]['khorooj_saat']); ?></select>
                </div>                
                <div class="col-sm-1 hs-padding">
                    <select name="parvaz[]['khorooj_daghighe']" ><?php echo $this->inc_model->generateOption(59,0,1,$parvaz[0]['khorooj_daghighe']); ?></select>
                </div>
                <div class="col-sm-1 hs-padding">
                    <select name="parvaz[]['khorooj_saat']"><?php echo $this->inc_model->generateOption(23,0,1,$parvaz[0]['khorooj_saat']); ?></select>
                </div>                
                <div class="col-sm-1 hs-padding">
                    <select name="parvaz[]['khorooj_daghighe']" ><?php echo $this->inc_model->generateOption(59,0,1,$parvaz[0]['khorooj_daghighe']); ?></select>
                </div>
            </div>
        </form>
        </div>
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
    function contin()
    {
        $("#frm1_khadamat_1").submit();
    }
</script>