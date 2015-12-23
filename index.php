<?php
require_once './classes/Soap.php';
$soap = new Soap();

$geoIp = $soap->get_location();

$act_country = $geoIp->Country;
$act_city = $soap->normalizar($geoIp->City);

if (empty($act_country)) {$country = 'Colombia';}
else {$country = $act_country;}

if (empty($act_city)) {$city = 'Bogota';}
else {$city = $act_city;}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Test BSPKN</title>
        <link href="scripts/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="scripts/css/main.css" rel="stylesheet" />
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <!-- Static navbar -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">SOAP services</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="./">Home</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>

            <!-- Main component for a primary marketing message or call to action -->
            <div class="jumbotron">
                <h1>Global Weather <span class="small"><?php echo $country.' / '.$city; ?></span></h1>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="usr">Countries:</label>
                        <select id="countries" name="countries" class="form-control">
                            <?php
                            $xmlCountries = $soap->get_countries();
                            foreach ($xmlCountries as $countries) {
                                if ($country == $countries->Name) {$sCountry = 'selected';}
                                else {$sCountry = '';}
                                echo '<option value="'.$countries->Name.'" '.$sCountry.'>'.$countries->Name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usr">Cities:</label>
                        <select id="cities" name="cities" class="form-control">
                            <?php
                            $xmlCities = $soap->get_cities($country);
                            foreach ($xmlCities as $cities) {
                                $fullCity = explode(' /', $cities->City);
                                $nCity = $fullCity[0];
                                
                                if ($nCity == $city) {$sCity = 'selected';}
                                else {$sCity = '';}
                                echo '<option value="'.$nCity.'" '.$sCity.'>'.$nCity.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group table-responsive">
                        <label for="usr">Data:</label>
                        <table id="weather" class="table table-striped table-hover">
                            <?php $xmlWeather = $soap->get_data($country, $city); ?>
                            <tr>
                                <th>Location</th>
                                <td><?php echo $xmlWeather->Location; ?></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td><?php echo $xmlWeather->Time; ?></td>
                            </tr>
                            <tr>
                                <th>Wind</th>
                                <td><?php echo $xmlWeather->Wind; ?></td>
                            </tr>
                            <tr>
                                <th>Visibility</th>
                                <td><?php echo $xmlWeather->Visibility; ?></td>
                            </tr>
                            <tr>
                                <th>Sky Conditions</th>
                                <td><?php echo $xmlWeather->SkyConditions; ?></td>
                            </tr>
                            <tr>
                                <th>Temperature</th>
                                <td><?php echo $xmlWeather->Temperature; ?></td>
                            </tr>
                            <tr>
                                <th>Dew Point</th>
                                <td><?php echo $xmlWeather->DewPoint; ?></td>
                            </tr>
                            <tr>
                                <th>Relative Humidity</th>
                                <td><?php echo $xmlWeather->RelativeHumidity; ?></td>
                            </tr>
                            <tr>
                                <th>Pressure</th>
                                <td><?php echo $xmlWeather->Pressure; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo $xmlWeather->Status; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="text-muted">Desarrollado por Igor E.</p>
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/bootstrap/js/bootstrap.min.js"></script>
        <script src="scripts/js/main.js"></script>
    </body>
</html>