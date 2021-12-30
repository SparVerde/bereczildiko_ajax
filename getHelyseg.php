<?php
require_once './adatbazisConnect.php';
//adatlekérő script amit az index.php ből indult
//szükség lesz válaszra $result
$result='';
//feltétel vizsgálat, nem lehet nulla
$irszam = filter_input(INPUT_GET, "IRSZ", FILTER_SANITIZE_NUMBER_INT);//
if($irszam != null) { 
    //paraméteres lekérdezés
    $sql = "SELECT `Telepules` FROM `irsz` WHERE `IRSZ` = ?";
    //elküldjük a servernek, ami értelmezi
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $irszam);
    //echo $irsz;
    //előállítjuk a futás eredményét execute()
    $stmt->execute();
    //feldolgozzuk a futás eredményét:
    $result = $stmt->get_result() or die("database error:". mysqli_error($conn));
   // echo $result;
    if($result != null && $result->num_rows > 0){
        //elkészítjük a kiíratást:
        $data = "<h1>Település</h1>";
        
        while($row = $result->fetch_assoc() ) {
            $data .= '<h3>'.$row["Telepules"].'</h3>';
        }
        //Ajax által meghívott script-ként csak egyszer tudunk kiírni!!! if áganként, csak egy kiíratás van!
       echo $data;//
    }else {
        echo 'Nincs találat!';
    }
} else {
    echo " Nulla";
}