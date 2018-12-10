<?php
$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli->set_charset("utf8mb4");
if (!$mysqli) {
    echo "Error: No se pudo connectant a MySQL." . PHP_EOL;
}
$orderby = "ID_AUT ASC";
if (isset($_POST['orderby'])) {
    $orderby = $_POST['orderby'];
}
$cerca = "";
if (isset($_POST['cerca'])) {
    $cerca = $_POST['cerca'];
}
$limitPag = 20;
$pagina = 0;
if (isset($_POST['pagina'])) {
    $pagina = $_POST['pagina'];
}
$result = $mysqli->query("SELECT * FROM autors WHERE NOM_AUT LIKE '%" . $cerca . "%' OR ID_AUT LIKE '% . $cerca .  %'");
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
if (isset($_POST['primer'])) {
    $pagina = 0;
}
if (isset($_POST['seguent'])) {
    if ($pagina <= $numPag) {
        $pagina = $pagina + 1;
    }
}
if (isset($_POST['anterior'])) {
    if ($pagina > 0) {
        $pagina = $pagina - 1;
    }
}
if (isset($_POST['darrer'])) {
    $pagina = $numPag - 1;
}
if (isset($_POST['borrar'])) {
    $idBorrar = $_POST['borrar'];
    $result = $mysqli->query("DELETE FROM autors WHERE ID_AUT LIKE $idBorrar");
}
$idEditar = 0;
if (isset($_POST['editar'])) {
    $idEditar = $_POST['editar'];
    
}

$valor = "";
if (isset($_POST['envia'])) {
    $valor = $_POST['nomInp'];
    $idEnvia = $_POST['envia'];
    $result = $mysqli->query("UPDATE autors SET NOM_AUT = '$valor' WHERE ID_AUT = $idEnvia");
    $cerca = $valor;
}

$autor = "";
if(isset($_POST['confirmar'])){

    $idInserta = $_POST['insertaid'];
    $autor = $_POST['insertainp'];
    $result = $mysqli->query("INSERT INTO autors(ID_AUT,NOM_AUT) VALUES ($idInserta,'$autor')");
    $cerca = $autor;
}

$tuplainici = $pagina * $limitPag;
$query = "SELECT * FROM autors WHERE NOM_AUT LIKE '%$cerca%' OR ID_AUT LIKE '%$cerca%' ORDER BY $orderby LIMIT $tuplainici , $limitPag ";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" 
integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<title>Llistat Autors</title>

</head>
<body>
    <h1 align="center" >LLISTAT</h1>
    <div class="container">
    <form action="" method="POST">
    <center>
    <button  class="btn btn-dark" name="ID_AUT_ASC">ID ASC</button>
    <button  class="btn btn-dark" name="ID_AUT_DESC">ID DESC</button>
    <button  class="btn btn-dark" name="NOM_AUT_ASC">NOM ASC</button>
    <button  class="btn btn-dark" name="NOM_AUT_DESC">NOM DESC</button>
    <button  class="btn btn-info" name="inserta">INSERTA</button>
    <input type="text" name="cerca" id="cerca"  value="<?=$cerca
?>">
    <button  class="btn btn-dark" name="bcerca">CERCA</button>
    <button  class="btn btn-dark" name="primer"><<<</button>
    <button  class="btn btn-dark" name="anterior"><</button>
    <button  class="btn btn-dark" name="seguent">></button>
    <button  class="btn btn-dark" name="darrer">>>></button>
    </center>
    <br>
    <?php 
    
    if (isset($_POST['inserta'])) { ?>
        Inserta el ID <input type="text" name="insertaid">
        Inserta el nom del autor: <input type="text" name="insertainp">
        <button class="btn btn-info" name="confirmar">CONFIRMA</button>
        
   <?php } ?>
    <br><br>
    
    <input type="hidden"  value="<?=$pagina?>" name="pagina" id="pagina">
    <input type="hidden"  value="<?=$orderby?>" name="orderby" id="orderby">
    <table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID AUTOR</th>
        <th scope="col">NOM AUTOR</th>
        <th scope="col"></th>
    </tr>

<?php if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) { ?>

        <tr> 
            <td id="idAut"><?php echo $row["ID_AUT"] ?></td>
            <td id="nomAut">
                
            <?php if ($idEditar == $row["ID_AUT"]) { ?>
        
                        <input type="text" name="nomInp" value="<?=$row["NOM_AUT"] ?>"> 
                        <button  class="btn btn-danger" style="float: right" name="cancelar">CANCELAR</button>
                        <button  class="btn btn-success" style="float: right" name="envia" value="<?=$row["ID_AUT"] ?>">CONFIRMA</button>
                      
                   <?php $idEditar = 0;
        } else {
            echo $row["NOM_AUT"]; ?>
                    <button  class="btn btn-danger" style="float: right" name="borrar" value="<?=$row["ID_AUT"] ?>">
                    <i class="fas fa-trash"></i>
                    </button>
    
                    <button  class="btn btn-dark" style="float: right" name="editar" value="<?=$row["ID_AUT"] ?>">
                    <i class="fas fa-edit"></i>
                    </button>
                    <?php
        } ?>
            </td>

        </tr>
<?php
    }
    $result->free();
}
$mysqli->close();
?>

   </table>
    </form>
    </div>
</body>
</html>