<?php 
    require './vendor/autoload.php';
    $client = new EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/grafexamen/statements");

    $instrumentDeSters = $_GET["q"];

    $interogareStergere = "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                            PREFIX pumo: <http://pusteamoisi.com#>
                            
                            DELETE {
                            ?x pumo:pret ?pret.
                            ?x a ?subTip.
                            ?x rdfs:label '$instrumentDeSters'.
                            ?x pumo:disponibilitatePeStoc ?nodAnonim.
                            }
                            WHERE
                            {
                            ?x pumo:pret ?pret.
                            ?x a ?subTip.
                            ?x rdfs:label '$instrumentDeSters'.
                            ?x pumo:disponibilitatePeStoc ?nodAnonim.
                            }"; 

    echo $client->update($interogareStergere);
?>