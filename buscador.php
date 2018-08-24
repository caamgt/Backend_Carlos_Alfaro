<?php 

	$fileName = 'data-1.json';
	$file = fopen($fileName, "r");
	$data = fread($file, filesize($fileName));
	$dataArray = json_decode($data);
	$newData = array();


	// Condicionamos, para hacer la busqueda especifica.
	if (isset($_POST['ciudad']) && isset($_POST['tipo']) && isset($_POST['from']) && isset($_POST['to'])) {
		
		// Declaramos las variables para poder capturarlas con el POST.
		$ciudad = $_POST['ciudad'];
		$tipo = $_POST['tipo'];
		$from = $_POST['from'];
		$to = $_POST['to'];

		// Recorremos y contamos los registros.
		for ($i=0; $i < count($dataArray); $i++) { 
			$newPrecio = str_replace('$', '', str_replace(',', '', str_replace(' ', '', $dataArray[$i]->Precio)));
			// Evaluamos si los tres campos: Ciudad, tipo y precio son indicados.
			if ($newPrecio >= $from && $newPrecio <= $to && $dataArray[$i]->Ciudad == $ciudad && $dataArray[$i]->Tipo == $tipo) {
				array_push($newData, $dataArray[$i]);
				// Evaluamos si solo se indico precio y ciudad.
			}else if($newPrecio >= $from && $newPrecio <= $to && $dataArray[$i]->Ciudad == $ciudad && $tipo == "") {
				array_push($newData, $dataArray[$i]);
				// Evaluamos si solo se indico el precio y tipo.
			}else if($newPrecio >= $from && $newPrecio <= $to && $ciudad == "" && $dataArray[$i]->Tipo == $tipo) {
				array_push($newData, $dataArray[$i]);
			}else if($newPrecio >= $from && $newPrecio <= $to && $ciudad == "" && $tipo == "") {
				array_push($newData, $dataArray[$i]);
			}
		}
		echo json_encode($newData);

	} else if (isset($_POST['todos'])) {
		echo $data;
	}

	fclose($file);
?>