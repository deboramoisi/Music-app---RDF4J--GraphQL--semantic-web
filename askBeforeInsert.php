<?php

    $uri = $_GET["q"];

    require './vendor/autoload.php';
    $client = new EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/grafexamen");

    $interogare = "PREFIX pumo: <http://pusteamoisi.com#>
    
                    ASK WHERE {
                        pumo:".$uri." ?p ?o .
                    }";

    $uriExista = $client->query($interogare);

    echo $uriExista;
?>