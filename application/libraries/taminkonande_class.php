<?php
class taminkonande_class extends CI_Model {
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `taminkonande` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadAll($selected=0)
    {
        $out='';
        $my = new mysql_class;
        //$wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select id,name from taminkonande order by ordering,name", $q);
        foreach($q as $r)
        {
            $out.='<option '.($selected==$r['id']?'selected="selected"':'').' value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }
    public static function loadView($factor_id)
    {
        $out = '';
        $my = new mysql_class;
        $my->ex_sql("select khadamat_factor.khadamat_id,taminkonande_id,khadamat.name,khadamat.typ,tamin_khadamat.mablagh,tamin_khadamat.vahed_mablagh_id,tamin_khadamat.toz from khadamat_factor left join tamin_khadamat on (tamin_khadamat.khadamat_id=khadamat_factor.khadamat_id) left join khadamat on (khadamat.id=khadamat_factor.khadamat_id) where khadamat_factor.factor_id=$factor_id",$q);
        foreach ($q as $r)
        {
            $out.='
                    <div class="col-sm-2 hs-padding" >
                        '.$r['name'].'
                        <input type="hidden" name="khadamat_id" value="'.$r['khadamat_id'].'" >
                    </div>
                    <div class="col-sm-3 hs-padding" >
                        <select class="sel_2" style="width: 100%;" name="taminkonande_id" >
                            <option value="-1" >انتخاب تأمین کننده</option>
                            '.taminkonande_class::loadAll((int)$r['taminkonande_id']).'
                        </select>
                    </div>
                    <div class="col-sm-2 hs-padding" >
                        <input value="'.(isset($r['mablagh'])?$r['mablagh']:'').'" class="form-control" type="text" name="mablagh[]" placeholder="قیمت خرید"  >
                    </div>
                    <div class="col-sm-1 hs-padding" >
                        <small>
                            <select class="sel_2" style="width: 100%;" name="vahed_mablagh_id[]">
                                <option>واحد</option>  
                                '.(vahed_mablagh_class::loadAll((int)$r['vahed_mablagh_id'])).'
                            </select>
                        </small>
                    </div>
                    <div class="col-sm-4 hs-padding" >
                        <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" value="'.(isset($r['toz'])?$r['toz']:'').'" >
                    </div>
                ';
        }
        return($out);
    }
}

