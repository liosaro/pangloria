<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Documento sin título</title> 
<?php  

 

//verificamos que se marcara al menos 1 checkbox 
echo '<pre>';
if (isset($_POST['very'])) { 
     foreach($_POST['very'] as $idMatPrima) { 
          echo '<p>ID de materia prima: '.$idMatPrima.'</p>';
     } 
}?> 
</head> 
 
<body> 
</body> 
</html>