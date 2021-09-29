<?php
    require './vendor/autoload.php';
    $client = new EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/grafexamen");

    $interogare =  "PREFIX pumo: <http://pusteamoisi.com#>
                    PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
    
                    SELECT ?uri ?denumire
                    WHERE {
                        ?uri rdfs:subClassOf pumo:InstrumentMuzical; rdfs:label ?denumire
                    }";

    $categoriiInstrumente = $client->query($interogare);
    $listaProduse = "";
    foreach ($categoriiInstrumente as $categorie)
    {
        $denumire = $categorie->denumire;
        $uri = $categorie->uri;
        $listaProduse = $listaProduse . "<li class='list-group-item my-list-item' id='$uri' onclick='getListaProduse(this)'>" .$denumire . "</li><br/>";
    } 
    echo $listaProduse;
?>