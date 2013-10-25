<?php
// Conectara postgres DB
$host="ec2-54-235-192-45.compute-1.amazonaws.com";
$user="sjdggbutasilxo";
$password = "YjfawRA_ONBo2c7zyiinveV6jy";
$database="dbqlogo2l6v4fe";
$conId="";
try {
$conn = new PDO('pgsql:host='.$host.';dbname='.$database, $user, $password);
}
catch(PDOException $e) {
  echo $e->getMessage();
}

$xmlDoc = new DOMDocument('1.0');
$xmlDoc->formatOutput = true;
//Elemento raiz
$root = $xmlDoc->createElement('Request');
$root = $xmlDoc->appendChild($root);

//Elemento cliente
$customer = $xmlDoc->createElement('Customer');
$customer = $root->appendChild($customer);

//Elemento producto
$product = $xmlDoc->createElement('Product');
$product = $root->appendChild($product);

//Elemento comentario
$comments = $xmlDoc->createElement('Comments');
$comments = $root->appendChild($comments);

//Iterar y agregar los campos
foreach ($_POST as $campos => $value) {
	$tipo = substr($campos, 0, 2);
	$campo = substr($campos, 3);
	switch($tipo){
		//Campo de cliente
		case "cl":
			$campo = $xmlDoc->createElement($campo);
			$campo = $customer->appendChild($campo);
			$valor = $xmlDoc->createTextNode($value);
			$valor = $campo->appendChild($valor);
			break;
		//Campo de producto
		case "pd":
			$campo = $xmlDoc->createElement($campo);
			$campo = $product->appendChild($campo);
			$valor = $xmlDoc->createTextNode($value);
			$valor = $campo->appendChild($valor);
			break;
		//Campo de comentario
		case "cm":
			$campo = $xmlDoc->createElement($campo);
			$campo = $comments->appendChild($campo);
			$valor = $xmlDoc->createTextNode($value);
			$valor = $campo->appendChild($valor);
			$comment = $value;
			break;
	}
}
//$xmlDoc->save('data.xml');
//$xml = $xmlDoc->saveXML();
  $xml =  $xmlDoc->saveXML();
$stmt = $conn->prepare("INSERT INTO contents (xml,comment) VALUES (:xml,:comment)");
$stmt->execute(array(':xml'=>$xml,':comment'=>$comment));
?>
