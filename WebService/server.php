<?php
//call library
    date_default_timezone_set('Asia/Tehran');

require_once('lib/nusoap.php');
$URL       = "www.gohar724.com";
$namespace = $URL . '?wsdl';
//using soap_server to create server object
$server    = new soap_server;
$server->configureWSDL('CRM_WebService', $namespace);

//register a function that works on server
$server->register('getFactors',array("aztarikh" => "xsd:string","tatarikh" => "xsd:string"),array("return" => "xsd:string"));

// create the function
function getFactors($aztarikh,$tatarikh) { 
    $tark = '';
    $aztarikh = trim($aztarikh);
    $tatarikh = trim($tatarikh);
    if(strlen($aztarikh)==8)
    {
        $aztarikh = substr($aztarikh, 0,4).'-'.substr($aztarikh, 4,2).'-'.substr($aztarikh, 6,2);
        $tark = " and tarikh >= '$aztarikh'";
    }
    if(strlen($tatarikh)==8)
    {
        $tatarikh = substr($tatarikh, 0,4).'-'.substr($tatarikh, 4,2).'-'.substr($tatarikh, 6,2);
        $tark .= " and tarikh <= '$tatarikh'";
    }
    $out = array();
    $m = new mysqli('localhost','root','3068145','crm');
    if($m->connect_errno!==FALSE)
    {
        $takhfif_hesab = '65456456';
        $maliat_hesab = '879797';
        $system_code = "45";
        $afzoode = "0.9";
        $dt = $m->query("SELECT tarikh IssueDate,'هتل' ServiceType,'رزور هتل' ServiceDetails,date_format(az_tarikh,'%Y%m%d') `Time 1st`,date_format(ta_tarikh,'%Y%m%d') `Time 2nd`,factor.id `Contract Number`, '$takhfif_hesab' `Discount Accounting ID`,takhfif `Discount Amount`,'$maliat_hesab' `VAT Accounting ID`,mablagh*$afzoode `VAT Amount`, 'گوهر' `Datasource System Code Type`,'$system_code' `Datesource System Code`, mablagh `Factor Amount` FROM `hotel` left join `factor` on (factor_id=factor.id) WHERE is_tasfieh = 1 $tark");
        while($obj = $dt->fetch_object()){ 
            $out[] = $obj;
        }
    }
    //   return "Length of the string " . $string . "is : ".strlen($string);
    return(json_encode($out));
}
// create HTTP listener
$post = file_get_contents('php://input');
$server->service($post);
exit();