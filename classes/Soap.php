<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Soap
 *
 * @author BellaGraph
 */
class Soap {
    private $WSIP = 'http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl';
    private $WSCOUNTRY = 'http://www.webservicex.net/country.asmx/GetCountries?';
    private $WSWEATHER = 'http://www.webservicex.com/globalweather.asmx?WSDL';
    
    
    public function get_location() {
        $ipGeo = new SoapClient($this->WSIP);

        if ($_SERVER['REMOTE_ADDR']=='::1') {$ip = '';} // IP test
        else {$ip = $_SERVER['REMOTE_ADDR'];}

        $params = array('ipAddress' => $ip, 'licenseKey' => '');
        $response = $ipGeo->ResolveIP($params);
        
        return $response->ResolveIPResult;
    }
    
    public function get_countries() {
        $curl = curl_init();

        curl_setopt_array($curl,
            array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->WSCOUNTRY,
                CURLOPT_SSL_VERIFYPEER => false
            )
        );

        $output = curl_exec($curl);
        if(!$output){die('Error: "'.curl_error($curl).'" - Code: '.curl_errno($curl));}
        else {
            $data = simplexml_load_string(html_entity_decode($output));
            return $data->NewDataSet->Table;
        }
        curl_close($curl);
    }
    
    public function get_cities($country) {
        $cities = new SoapClient($this->WSWEATHER);
        
        $params = array('CountryName' => $country);
        $response = $cities->GetCitiesByCountry($params);
        
        foreach ($response as $city) {
            $data = simplexml_load_string($city);
        }
        
        return $data->Table;
    }
    
    public function get_data($country, $city) {
        $weather = new SoapClient($this->WSWEATHER);
        
        $params = array('CountryName' => $country, 'CityName' => $city);
        $response = $weather->getWeather($params);
        
        foreach ($response as $values) {            
            if ($values !== 'Data Not Found') {
                $xml = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $values);
            }
            else {
                $xml = '<?xml version="1.0" encoding="utf-8"?>';
                $xml .= '<currentweather>
                            <Location>Data Not Found</Location>
                            <Time>Data Not Found</Time>
                            <Wind>Data Not Found</Wind>
                            <Visibility>Data Not Found</Visibility>
                            <SkyConditions>Data Not Found</SkyConditions>
                            <Temperature>Data Not Found</Temperature>
                            <DewPoint>Data Not Found</DewPoint>
                            <RelativeHumidity>Data Not Found</RelativeHumidity>
                            <Pressure>Data Not Found</Pressure>
                            <Status>Data Not Found</Status>
                        </currentweather>';
            }
            
            $data = simplexml_load_string($xml);
        }
        return $data;
    }
    
    public function normalizar($param1){        
        $a = array('/À/','/Á/','/Â/','/Ã/','/Ä/','/Å/','/Æ/','/Ç/','/È/','/É/','/Ê/','/Ë/','/Ì/','/Í/','/Î/','/Ï/','/Ð/','/Ò/','/Ó/','/Ô/','/Õ/','/Ö/','/Ø/','/Ù/','/Ú/','/Û/','/Ü/','/Ý/','/Þ/','/ß/','/à/','/á/','/â/','/ã/','/ä/','/å/','/æ/','/ç/','/è/','/é/','/ê/','/ë/','/ì/','/í/','/î/','/ï/','/ð/','/ò/','/ó/','/ô/','/õ/','/ö/','/ø/','/ù/','/ú/','/û/','/ü/','/ý/','/ý/','/þ/','/ÿ/','/Ŕ/','/ŕ/','/ñ/','/Ñ/','/[\?¿]/','/--/');
        $b = array('a',  'a',  'a',  'a',  'a',  'a',  'a',  'c',  'e',  'e',  'e',  'e',  'i',  'i',  'i',  'i',  'd',  'o',  'o',  'o',  'o',  'o',  'o',  'u',  'u',  'u',  'u',  'y',  'b',  's',  'a',  'a',  'a',  'a',  'a',  'a',  'a',  'c',  'e',  'e',  'e',  'e',  'i',  'i',  'i',  'i',  'd',  'o',  'o',  'o',  'o',  'o',  'o',  'u',  'u',  'u',  'u',  'y',  'y',  'b',  'y',  'r',  'r',  'n',  'N',  '-', '-');
        
        $data = preg_replace($a,$b,$param1);
       
        return $data;
    }
}
