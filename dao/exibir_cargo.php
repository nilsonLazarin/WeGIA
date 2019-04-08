<?php
	$nomeDB = 'wegia'; // nome da base de dados
	$local = 'localhost';//local servidor mysql
	$user = 'root';
	$senha = 'root';


	$conn = new mysqli($local, $user, $senha);
	$conn->query('use wegia');

	$sql = 'select * from cargo';
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo  $row["cargo"]. ",";
	    }
	} else {
	    echo "0 results";
	}
	$conn->close();

?>