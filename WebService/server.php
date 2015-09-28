<?php

//call library
date_default_timezone_set('Asia/Tehran');

require_once('lib/nusoap.php');
$URL = "www.gohar724.com";
$namespace = $URL . '?wsdl';
//using soap_server to create server object
$server = new soap_server;
$server->configureWSDL('CRM_WebService', $namespace);

//register a function that works on server
$server->register('getFactors', array("aztarikh" => "xsd:string", "tatarikh" => "xsd:string"), array("return" => "xsd:string"));
$server->register('getFactorsTest', array("aztarikh" => "xsd:string", "tatarikh" => "xsd:string"), array("return" => "xsd:string"));
$server->register('getTamin', array("aztarikh" => "xsd:string", "tatarikh" => "xsd:string"), array("return" => "xsd:string"));
$server->register('getTaminTest', array("aztarikh" => "xsd:string", "tatarikh" => "xsd:string"), array("return" => "xsd:string"));

// create the function
function getFactorsTest($aztarikh, $tatarikh) {
    return('[{"Tour Accounting ID":"65454654","IssueDate":"2015-06-17 08:01:27","ServiceType":"\u0647\u062a\u0644","ServiceDetails":"\u0631\u0632\u0648\u0631 \u0647\u062a\u0644","Time 1st":"20150706","Time 2nd":"20150710","Contract Number":"11","Discount Accounting ID":"65456456","Discount Amount":"200","VAT Accounting ID":"879797","VAT Amount":"4500.0","Datasource System Code Type":"\u06af\u0648\u0647\u0631","Datesource System Code":"4","Factor Amount":"5000","Profit Accounting ID":"asdsdsads","Customer Accounting ID":"321543"}]');
}

function getFactors($aztarikh, $tatarikh) {
    $outt = "aztarikh = $aztarikh, tatarikh = $tatarikh";
    $tark = '';
    $aztarikh = trim($aztarikh);
    $tatarikh = trim($tatarikh);
    if (strlen($aztarikh) == 8) {
        $aztarikh = substr($aztarikh, 0, 4) . '-' . substr($aztarikh, 4, 2) . '-' . substr($aztarikh, 6, 2);
        $tark = " and tarikh >= '$aztarikh'";
    }
    if (strlen($tatarikh) == 8) {
        $tatarikh = substr($tatarikh, 0, 4) . '-' . substr($tatarikh, 4, 2) . '-' . substr($tatarikh, 6, 2);
        $tark .= " and tarikh <= '$tatarikh'";
    }
    $out = array();
    $m = new mysqli('localhost', 'root', '3068145', 'crm');
    if ($m->connect_errno !== FALSE) {
        $m->set_charset("utf8");
        $takhfif_hesab = '65456456';
        $maliat_hesab = '879797';
        $system_code = "4";
        $soodHesab = 'asdsdsads';
        $afzoode = "0.9";
        //SELECT khadamat.code_hesab `Tour Accounting ID`,tarikh IssueDate,'هتل' ServiceType,'رزور هتل' ServiceDetails,date_format(az_tarikh,'%Y%m%d') `Time 1st`,date_format(ta_tarikh,'%Y%m%d') `Time 2nd`,factor.id `Contract Number`, '$takhfif_hesab' `Discount Accounting ID`,takhfif `Discount Amount`,'$maliat_hesab' `VAT Accounting ID`,factor.mablagh*$afzoode `VAT Amount`, 'گوهر' `Datasource System Code Type`,'$system_code' `Datesource System Code`, factor.mablagh `Factor Amount`,'$soodHesab' `Profit Accounting ID`,factor.code_hesab `Customer Accounting ID` FROM `hotel` left join khadamat_factor on (khadamat_factor.id=khadamat_factor_id) left join khadamat on (khadamat_id=khadamat.id) left join `factor` on (hotel.factor_id=factor.id) WHERE is_tasfieh = 1
        $dt = $m->query("SELECT khadamat.code_hesab `Tour Accounting ID`,tarikh IssueDate,'هتل' ServiceType,'رزور هتل' ServiceDetails,date_format(az_tarikh,'%Y%m%d') `Time 1st`,date_format(ta_tarikh,'%Y%m%d') `Time 2nd`,factor.id `Contract Number`, '$takhfif_hesab' `Discount Accounting ID`,takhfif `Discount Amount`,'$maliat_hesab' `VAT Accounting ID`,factor.mablagh*$afzoode `VAT Amount`, 'گوهر' `Datasource System Code Type`,'$system_code' `Datesource System Code`, factor.mablagh `Factor Amount`,'$soodHesab' `Profit Accounting ID`,factor.code_hesab `Customer Accounting ID` FROM `hotel` left join khadamat_factor on (khadamat_factor.id=khadamat_factor_id) left join khadamat on (khadamat_id=khadamat.id) left join `factor` on (hotel.factor_id=factor.id) WHERE is_tasfieh = 1 $tark");
        while ($obj = $dt->fetch_object()) {
            $out[] = $obj;
        }
    }
    //   return "Length of the string " . $string . "is : ".strlen($string);
    //file_put_contents("webservice_req.html", $outt."<br/>\n".json_encode($out));
    return(json_encode($out));
}

function getTaminTest($aztarikh, $tatarikh) {
    return('[{"factor_id":"11","code_hesab":"","mablagh":"20000","khadamat_name":"\u0628\u0644\u06cc\u062a \u0647\u0648\u0627\u067e\u06cc\u0645\u0627 \u062f\u0627\u062e\u0644\u06cc -","khadamat_det":"\u0631\u0641\u062a","toz":"\u062a\u0648\u0636\u06cc\u062d\u0627\u062a \u0627\u06cc\u0646 \u0641\u0627\u06a9\u062a\u0648\u0631 \u0634\u0645\u0627\u0631\u0647 \u06cc\u0627\u0632\u062f\u0647"},{"factor_id":"11","code_hesab":"","mablagh":"10000","khadamat_name":"\u0647\u062a\u0644 \u062f\u0627\u062e\u0644\u06cc","khadamat_det":"\u0647\u062a\u0644 \u062f\u0627\u062e\u0644\u06cc","toz":"\u0646\u062f\u0627\u0631\u062f"}]');
}

function getTamin($aztarikh, $tatarikh) {
    $outt = "aztarikh = $aztarikh, tatarikh = $tatarikh";
    //SELECT factor_id,taminkonande.code_hesab,tamin_khadamat.mablagh,khadamat.name khadamat_name,khadamat_tamin.name khadamat_det,tamin_khadamat.toz FROM `tamin_khadamat` left join taminkonande on (`taminkonande_id`=taminkonande.id) left join khadamat_tamin on (khadamat_tamin.id=khadamat_tamin_id) left join khadamat on (khadamat.id=tamin_khadamat.khadamat_id) left join factor on (factor.id=factor_id) where is_tasfieh = 1
    $tark = '';
    $aztarikh = trim($aztarikh);
    $tatarikh = trim($tatarikh);
    if (strlen($aztarikh) == 8) {
        $aztarikh = substr($aztarikh, 0, 4) . '-' . substr($aztarikh, 4, 2) . '-' . substr($aztarikh, 6, 2);
        $tark = " and tarikh >= '$aztarikh'";
    }
    if (strlen($tatarikh) == 8) {
        $tatarikh = substr($tatarikh, 0, 4) . '-' . substr($tatarikh, 4, 2) . '-' . substr($tatarikh, 6, 2);
        $tark .= " and tarikh <= '$tatarikh'";
    }
    $out = array();
    $m = new mysqli('localhost', 'root', '3068145', 'crm');
    if ($m->connect_errno !== FALSE) {
        $m->set_charset("utf8");
        $dt = $m->query("SELECT factor_id,tamin_khadamat.code_hesab,tamin_khadamat.mablagh,khadamat.name khadamat_name,khadamat_tamin.name khadamat_det,tamin_khadamat.toz FROM `tamin_khadamat` left join taminkonande on (`taminkonande_id`=taminkonande.id) left join khadamat_tamin on (khadamat_tamin.id=khadamat_tamin_id) left join khadamat on (khadamat.id=tamin_khadamat.khadamat_id) left join factor on (factor.id=factor_id) where is_tasfieh = 1 $tark");
//        $out[] = "SELECT factor_id,tcode_hesab,tamin_khadamat.mablagh,khadamat.name khadamat_name,khadamat_tamin.name khadamat_det,tamin_khadamat.toz FROM `tamin_khadamat` left join taminkonande on (`taminkonande_id`=taminkonande.id) left join khadamat_tamin on (khadamat_tamin.id=khadamat_tamin_id) left join khadamat on (khadamat.id=tamin_khadamat.khadamat_id) left join factor on (factor.id=factor_id) where is_tasfieh = 1 $tark";
        if ($dt) {
            while ($obj = $dt->fetch_object()) {
                $out[] = $obj;
            }
        }
    }
    //   return "Length of the string " . $string . "is : ".strlen($string);
    //file_put_contents("webservice_req.html", $outt."<br/>\n".json_encode($out));
    return(json_encode($out));
}

// create HTTP listener
$post = file_get_contents('php://input');
$server->service($post);
exit();
