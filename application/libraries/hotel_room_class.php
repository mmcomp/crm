<?php
class hotel_room_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `hotel_room` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }  
    public static function loadByFactorId($fid)
    {
        $mysql = new mysql_class;
        $mysql->ex_sql("select * from `hotel_room` where `factor_id` = $fid",$q);
        return($q);
    }
}


