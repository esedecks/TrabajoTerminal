<?php 

class ConverterPLY{
	public $normal = array(); 
	public $textCoord = array(); 
	public $vertices = array(); 
	public $faces = array(); 
	public $indices = array(); 
	public $buffer ="";
 	

	public  function convert($filename){
		$buffer = ""; 
		$data_init = 15;
		$file = $filename;
		$local_file = fopen($file, "r") or die("Unable to open file!");
		
		// Output one line until end-of-file
		while(!feof($local_file)) {
		  $buffer = $buffer . fgets($local_file) . "";
		}
		fclose($local_file);
		//echo $buffer;
		$arr = explode("\n", $buffer);

		$numVerticesLine = $arr[2];  
		$numFacesLine = $arr[12]; 
		$vertices_count = explode(" ", $numVerticesLine)[2];
		$faces_count = explode(" ", $numFacesLine)[2];
				
		$this->getVerticesAndNormals($arr, $vertices_count, $data_init);
		$this->printArray($this->vertices);
		echo "<br>";
		echo "<br>";
		$this->printArray($this->normal);
		$this->getFaces($arr, $vertices_count, $faces_count, $data_init);
		echo "<br>";
		echo "<br>";
		$this->printArray($this->faces);	
	}
	
	/*Se len las caras que se encuentran an final del archivo*/
	public function getFaces($data, $vertices_count, $faces_count, $data_init)
	{
		$arr = array();
		for( $i=$vertices_count+$data_init, $k=0; $i<$vertices_count+$data_init+$faces_count; $i++, $k++)
		{	
			$arr[$k] = array();
			$arr[$k][0] = explode(" ", $data[$i])[1] . ',';
			$arr[$k][1] = explode(" ", $data[$i])[2] . ',';
			$arr[$k][2] = explode(" ", $data[$i])[3] . ',';
		}
		$this->faces = $arr;
		
	}
	
	/*Se recorre una vez el aarchivo y se leen ambos datos*/
	public function getVerticesAndNormals($data, $vertices_count, $data_init)
	{
		$arr  = array(); //array de vertices
		$arr1 = array();  //array de normales
		$k=0; $j=0; $i=0;		
		for($i=$data_init; $i<$vertices_count+$data_init; $i++)
		{
			// Se obtiene dentro de un arreglo los 3 numeros correspondientes a un vertice			
			$arr[$i-$data_init] = array(); 
			$arr[$i-$data_init][0] = explode(" ", $data[$i])[0] . 'f,';
			$arr[$i-$data_init][1] = explode(" ", $data[$i])[1] . 'f,';
			$arr[$i-$data_init][2] = explode(" ", $data[$i])[2] . 'f,';

			// se obtiene dentro un arreglo los 3 numeros correpondientes a la normal
			if($k==3) $k=0;			
			if($k==0)
			{			
				$arr1[$j] = array(); 
				$arr1[$j][0] = explode(" ", $data[$i])[3] . 'f,';
				$arr1[$j][1] = explode(" ", $data[$i])[4] . 'f,';
				$arr1[$j][2] = explode(" ", $data[$i])[5] . 'f,';
				$j++;
			}
			$k++;
			
		}	
		$this->vertices = $arr;
		$this->normal   = $arr1;
	}

	public function printArray($array)
	{
		foreach ($array as $_array) {
			foreach ($_array as $value) {
				echo $value;
				echo " ";
			}
			echo "<br>";
		}
	}

}

?>