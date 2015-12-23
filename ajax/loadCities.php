<?php
require_once '../classes/Soap.php';

$soap = new Soap();

if (!empty($_POST['country'])) {$country = $_POST['country'];} else {$country = NULL;}

if (!empty($country)) {
    $xmlCities = $soap->get_cities($country);
    foreach ($xmlCities as $cities) {
        $fullCity = explode(' /', $cities->City);
        $nCity = $fullCity[0];

        echo '<option value="'.$nCity.'">'.$nCity.'</option>';
    }
} else {echo '<option>No se encontró registro para '.$country.'.</option>';}

