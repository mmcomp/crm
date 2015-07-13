<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function loadCountry()
    {
        $out = array(-1=>'');
        $my = new mysql_class;
        $my->ex_sql("select id,name from country order by name", $q);
        foreach($q as $r)
        {
            $out[(int)$r['id']] = $r['name'];
        }
        return($out);
    }
    function delF($table,$id)
    {
        $my = new mysql_class;
        $my->ex_sqlx("update city set typ = 0 where id= $id");
        return(TRUE);
    }
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $msg = '';
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
    $tarikh='';
    if($this->input->get('tarikh_se')!==FALSE)
    {
        $tarikh = $this->input->get('tarikh_se');
    } 
    /*
    $my = new mysql_class;
    $ss = $my->fetch_field('user');
    var_dump($ss);
    * 
     */
    $gname1 = "gname_city";
    $input =array($gname1=>array('table'=>'city','div'=>'div_city'));
    $xgrid1 = new xgrid($input,site_url().'city?');
    $xgrid1->pageRows[$gname1]=30;
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'نام';
    $xgrid1->column[$gname1][2]['name'] = 'IATA';
    $xgrid1->column[$gname1][3]['name'] = 'کشور';
    $xgrid1->column[$gname1][3]['clist'] = loadCountry();
    $xgrid1->column[$gname1][4]['name'] = 'نوع';
    $xgrid1->column[$gname1][4]['clist'] = array(
        1=>'داخلی',
        2=>'خارجی',
        3=>'زیارتی'
    );
    $xgrid1->whereClause[$gname1] = " typ>0";
    /*
        "نوع خدمات","پرواز","هتل","تور","ویزایی با شماره ملی","ویزایی با شماره پاسپورت"
    );
    $xgrid1->column[$gname1][4] = $xgrid1->column[$gname1][5];
    $xgrid1->column[$gname1][4]['name'] = 'درصد جایزه';
    $xgrid1->column[$gname1][5] = $xgrid1->column[$gname1][0];
    $xgrid1->column[$gname1][5]['name'] = 'خدمات-تامین';
    $xgrid1->column[$gname1][5]['access'] = 1;
    $xgrid1->column[$gname1][5]['cfunction'] = array('goTamin');
     * 
     */
/*
    //$xgrid1->whereClause[$gname1] = " (browser<>'Mozilla' and platform<>'Unknown Platform' and robot='') order by tarikh desc";
    for($i=1;$i< count($xgrid1->column[$gname1]);$i++)
    {
        $xgrid1->column[$gname1][$i]['name']='';
    }
    $xgrid1->column[$gname1][11]['name'] = 'نام کاربری';
    $xgrid1->column[$gname1][15]['name'] = 'گروه کاربری';
    $xgrid1->column[$gname1][15]['clist'] = loadGrp();
    //$xgrid1->column[$gname1][12]['name'] = 'رمز عبور';
    //$xgrid1->column[$gname1][3]['cfunction'] = array('urldecode'); 
*/
    $xgrid1->canEdit[$gname1]=TRUE;
    $xgrid1->canAdd[$gname1]=TRUE;
    $xgrid1->canDelete[$gname1]=TRUE;
    $xgrid1->deleteFunction[$gname1] = "delF";
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        intialGrid(args);
    });
</script>
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
        <div class="col-sm-12">
            <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            مدیریت شهرها
            </div>






                <div id="div_city" ></div>



        </div>
    </div>
</div>