<?php
$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli -> set_charset("utf8mb4");
if (!$mysqli) {
    echo "Error: No se pudo connectant a MySQL." . PHP_EOL;
   } else {
    echo "S'ha connectat." . PHP_EOL; 
}
if (mysqli_connect_errno()) { printf("Error: %s\n", mysqli_connect_error()); exit(); }

$orderby = "NOM_AUT ASC";
if(isset($_POST['ID_AUT_DESC'])){

    $orderby = "NOM_AUT DESC";
}

if(isset($_POST['ID_AUT_ASC'])){
    
    $orderby = "NOM_AUT ASC";
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Llistat Autors</title>
</head>
<body>
    <h1 align="center" >LLISTAT</h1>
    <form action="" method="post">
    
    <button type="button" class="btn btn-primary" name="ID_AUT_ASC">Autor ASC</button>
    <button type="button" class="btn btn-primary" name="ID_AUT_DESC">Autor DESC</button>
    </form>
    <table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID AUTOR</th>
        <th scope="col">NOM AUTOR</th>
    </tr>

<?php
    $query = "SELECT ID_AUT , NOM_AUT FROM autors ORDER by $orderby";
   
    if ($result = $mysqli->query($query)) {

        while ($row = $result->fetch_assoc()) {
    
        echo'
            <tr>
                <td>'.$row["ID_AUT"].'</td>
                <td>'.$row["NOM_AUT"].'</td>
            
            </tr>';
        }
    $result->free();

   }
   $mysqli->close();
   
?>
    </table>
</body>
</html>



