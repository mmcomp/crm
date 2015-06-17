<?php
    class addParvaz{
        public $m;
        public function __construct() {
            $this->m = new mysqli('localhost','root','3068145','mahan');
        }
        public function add($flight){
            $ok = FALSE;
            if($this->m->connect_errno!==FALSE)
            {
                $ok = $this->m->query("insert into `parvaz` (`FlightNumber`, `ArrivalDateTime`, `DepartureDateTime`, `JourneyDuration`, `RPH`, `DestinationLocation_text`, `DestinationLocation_iata`, `OriginLocation_text`, `OriginLocation_iata`, `zarfiat`) values ('".$flight['FlightNumber']."', '".$flight['ArrivalDateTime']."', '".$flight['DepartureDateTime']."', '".$flight['JourneyDuration']."', '".$flight['RPH']."', '".$flight['DestinationLocation']['text']."', '".$flight['DestinationLocation']['iata']."', '".$flight['OriginLocation']['text']."', '".$flight['OriginLocation']['iata']."', 9)");
            }
            return($ok);
        }
    }
    class MyClass{
        function getFactors($string) { 
            $out = array();
            $m = new mysqli('localhost','root','3068145','crm');
            if($this->m->connect_errno!==FALSE)
            {
                $dt = $m->query("select * from factor where date(tarikh) > '$string'");
                while($obj = $dt->fetch_object()){ 
                    $out[] = $obj;
                }
            }
            //   return "Length of the string " . $string . "is : ".strlen($string);
            return(json_encode($out));
        }
        function hello($string)
        {
            return "Hello `$string`.";
        }
    }
    $server = new SoapServer(null, 
                array('uri' => "urn://www.mirsamie.com")); 
    $server->setClass("MyClass");
    $server->handle(); 
