<?php
    class factor_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `factor` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function loadAll()
        {
            $out = array();
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `factor` order by `tarikh`",$q);
            foreach($q as $r)
            {    
                $out[] = array("id"=>(int)$r['id'],"val"=>$r['id']);
            }    
            return($out);
        }
        public function add($user_id,$user_creator_id,$tarikh)
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into `factor` (`user_id`,`user_creator`,`tarikh`) values ($user_id,$user_creator_id,'$tarikh')",FALSE);
            $id = $mysql->insert_id($ln);
            $mysql->close($ln);
            return($id);
        }
        public static function loadTypes($factor_id)
        {
            $out= array();
            $my= new mysql_class;
            $my->ex_sql("select typ from factor left join khadamat_factor on (factor_id=factor.id) left join khadamat on (khadamat_id=khadamat.id) where factor.id=$factor_id",$q);
            if(count($q)>0)
            {    
                foreach($q as $r)
                    $out[] = $r['typ'];    
            }
            return($out);
        }
        public static function loadByUser($user_id,$all = FALSE)
        {
            $my= new mysql_class;
            $my->ex_sql("select * from `factor` where `user_id` = $user_id ".(($all===FALSE)?' and `is_tasfieh` = 0':'')." order by tarikh desc",$q);
            return($q);
        }
        public static function marhale($factor_id,$name)
        {
            $my = new mysql_class;
            $my->ex_sqlx("update factor set marhale='$name' where id=$factor_id");
            return(TRUE);
        }
        public static function tasfie($factor_id)
        {
            $date = date("Y-m-d H:i:s");
            $my = new mysql_class;
            $my->ex_sqlx("update `factor` set `is_tasfieh`=1,`tarikh_tasfieh`='$date' where id=$factor_id");
            fibo_class::add($factor_id);            
        }
        public static function isParvazOk($factor_id)
        {
            $out = TRUE;
            $my = new mysql_class;
            $my->ex_sql("select mosafer.id,ticket_number from mosafer left join parvaz on (parvaz.khadamat_factor_id=mosafer.khadamat_factor_id) where gohar_voucher_id>0 and factor_id = $factor_id", $q);
            foreach($q as $r)
            {
                if(trim($r['ticket_number'])=='')
                {
                    $out = FALSE;
                }
            }
            return($out);
        }
    }
