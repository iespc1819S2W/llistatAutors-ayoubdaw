<?php
$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli->set_charset("utf8mb4");
if (!$mysqli) {
    echo "Error: No se pudo connectant a MySQL." . PHP_EOL;
} 

$orderby = "ID_AUT ASC";

if(isset($_POST['orderby'])){
    $orderby = $_POST['orderby'];
}

$cerca = "";
if(isset($_POST['cerca'])){
    $cerca = $_POST['cerca'];
}

$limitPag = 20;
$pagina = 0;

if(isset($_POST['pagina'])){
    $pagina = $_POST['pagina'];
}

$result = $mysqli->query("SELECT * FROM autors WHERE NOM_AUT LIKE '%" .$cerca. "%' OR ID_AUT LIKE '% . $cerca .  %'");
$numRegistres = mysqli_num_rows($result);
$numPag = ceil($numRegistres / $limitPag);

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


if(isset($_POST['primer'])){
    
    $pagina = 0;
}


if(isset($_POST['seguent'])){
    
    if ($pagina <= $numPag){

        $pagina = $pagina +1;
    }
}

if(isset($_POST['anterior'])){
    
    if ($pagina > 0 ){

        $pagina = $pagina -1;
    } 
}

if(isset($_POST['darrer'])){
    
    $pagina = $numPag -1;
}


$tuplainici = $pagina * $limitPag;
$query = "SELECT * FROM autors WHERE NOM_AUT LIKE '%$cerca%' OR ID_AUT LIKE '%$cerca%' ORDER BY $orderby LIMIT $tuplainici , $limitPag ";
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
    <input type="text" name="cerca" id="cerca"  value="<?=$cerca?>">
    <button  class="btn btn-primary" name="bcerca">CERCA</button>
    <button  class="btn btn-primary" name="primer"><<<</button>
    <button  class="btn btn-primary" name="anterior"><</button>
    <button  class="btn btn-primary" name="seguent">></button>
    <button  class="btn btn-primary" name="darrer">>>></button>
    <input type="hidden"  value="<?=$pagina?>" name="pagina" id="pagina">
    <input type="hidden"  value="<?=$orderby?>" name="orderby" id="orderby">
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