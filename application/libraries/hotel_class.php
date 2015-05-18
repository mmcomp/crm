<?php
class hotel_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `hotel` where `id` = $id",$q);
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
            $mysql->ex_sql("select * from `hotel` where `khadamat_factor_id` = $kfid",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadKhadamat_factor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select id from khadamat_factor where factor_id=$factor_id and khadamat_id=2",$q);
        return(count($q)>0?$q[0]['id']:-1);
    }
    public static function add($hotel)
    {
        $my = new mysql_class;
        $field='';
        $values = '';
        foreach($hotel as $fi=>$val)
        {
            $field.= ($field==''?'':',')."`$fi`";
            $values.= ($values==''?'':',')."'$val'";
        }
        $qu = "insert into hotel ($field) values ($values)";
        echo $qu;
        $ln = $my->ex_sqlx($qu,FALSE);
        $out = $my->insert_id($ln);
        $my->close($ln);
        return($out);
    }
}


