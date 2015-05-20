<?php
class khadamat_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `khadamat` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadAll($inp)
    {
        $out='';
        $my = new mysql_class;
        $my->ex_sql("select id,name from khadamat order by ordering desc", $q);
        foreach($q as $r)
        {
            $out.='<option '.(in_array($r['id'],$inp)?'selected="selected"':'').'  value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }
    public static function loadTypes($inp)
    {
        $out=array();
        if(count($inp)>0)
        {    
            $kh_ids = implode(',',$inp);
            $my = new mysql_class;
            $my->ex_sql("select typ from khadamat where id in ($kh_ids)",$q);
            if(count($q)>0)
            {    
                foreach($q as $r)
                    $out[] = $r['typ'];    
            }    
        }
        return($out);
    }
    public static function loadForooshView($factor_id)
    {
        $out = '';
        $my = new mysql_class;
        $my->ex_sql("select khadamat_id,name,`mablagh`, `comission`, `jayeze_code` from khadamat_factor left join khadamat on (khadamat_id=khadamat.id) where factor_id=$factor_id ", $q);
        foreach($q as $r)
        {
            $out.='
                    <div class="col-sm-1 text-center hs-margin-up-down" >
                        نام:
                    </div>
                    <div class="col-sm-2 hs-margin-up-down" >
                        <span>'.$r['name'].'</span>
                        <input type="hidden" name="khadamat_id[]" value="'.$r['khadamat_id'].'" >
                    </div>
                    <div class="col-sm-1 text-center hs-margin-up-down" >
                        قیمت:
                    </div>
                    <div class="col-sm-2" >
                        <input class="form-control hs-margin-up-down" name="mablagh[]" value="'.$r['mablagh'].'" >
                    </div>
                    <div class="col-sm-1 text-center hs-margin-up-down" >
                        کمیسیون:
                    </div>
                    <div class="col-sm-2 hs-margin-up-down" >
                        <input class="form-control" name="comission[]" value="'.$r['comission'].'" >
                    </div>
                    <div class="col-sm-1 text-center hs-margin-up-down" >
                        جایزه:
                    </div>
                    <div class="col-sm-2 hs-margin-up-down" >
                        <input class="form-control" name="jayeze_code[]" value="'.$r['jayeze_code'].'">
                    </div>
                  ';
        }
        return($out);
    }
    public static function updateGhimat($factor_id,$request)
    {
        $my= new mysql_class;
        $sum = 0;
        $sum_comission = 0;
        for($i=0;$i<count($request['khadamat_id']);$i++)
        {
            $sum+= $request['mablagh'][$i];
            $sum_comission += $request['comission'][$i];
            $qu = "update khadamat_factor set mablagh='".$request['mablagh'][$i]."',comission='".$request['comission'][$i]."',jayeze_code='".$request['jayeze_code'][$i]."' where factor_id=$factor_id and khadamat_id=".$request['khadamat_id'][$i];
            $my->ex_sqlx($qu);
        }
        $my->ex_sqlx("update factor set `commision`=$sum_comission,`mablagh`=$sum where factor_id = $factor_id");
    }        
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

