<?php
    class mosafer_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `mosafer` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function add($fname,$lname,$code_melli,$passport, $passport_engheza, $gender, $age, $tarikh_tavalod, $khadamat_factor_id)
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into `mosafer` (`fname`, `lname`, `code_melli`, `passport`, `passport_engheza`, `gender`, `age`, `tarikh_tavalod`, `khadamat_factor_id`) values ('$fname','$lname','$code_melli','$passport', '$passport_engheza', $gender, '$age', '$tarikh_tavalod', $khadamat_factor_id)",FALSE);
            $id = $mysql->insert_id($ln);
            $mysql->close($ln);
            return($id);
        }
        public static function loadByFactor($factor_id)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select `khadamat`.`typ` `khadamat_type`,`khadamat`.`name` `khadamat_name`,`mosafer`.`id`,`fname`, `lname`, `code_melli`, `passport`, `passport_engheza`, `gender`, `age`, `tarikh_tavalod`, `khadamat_factor_id` from `mosafer` left join `khadamat_factor` on (`khadamat_factor_id`=`khadamat_factor`.`id`) left join `khadamat` on (`khadamat`.`id`=`khadamat_id`) where `factor_id` = $factor_id order by `typ`",$q);
            return($q);
        }
    }
