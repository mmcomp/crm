<?php
    class fibo_class
    {
        public static function add($factor_id)
        {
            $tmp = array();
            $my = new mysql_class;
            $query  = "SELECT khadamat.code_hesab kcode_hesab,factor.id iid,factor.code_hesab code_hesab,factor.user_id user_id,mosafer.id,fname,lname,age,ticket_number, mabda_id,maghsad_id,parvaz.tarikh ptarikh,factor.tarikh ftarikh,saat,airline,shomare,parvaz.khadamat_factor_id,factor.mablagh,commision,user_creator FROM mosafer left join `parvaz` on (parvaz.khadamat_factor_id=mosafer.khadamat_factor_id) left join khadamat_factor on (mosafer.khadamat_factor_id=khadamat_factor.id) left join khadamat on (khadamat.id=khadamat_factor.khadamat_id) left join factor on (factor.id = khadamat_factor.factor_id) where khadamat_factor.factor_id = $factor_id";
            $my->ex_sql($query, $q);
            foreach($q as $r)
            {
                $user = new user_class((int)$r['user_id']);
                
                $URL = 'http://192.168.2.28/Service1.asmx?wsdl';
                $client = new SoapClient($URL);
                $netfare = (int)$r['mablagh'] - (int)$r['commision'];
                $tax = (int)(0.5*(int)$r['mablagh']);
                $total = $netfare + $tax;
                $crcn = (int)$r['commision'];
                $from = new city_class((int)$r['mabda_id']);
                $to = new city_class((int)$r['maghsad_id']);
                $cuser = new user_class((int)$r['user_creator']);
                if(isset($from->id) && isset($to->id) && isset($cuser->id))
                {
                    $data = array(
                        "PNR" => $r['iid'],
                        "IsInternational" => 0,
                        "TicketNumber" => $r['ticket_number'],
                        "TicketType" => 1,
                        "AirlineCode" => "",
                        "AirlineNumber" => "",
                        "Fare" => $r['mablagh'],
                        "Tax" => 0,
                        "Total" => 0,
                        "NetFare" => 0,
                        "CRCN" => 0,
                        "Commision" => (int)$r['commision'],
                        "Route" => $from->iata.$to->iata,
                        "AgeType" => $r['age'],
                        "PaxName" => $r['fname'],
                        "PaxFamily" => $r['lname'],
                        "FlightNumber" => $r['shomare'],
                        "FlightDate" => date("Ymd",  strtotime($r['ptarikh'])),
                        "FlightTime"=> date("H:i",  strtotime($r['saat'])),
                        "IssueDate" => date("Ymd",  strtotime($r['ftarikh'])),
                        "IssuerName" => $cuser->fname.' '.$cuser->lname,
                        "IssuerID" => $cuser->fid,// ارسال کد فیبو//$r['user_creator'],
                        "TicketImage" => "",
                        "AccountCode" => $r['code_hesab'],//$user->code_hesab
                        "Tour Account" => $r['kcode_hesab']
                    );
                    $dataToSend = json_encode($data);
                    $client->SaveTicketJson(array("ticketJson"=>$dataToSend));
                }
            }
        }
    }