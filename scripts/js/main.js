jQuery(document).ready(function () {
    jQuery('#countries').change(function () {
        jQuery('#cities').attr("disabled", true);
        jQuery('#cities').html('');
        jQuery('#weather').html('<tr><td>Loading ...</td></tr>');
        
        var country = jQuery('#countries').val();
        jQuery.post("./ajax/loadCities.php", {country: country}, function (listCity) {
            jQuery('#cities').attr("disabled", false);
            jQuery('.jumbotron h1 span.small').html(country);
            jQuery('#cities').html(listCity);
            
            var city = jQuery('#cities').val();
            jQuery.post("./ajax/loadData.php", {country: country, city: city}, function (data) {
                jQuery('.jumbotron h1 span.small').html(country+' / '+city);
                jQuery('#weather').html(data);
            });
        });
    });
    
    jQuery('#cities').change(function () {
        var country = jQuery('#countries').val();
        var city = jQuery('#cities').val();
        jQuery('#weather').html('<tr><td>Loading ...</td></tr>');
        
        jQuery.post("./ajax/loadData.php", {country: country, city: city}, function (data) {
            jQuery('.jumbotron h1 span.small').html(country+' / '+city);
            jQuery('#weather').html(data);
        });
    });
});


