<?php
require_once '../classes/Soap.php';

$soap = new Soap();

if (!empty($_POST['country'])) {$country = $_POST['country'];} else {$country = NULL;}
if (!empty($_POST['city'])) {$city = $_POST['city'];} else {$city = NULL;}

$xmlWeather = $soap->get_data($country, $city);

echo '<tr>
        <th>Location</th>
        <td>'.$xmlWeather->Location.'</td>
    </tr>
    <tr>
        <th>Time</th>
        <td>'.$xmlWeather->Time.'</td>
    </tr>
    <tr>
        <th>Wind</th>
        <td>'.$xmlWeather->Wind.'</td>
    </tr>
    <tr>
        <th>Visibility</th>
        <td>'.$xmlWeather->Visibility.'</td>
    </tr>
    <tr>
        <th>Sky Conditions</th>
        <td>'.$xmlWeather->SkyConditions.'</td>
    </tr>
    <tr>
        <th>Temperature</th>
        <td>'.$xmlWeather->Temperature.'</td>
    </tr>
    <tr>
        <th>Dew Point</th>
        <td>'.$xmlWeather->DewPoint.'</td>
    </tr>
    <tr>
        <th>Relative Humidity</th>
        <td>'.$xmlWeather->RelativeHumidity.'</td>
    </tr>
    <tr>
        <th>Pressure</th>
        <td>'.$xmlWeather->Pressure.'</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>'.$xmlWeather->Status.'</td>
    </tr>';
