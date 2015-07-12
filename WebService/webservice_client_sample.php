<?php
    $URL = 'http://192.168.2.80/crm/WebService/w.php';

    $client = new SoapClient(null, array(
        'location' => $URL,
        'uri'      => "http://192.168.2.80/crm/WebService/",
        'trace'    => 1,
    ));
    $response = $client->__soapCall("getFactors", array());
    $result = json_decode($response);
    var_dump($result);