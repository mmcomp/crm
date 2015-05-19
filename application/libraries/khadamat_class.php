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
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

