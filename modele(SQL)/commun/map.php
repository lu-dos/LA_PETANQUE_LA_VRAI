<?php

function fliste_centres($conn){ //F
    //cette fonction va lire la liste des centres de la table centres de la base de donnee  puis les remplire dans un formormat de liste pour javascript
    $i=0;
    $liste="{";
    $result = $conn->query("SELECT * FROM terrain");

    if ($result->num_rows > 0) { //I
        while ($row = $result->fetch_assoc()) { //w
            $i++;
            $liste=$liste.'"'.$row["ville"].'": {"lat":'.$row["latitude"].', "lon": '.$row["longitude"].', "id": '.$row["Id_Terrain"].'}';
            if($i< $result->num_rows) $liste=$liste.",";
        }//W
    }//I
$liste=$liste."}";
return $liste;
}//F
?>