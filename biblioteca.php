<?php
$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli->set_charset("utf8mb4");
if (!$mysqli) {
    echo "Error: No se pudo connectant a MySQL." . PHP_EOL;
} 

if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_error());
    exit();
}

$orderby = "ID_AUT ASC";
$autor = "";

if (isset($_POST['ID_AUT_ASC'])) {
    
    $orderby = "ID_AUT ASC";
}

if (isset($_POST['ID_AUT_DESC'])) {
    
    $orderby = "ID_AUT DESC";
}

if (isset($_POST['NOM_AUT_ASC'])) {
    
    $orderby = "NOM_AUT ASC";
}

if (isset($_POST['NOM_AUT_DESC'])) {
    
    $orderby = "NOM_AUT DESC";
}


if (isset($_POST['bcerca'])) {
    
    $autor = $_POST['cerca'];
    $query = "SELECT * FROM autors WHERE NOM_AUT LIKE '%" .$autor. "%' LIMIT 20";
} else {
    $query = "SELECT * FROM autors ORDER BY $orderby LIMIT 20";
}

//$resultado = mysql_query("SELECT * FROM autors");
//$resultat = "SELECT * FROM autors ORDER BY $orderby"
//PAGINACIÓ
$totalregistros = mysqli_num_rows($query);
$registrosporpagina = 10;

if(!isset($_GET["pagina"])){
	$pagina=1;
	$limit_inicio=($pagina*10)-10;
                                  
}else{
	$pagina=$_GET["pagina"];
	$limit_inicio=($pagina*10)-10;
}
$consultapagina= "SELECT * FROM autors ORDER BY ID_AUT LIMIT ".$limit_inicio.",".$registrosporpagina;


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
    <form action="" method="POST">
    
    <button  class="btn btn-primary" name="ID_AUT_ASC">ID ASC</button>
    <button  class="btn btn-primary" name="ID_AUT_DESC">ID DESC</button>

    <button  class="btn btn-primary" name="NOM_AUT_ASC">NOM ASC</button>
    <button  class="btn btn-primary" name="NOM_AUT_DESC">NOM DESC</button>
    <input type="text" name="cerca" placeholder="Cerca.." >
    <button  class="btn btn-primary" name="bcerca">CERCA</button>
    <table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID AUTOR</th>
        <th scope="col">NOM AUTOR</th>
    </tr>

<?php

if ($result = $mysqli->query($query)) {
    
    while ($row = $result->fetch_assoc()) {
        
        echo '
            <tr>
                <td>' . $row["ID_AUT"] . '</td>
                <td>' . $row["NOM_AUT"] . '</td>
            
            </tr>';
    }
    $result->free();
    
}
$mysqli->close();

?>

   </table>
    </form>
</body>
</html>