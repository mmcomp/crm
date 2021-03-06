<?php
class city_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `city` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadByIata($iata)
    {
        $out = -1;
        if(trim($iata) != '')
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select id from `city` where `iata` = '$iata'",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                $out = (int)$r['id'];
            }
        }
        return($out);
    }
    public static function loadAllIata()
    {
        $out='';
        $my = new mysql_class;
        //$wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select iata,name from city order by name", $q);
        foreach($q as $r)
        {
            $out.='<option value="'.$r['iata'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }  
    public static function loadAll($selected=0)
    {
        $out='';
        $my = new mysql_class;
        //$wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select id,name from city order by name", $q);
        foreach($q as $r)
        {
            $out.='<option '.($selected==$r['id']?'selected="selected"':'').' value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }          
    public static function loadAllSel($selected,$country_id=0)
    {
        $out='';
        $my = new mysql_class;
        $wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select id,name from city $wer order by name", $q);
        foreach($q as $r)
        {
            $out.='<option value="'.$r['id'].'" '.(($selected==(int)$r['id'])?'selected':'').'>'.$r['name'].'</option>';
        }
        return ($out);
    }
    public static function add($name,$iata,$country_id)
    {
        $my = new mysql_class;
        $ln = $my->ex_sqlx("insert into city (name,iata,country_id) values ('$name','$iata',$country_id)");
        $out = $my->insert_id($ln);
        return($out);
    }
}


