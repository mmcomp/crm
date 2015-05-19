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
            //echo "select * from `parvaz` where `khadamat_factor_id` = $kfid";
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
        $my = new mysql_class;
        $field='';
        $values = '';
        foreach($parvaz as $fi=>$val)
        {
            if($parvaz)
            $field.= ($field==''?'':',')."`$fi`";
            $values.= ($values==''?'':',')."'$val'";
        }
        $qu = "insert into parvaz ($field) values ($values)";
        echo $qu;
        //$ln = $my->ex_sqlx($qu,FALSE);
        //$out = $my->insert_id($ln);
        //$my->close($ln);
        $out='';
        return($out);
    }
    public static function loadKhadamat_factor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select id from khadamat_factor where factor_id=$factor_id and khadamat_id=1",$q);
        return(count($q)>0?$q[0]['id']:-1);
    }        
    public function loadByFactor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select * from parvaz where factor_id=$factor_id", $q);
        $out=array();
        foreach($q as $r)
        {
            $tmp = new parvaz_class;
            if((int)$r['is_bargasht']==0)
            {    
                foreach($r as $k=>$v)
                {    
                    $tmp->$k = $v;
                }
                $out['raft'] = $tmp;
            }
            else
            {
                foreach($r as $k=>$v)
                {    
                    $tmp->$k = $v;
                }
                $out['bargasht'] = $tmp;
            }
        }
        return($out);
    }         
} 

