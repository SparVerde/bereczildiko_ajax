<?php 
//database connect van a fejlécben
require_once './adatbazisConnect.php';
?>
<!DOCTYPE html>

<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Ajax feladat Helység keresés</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="favicon.png" />
        <link rel="stylesheet" href="AjaxForm.css" type="text/css" />
    </head>
    <body>
        <div class="container col-10">
            <h1>Helységek keresése irányítószám alapján</h1>
            <form>
                <div class="form-group row col-6">
                  <label for="irsz"><strong>Irányítószám:</strong></label>
                  <!--adatbázisból töltjük fel a select option lehetőségeit
                majd onchange html event (Javascript): input mező változtatása mit hajtson végre milyen függvényt (showHelysegek())-->
                  <select class="form-control" id="irsz" name="irsz" onchange="showHelysegek()">
                      <!--<option value="">1</option>-->
                    <?php 
                    //adatbázisból töltjük fel itt az irányítószámokat
                    $sql = "SELECT `IRSZ`, `Telepules`FROM `irsz`";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            //option value -ba kerülnek be az irányító számok
                            echo '<option value="'.$row["IRSZ"].'">'.$row["IRSZ"].'</option>';
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                  </select>
                </div>
            </form>
            <div id="telepulesek"><!--megjeleníti a településeket-->

            </div>
        </div>
        <script>
            function showHelysegek(){
                //kimásoljuk az id -t egy változóba x
                let x = document.getElementById("irsz").value;
                //létrehozunk egy objektumot
                const xhttp = new XMLHttpRequest();
                //meghatározzuk mit hajtson végre az objektum, ez egy anonim függvény function()
                xhttp.onload = function() {
                    //települések id-val rendelkező elembe (div) bekerül a válaszunk
                    document.getElementById("telepulesek").innerHTML = this.responseText;
                };
                //opennel a küldés paramétereit adjuk meg és milyen jellegű legyen a kommunikáció GET
                //GET, majd melyik url-t, azaz a getHelysegek.php-ból kérünk választ
                xhttp.open("GET", "getHelyseg.php?IRSZ=" + x); //!!!
            // a getHelyseg.php egy egyszerű adatlekérő script
                xhttp.send();

            }
        </script>