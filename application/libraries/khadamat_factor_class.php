<?php
    class khadamat_factor_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `khadamat_factor` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function loadKhadamats($factor_id)
        {
            $out= array();
            $my= new mysql_class;
            $my->ex_sql("select khadamat_id from khadamat_factor  where factor_id=$factor_id",$q);
            if(count($q)>0)
            {    
                foreach($q as $r)
                    $out[] = $r['khadamat_id'];    
            }
            return($out);
        }        
    }
