<?php
$areglo = array();
$body="";
$jugadores=[];
$jugador1=0;
$jugador2=0;
$cantJ1=0;
$cantJ2=0;
$ganador="###";

if($_SERVER['REQUEST_METHOD']=='GET'){

  $archivo=fopen("archivo.txt","w");
  fclose($archivo);


}else{



  if($fp = fopen($_FILES['fileTXT']['name'], "r")){
    while(!feof($fp)) {
      $linea = fgets($fp);
      if (!empty($linea)) {
        array_push($areglo,$linea);
      }
      //echo $linea . "<br />";
    }
    for ($i=1; $i < sizeof($areglo) ; $i++) {
      $resultado = explode(" ", $areglo[$i]);
      $jugador1  =(int)$resultado[0];
      $jugador2  =(int)$resultado[1];
      if ($jugador1 > $jugador2) {
        # code...
        $jugadores['jugador1'][]= abs($jugador1 -$jugador2);
      }else {
        # code...
        $jugadores['jugador2'][]= abs($jugador1 -$jugador2);
      }



      $lider = $jugador1 >$jugador2?'jugador1':'jugador2';
      $ventaja = abs($jugador1 -$jugador2);
      $body .= "<tr><td align='center'>$i</td> <td align='center'>$jugador1</td> <td align='center'>$jugador2</td><td align='center'>$lider</td><td align='center'>$ventaja</td><tr>";
    }
    $cantJ1 = array_sum($jugadores['jugador1']);
    $cantJ2 = array_sum($jugadores['jugador2']);
    $ganador= $cantJ1 > $cantJ2?"Jugador 1":"Jugador 2";

    $archivo=fopen("archivo.txt","w");
    fclose($archivo);

    $file = fopen("archivo.txt", "a+");
    $salida = $ganador ." ".($cantJ1 > $cantJ2? $cantJ1 : $cantJ2);
    fputs($file,$salida);
    fclose($file);

    fclose($fp);

  }else{
    echo "<script> alert('No se encontro el archivo'); </script>";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Competencia</title>
  <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Poiret+One" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
  <div class="container" align="center">


    <div class="container">
      <br><br><br>
      <div class="col-sm-12">
        <form class="" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" accept-charset="iso-8859-1">
          <label for="" class="etiqueta">Selecionar Archivo</label>
          <input type="file" name="fileTXT" id="fileTXT" style="display: inline;" accept="text/plain" required>
          <button type="submit" name="btn btn-primary">iniciar</button>
        </form>

      </div>

      <div class="col-sm-4">
        <h1 style="font-family: 'Kaushan Script', cursive;">Ganador</h1>
        <h3><?php echo $ganador;?></h3>
      </div>
      <div class="col-sm-4">
        <h1 style="font-family: 'Kaushan Script', cursive;">ventaja total</h1>
        <h3><?php echo $cantJ1 > $cantJ2? $cantJ1 : $cantJ2;?></h3>

      </div>
      <div class="col-sm-4 descargar">
        <h1 style="font-family: 'Kaushan Script', cursive;">Descargar resultado</h1>
        <a href="./archivo.txt" style="color:orange;" download> Resultado</a>
      </div>
    </div>
    <br><br><br><br>
    <div class="col-sm-12">

      <table class="table">
        <thead>

          <tr>
            <td align="center">Ronda</td>
            <td align="center">Jugador 1</td>
            <td align="center">Jugador 2</td>
            <td align=center>Lider</td>
            <td align="center">Ventaja</td>
          </tr>
        </thead>
        <tbody>
          <?php echo $body; ?>
        </tbody>
      </table>

    </div>

  </div>


</body>
<style media="screen">
body {
  background-color: #304FFE;
  overflow-x: hidden;
  font-family: 'Poiret One', cursive;
}
table{
  color:rgb(255,255,255);
}

table tr td{
  align-items: center;
}
td {
  align-items: center;
}
h3{
  color:rgb(255,255,255);
}
.etiqueta {
  background-color: orange;

}
input {
  padding-right: 0;
  background-color: #1CC0FE ;
}


</style>
</html>
