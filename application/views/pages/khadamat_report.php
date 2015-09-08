<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function loadKhadamat($id)
    {
        $kh = new khadamat_class((int)$id);
        return(isset($kh->id)?$kh->name:'----');
    }
    function loadUser($id)
    {
        $u = new user_class((int)$id);
        return(isset($u->id)?$u->fname.' '.$u->lname:'----');
    }
    function loadDate($inp)
    {
        return(($inp!='' && $inp!='0000-00-00 00:00:00')?jdate("Y-m-d",  strtotime($inp)):'----');
    }
    function loadMarhale($marhale)
    {
        $mar = array(
            "profile" => 'شروع',
            "khadamat_1" => 'انتخاب خدمات',
            "khadamat_2" => 'ورود اطلاعات',
            "khadamat_3" => 'فرم ها',
            "khadamat_4" => 'مالی',
            "khadamat_5" => 'تأمین کننده ها'
        );
        return($mar[$marhale]);
    }
    function isTasfiye($en)
    {
        return('<span class="glyphicon glyphicon-'.(((int)$en==1)?'ok':'remove').'" ></span>');
    }
    function monize($str,$per=FALSE)
    {
        $out=$str;
        $out=str_replace(',','',$out);
        $out=str_replace('.','',$out);
        $j=-1;
        $tmp='';
        //$strr=explode(' ',$str);
        for($i=strlen($str)-1;$i>=0;$i--){
                        //alert(txt[i]);
                if($j<2){
                        $j++;
                        $tmp=substr($str,$i,1) . $tmp;
                }else{
                        $j=0;
                        $tmp=substr($str,$i,1) . ',' . $tmp;
                }
        }                
        $out=$tmp;
        return (($per===FALSE)?$out:nc_model::enToPerNums($out));
    }
    function loadFactorSearch()
    {
        return(factor_class::loadAll());
    }
    function loadKhadamatSearch()
    {
        $kh = khadamat_class::loadAll2();
        $out = array();
        foreach($kh as $k)
        {
            $out[] = array(
                "id" => $k['id'],
                "val" => $k['name']
            );
        }
        return($out);
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

    $gname1 = "gname_khadamat_factor";
    $input =array($gname1=>array('table'=>'khadamat_factor','div'=>'div_factor'));
    $xgrid1 = new xgrid($input,site_url().'khadamat_report?');
    $xgrid1->pageRows[$gname1]=10;
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'فاکتور';
    $xgrid1->column[$gname1][1]['search'] = 'list';
    $xgrid1->column[$gname1][1]['searchDetails'] = loadFactorSearch();
    $xgrid1->column[$gname1][2]['name'] = 'خدمات';
    $xgrid1->column[$gname1][2]['cfunction'] = array('loadKhadamat');
    $xgrid1->column[$gname1][2]['search'] = 'list';
    $xgrid1->column[$gname1][2]['searchDetails'] = loadKhadamatSearch();
    $xgrid1->column[$gname1][3]['name'] = 'مبلغ';
    $xgrid1->column[$gname1][3]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][4]['name'] = 'کمیسیون';
    $xgrid1->column[$gname1][4]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][5]['name'] = 'جایزه';
    $xgrid1->column[$gname1][5]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][6]['name'] = 'سود';
    $xgrid1->column[$gname1][6]['cfunction'] = array('monize');
    /*
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'کاربر';
    $xgrid1->column[$gname1][1]['cfunction'] = array('loadUser');
    $xgrid1->column[$gname1][1]['search'] = 'list';
    $xgrid1->column[$gname1][1]['searchDetails'] = loadUserSearch();
    $xgrid1->column[$gname1][2]['name'] = 'تاریخ';
    $xgrid1->column[$gname1][2]['cfunction'] = array('loadDate');
    $xgrid1->column[$gname1][3]['name'] = 'اپراتور';
    $xgrid1->column[$gname1][3]['search'] = 'list';
    $xgrid1->column[$gname1][3]['searchDetails'] = loadUserSearch();
    $xgrid1->column[$gname1][3]['cfunction'] = array('loadUser');
    $xgrid1->column[$gname1][4]['name'] = 'مرحله';
    $xgrid1->column[$gname1][4]['cfunction'] = array('loadMarhale');
    $xgrid1->column[$gname1][5]['name'] = 'تصفیه';
    $xgrid1->column[$gname1][5]['access'] = 1;
    $xgrid1->column[$gname1][5]['cfunction'] = array('isTasfiye');
    $xgrid1->column[$gname1][6]['name'] = 'تاریخ تصفیه';
    $xgrid1->column[$gname1][6]['cfunction'] = array('loadDate');
    $xgrid1->column[$gname1][7]['name'] = 'کمیسیون';
    $xgrid1->column[$gname1][7]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][8]['name'] = 'تخفیف';
    $xgrid1->column[$gname1][8]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][9]['name'] = 'جایزه';
    $xgrid1->column[$gname1][9]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][10]['name'] = '';
    $xgrid1->column[$gname1][11]['name'] = 'مبلغ';
    $xgrid1->column[$gname1][11]['cfunction'] = array('monize');
    $xgrid1->column[$gname1][12]['name'] = 'همراه';
    $xgrid1->column[$gname1][13]['name'] = 'ایمیل';
     * 
     */
    $xgrid1->canEdit[$gname1]=FALSE;
    $xgrid1->canAdd[$gname1]=FALSE;
    $xgrid1->canDelete[$gname1]=FALSE;
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        args[ggname_project]['afterLoad']=function(){
            $("select").css("width","150px");
            $("#pageNumber-gname_user").css("width","50px");
            $("select").select2({
                dir:'rtl'
            });
        };
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
            گزارش خدمات
            </div>
            <div id="div_factor" ></div>
        </div>
    </div>
</div>