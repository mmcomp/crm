<?php
class parvaz_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `parvaz` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public function loadByKhadamatFactor($kfid)
    {
        if((int)$kfid > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `parvaz` where `khadamat_factor_id` = $kfid",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function add($parvaz)
    {
        
    }        
} 

