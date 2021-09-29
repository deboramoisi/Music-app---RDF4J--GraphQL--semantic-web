<?php

    // folosim file_get_contents in loc de POST pentru ca receptionam JSON format
    $datePrimite=file_get_contents("php://input");
    $date = json_decode($datePrimite);
    $denumire = $date->denumire;
    $uri = $date->uri;
    $pret = $date->pret;
    $disponibilitate = $date->disponibilitate;
    $disponibil = $date->disponibil;
    $bucatiPeStoc = $date->bucatiPeStoc;
    $categorie = $date->categorie;

    require './vendor/autoload.php';
    $adresaPOST = "http://localhost:8080/rdf4j-server/repositories/grafexamen/statements?update=";
    
    $interogareInsert = urlencode("PREFIX pumo: <http://pusteamoisi.com#>
                        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                        INSERT DATA {
                        pumo:".$uri." a pumo:".$categorie."; rdfs:label '".$denumire."';
                        pumo:pret ".$pret."; pumo:disponibilitatePeStoc [pumo:disponibil true; pumo:bucatiStoc ".$bucatiPeStoc."] .
                        }");

    $clientHttp = new EasyRdf\Http\Client($adresaPOST . $interogareInsert);
    echo $clientHttp->request("POST");
    
?>