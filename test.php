<?php
$xmlStr = '<OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 
            OTA_AirLowFareSearchRQ.xsd" EchoToken="50987" TimeStamp="2015-08-29T08:51:00+03:30"
            Target="Test" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
                  <POS>
                          <Source AirlineVendorID="JI" ISOCountry="IR" ISOCurrency="IRR">
                                  <RequestorID Type="5" ID="DELTABAN"/>
                          </Source>
                  </POS>
                  <OriginDestinationInformation>
                          <DepartureDateTime>2015-08-30</DepartureDateTime>
                          <OriginLocation LocationCode="THR"/>
                          <DestinationLocation LocationCode="MHD"/>
                  </OriginDestinationInformation>

               <TravelPreferences >
                  <CabinPref  Cabin="Economy"/>
               </TravelPreferences>

                  <TravelerInfoSummary>
                          <AirTravelerAvail>				
                                  <PassengerTypeQuantity Code="ADT" Quantity="1"/>			
                          </AirTravelerAvail>
                  </TravelerInfoSummary>
                  <ProcessingInfo SearchType="NEGO"/>
          </OTA_AirLowFareSearchRQ>';




$curlOptions = array(
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_FOLLOWLOCATION => TRUE,
    CURLOPT_VERBOSE => TRUE,
    CURLOPT_STDERR => $verbose = fopen('php://temp', 'rw+'),
    CURLOPT_FILETIME => TRUE,
    //CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    //CURLOPT_USERPWD => 'JUOCCQSfBKn3JWyO9MBr1ihpvl9KPHTR',
    CURLOPT_HTTPHEADER => array('Content-Type: application/xml','Authorization: Basic f2RuV8no3N4YRLhmeoA+QM46LSG/B9n95L/xLJ9C0rE='),
    CURLOPT_POST => TRUE,
    CURLOPT_POSTFIELDS => $xmlStr
);

$url = "http://products.proavos.com:9191/wsbe/rest/availability/lowfaresearch";
$handle = curl_init($url);
curl_setopt_array($handle, $curlOptions);
$content = curl_exec($handle);
echo "Verbose information:\n", !rewind($verbose), stream_get_contents($verbose), "\n";
echo "REQUEST :\n".$xmlStr."\n";
curl_close($handle);
echo $content;