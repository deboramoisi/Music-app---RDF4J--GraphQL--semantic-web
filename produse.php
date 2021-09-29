<?php

    require './vendor/autoload.php';
    $client = new EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/grafexamen");

    $categorieSelectata = $_GET["q"];

    $produseCategorie = "PREFIX pumo: <http://pusteamoisi.com#>
                        PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                            
                        SELECT DISTINCT ?denumire ?uri ?pret ?bucatiStoc ?disponibil ?imageUrl
                        WHERE { 
                            ?uri a pumo:".$categorieSelectata."; rdfs:label ?denumire.
                            ?uri pumo:pret ?pret; pumo:disponibilitatePeStoc/pumo:bucatiStoc ?bucatiStoc.
                            OPTIONAL{ ?uri pumo:hasImage/rdfs:label ?imageUrl }. 
                            ?bucatiStoc ^pumo:bucatiStoc/pumo:disponibil ?disponibil
                        }";
    
    $produse = $client->query($produseCategorie);
    foreach ($produse as $produs)
    {
        $denumire = $produs->denumire;
        $pret = $produs->pret;
        $disponibilitate = $produs->disponibil;
        $bucatiPeStoc = $produs->bucatiStoc;
        $uri = $produs->uri;
        $imageUrl = (empty($produs->imageUrl)) ? "#" : $produs->imageUrl;

        echo '<div class="row list-group-item">
                        <div class="col-md-6">
                            <h5 class="heading-5">' .$denumire. '</h5>
                            <button onclick="stergereInstrument(this)" id="'.$denumire.'" class="btn btn-danger">Stergere</button>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">
                                    <img class="instrument-image" src="proiect/'.$imageUrl.'" alt="no image">
                                </div>
                                <div class="col-md-7">
                                    <p><strong> Pret: </strong> ' . $pret . ' </p>
                                    <p><strong> Disponibilitate: </strong> ' . $disponibilitate . ' </p>
                                    <p><strong> Bucati pe stoc: </strong>' . $bucatiPeStoc . ' </p>
                                </div>
                            </div>
                        </div>
                    </div>';
        } 
?>