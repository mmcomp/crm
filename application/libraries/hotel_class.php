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
    public static function add($hotel,$hotel_room)
    {
        $my = new mysql_class;
        $field='';
        $values = '';
        if($hotel['hotel_id']==-1)
        {    
            foreach($hotel as $fi=>$val)
            {
                if($fi!='hotel_id')
                {    
                    $field.= ($field==''?'':',')."`$fi`";
                    $values.= ($values==''?'':',')."'$val'";
                }    
            }
            $qu = "insert into hotel ($field) values ($values)";
            //echo $qu.'<br/>';
            $ln = $my->ex_sqlx($qu,FALSE);
            $out = $my->insert_id($ln);
            $my->close($ln);
        }
        else
        {
             
            foreach($hotel as $fi=>$val)
            {
                if($fi!='hotel_id')
                {
                    $field.= ($field==''?'':',')."`$fi`='$val'";
                }
            }
            $qu = "update hotel set $field where id =".$hotel['hotel_id'];
            //echo $qu.'<br/>';
            $my->ex_sqlx($qu);
            $out=TRUE;
        }    
        $my->ex_sqlx("update hotel_room set tmp=0 where factor_id = ".$hotel['factor_id']);
        foreach($hotel_room as $hotel_room_det)
        {    
            $field='';
            $values = '';
            if($hotel_room_det['hotel_khadamat_id']==-1)
            {    
                foreach($hotel_room_det as $fi=>$val)
                {
                    if($fi!='hotel_khadamat_id')
                    {    
                        $field.= ($field==''?'':',')."`$fi`";
                        $values.= ($values==''?'':',')."'$val'";
                    }
                }
                //echo "insert into hotel_room ($field) values ($values)".'<br/>';;
                $my->ex_sqlx("insert into hotel_room ($field) values ($values)",FALSE);
            }
            else
            {
                foreach($hotel_room_det as $fi=>$val)
                {
                    if($fi!='hotel_khadamat_id')
                    {
                        $field.= ($field==''?'':',')."`$fi`='$val'";
                    }    
                }
                $my->ex_sqlx("update hotel_room set $field,tmp=1 where id =".$hotel_room_det['hotel_khadamat_id'],FALSE);
            }    
        }    
        $my->ex_sqlx("delete from  hotel_room where tmp=0 and factor_id = ".$hotel['factor_id']);
        return($out);
    }
    public function loadByFactor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select * from hotel where factor_id=$factor_id", $q);
        if(isset($q[0]))
        {
            $r = $q[0];
            foreach($r as $k=>$v)
            {    
                $this->$k = $v;
            }    
        }
    }        
}


