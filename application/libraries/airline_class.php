<?php
class airline_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `airline` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function add($name)
    {
        $out = -1;
        $name = trim($name);
        if($name != '')
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into  `airline` (`name`) values ('$name')",FALSE);
            $out = $mysql->insert_id($ln);
            $mysql->close($ln);
        }
        return($out);
    }
    public static function loadByName($name)
    {
        $out = -1;
        $name = trim($name);
        if($name != '')
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select id from `airline` where `name` = '$name'",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                $out = (int)$r['id'];
            }
        }
        return($out);
    }
    public static function loadAll($selected=-1)
    {
        $out='';
        $my = new mysql_class;
        $my->ex_sql("select `id`,`name` from `airline` order by `name`", $q);
        foreach($q as $r)
        {
            $out.='<option value="'.$r['id'].'" '.(($selected==(int)$r['id'])?'selected':'').'>'.trim($r['name']).'</option>';
        }
        return ($out);
    }        
}


