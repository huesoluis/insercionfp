<?php 
class ACCESO {
	public $c; 
	private $csv_dir='';
	public function __construct($dir)
	{
		$this->csv_dir=$dir;
	    	$this->c = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)
        	or die ("Imposible conectar con el servidor mysql");
    
		$this->c->set_charset("utf8");
		mysqli_select_db($this->c,DB_DB);
	}
	public function gen_brutos($sql,$fcentro='',$dcentro='')
	{
	if ($dcentro!='' and !is_dir($dcentro)) 
		{
		mkdir($dcentro);
		echo "Directorio creado";
		}
	$res = mysqli_query($this->c,$sql);
	if (!$res) 
		{
 		   die('Algo fallo: ' . mysqli_error($this->c));
		}	
	rename('/home/fpleaks/tmp/brutos.csv',$fcentro);
	return 1;
	}
	public function gen_csv($sql,$param,$fichero,$ncentro='')
	{
 		$dir=$this->csv_dir;
		$fp = fopen('tmp.csv', 'w');
		$csv='';
		$csvnames='';
		if($param!='') $sql=str_replace('pcentro',$param,$sql);
		$res = mysqli_query($this->c,$sql);
		print($sql);
	        if($res)
		{
		        if(strpos($sql,'SELECT') === false)
			{
			print("hay res pero no select");
		  	return true;
      			}
    		}
	      	else
		{
		      	print("NO RES".count($res).mysqli_error($this->c));
			return null;
	      	}
		$results = array();
		if($fichero=='trabaja_desempleo' or $fichero=='trabaja_por_familias' or $fichero=='trabaja_por_centros') $csvnames=array('trabdes','%desempleo','%trabaja');
		elseif($fichero=='trabaja_relacionado' or $fichero=='trabaja_relacionado_por_familias' or $fichero=='trabaja_relacionado_por_centros') $csvnames=array('trabdes','%trabajo relacionado');
		fputcsv($fp, $csvnames);
		if(mysqli_num_rows($res)==0) 
		{
			print("NO hay resultados");
			return;
		}
		else
		{
			while ($row = mysqli_fetch_assoc($res))
			{
			$vacia=0;
			foreach($row as $k=>$v) 
				{
				if($v!=''){$vacia=1; break;}
				}
			#if($row[0]['FAMILIA']=='') continue;
			if($vacia==1) fputcsv($fp, $row);
    			}
		}
		fclose($fp);
		$str=file_get_contents('tmp.csv');
		$str=str_replace('"', "",$str);
		$fcompleto=$dir."/".$ncentro.'/'.$fichero.".csv";
		file_put_contents($fcompleto, $str);
    return;        
  } 
 
  public function insertdata($fichero,$datos,$dircentro)
	{
	if (!file_exists($dircentro) && $dircentro!='global') 
	{
 	   mkdir($dircentro, 0777, true);
	}
	print("escribiendo fichero ".$fichero);
 	$fp = fopen($fichero, 'w');
	fputcsv($fp, $datos);
	fclose($fp);
	}

  public function query($vc,$sql,$param='',$centro=''){
    $results = array();
    $sql=str_replace('pcentro',$param,$sql);
    print($sql.PHP_EOL);
    $res = mysqli_query($vc,$sql);
    if ($res){
      if (strpos($sql,'SELECT') === false){
      print("hay res pero no select".$sql);
	  return true;
      }
    }
    else{
      if (strpos($sql,'SELECT') === false){
      print("NO hay res pero no select");
        return false;
      }
      else{
      print("ERROR ".mysqli_error($vc));
        return null;
      }
    }
    while ($row = mysqli_fetch_array($res)){
	  $results[] = $row;
    }
    return $results;        
  }
}
 
class AccesoQueryResults {
     
  private $_results = array();

  private $csv_dir='';
 
  public function __construct($dir){
    $this->csv_dir=$dir;
	}
 
  public function __set($var,$val){
    $this->_results[$var] = $val;
  }
 
  public function __get($var){  
    if (isset($this->_results[$var])){
      return $this->_results[$var];
    }
    else{
      return null;
    }
  }
}
?>
