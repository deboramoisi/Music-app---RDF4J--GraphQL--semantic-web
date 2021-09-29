var categorieSelectata = "";

// Functie care solicita totalitatea categoriilor de instrumente muzicale

function getCategoriiProduse() {
            
    $.ajax({
        method: "GET",
        url: "categoriiProduse.php",
        success: function(data) {
            $(".categorii-produse").html(data);
        },
        error: function() {
            alert("Error")
        }
    });
}

$(document).ready(function() {
     getProduse();
     insertDataToServer();

})

function insertDataToServer() {
    $("#insert-button").on("mouseover", function() {
        
        var denumire = $("#denumire");
        var pret = $("#pret");
        var disponibilitate = $("#disponibilitate").val();
        var bucatiPeStoc = $("#bucatiPeStoc");
        var disponibil = ($("#disponibil").prop("checked") == true);

        if (categorieSelectata == "") {
            alert("Va rugam selectati o categorie de instrumente inaintea inserarii!")
            return false;
        } 

        if (notNullOrEmpty(denumire)) {
            denumire = denumire.val();
        } else {
            alert("Va rugam completati campul denumire!");
            return false;
        }

        if (notNullOrEmpty(pret)) {
            pret = pret.val();
        } else {
            alert("Va rugam completati campul pret!");
            return false;
        }

        if (notNullOrEmpty(bucatiPeStoc)) {
            bucatiPeStoc = bucatiPeStoc.val();
        } else {
            alert("Va rugam completati campul bucati pe stoc!");
            return false;
        }

        var uri = denumire.replace(" ", "");

        var dateInsert = {
            "denumire": denumire,
            "uri": uri,
            "pret": pret,
            "bucatiPeStoc": bucatiPeStoc,
            "disponibil": disponibil,
            "disponibilitate": disponibilitate,
            "categorie": categorieSelectata
        };

        // verificam daca denumirea acordata corespunde unui uri din baza de cunostinte
        $.ajax({
            method: "GET",
            url: "askBeforeInsert.php?q=" + uri,
            success: function(data) {
                if (data == 'false') {
                    // daca nu corespunde atunci inseram instrumentul muzical
                    $.ajax({
                        method: "POST",
                        url: "insertProduse.php",
                        contentType: "application/json",
                        data: JSON.stringify(dateInsert),
                        success: function() {
                            getProduse(categorieSelectata);
                        }, error: function() {
                            alert("Error");
                        }
                    });
                } else {
                    // altfel alertam utilizatorul sa introduca alta denumire
                    alert("Va rugam introduceti o denumire noua. Acest instrument muzical exista deja!");
                }
            },
            error: function() {
                alert("A aparut o eroare!");
            }
        })
     
    })
}

function stergereInstrument(instrument) {
    console.log(instrument.id);

    $.ajax({
        method: "GET",
        url: "stergereProdus.php?q=" + instrument.id,
        success: function() {
            getProduse(categorieSelectata);
        },
        error: function() {
            alert("Error");
        }
    })
}

function notNullOrEmpty(element) {
    if (element.val().length != 0) {
        return true;
    } else {
        return false;
    }
}

// aduce produse din categoria selectata
function getProduse(categorie) {

    $.ajax({
        method: "GET",
        url: "produse.php?q=" + categorie,
        success: function(data) {
            $("#instrumente").html(data);
        }
    })

}

function getListaProduse(element) {
    var categorie = element.id;
    categorieSelectata = categorie.split("#")[1]; 

    getProduse(categorieSelectata);
}