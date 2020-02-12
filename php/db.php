<?php
class DataBase {
	public $conn;
	public $db;
	public $queryCount = 0;
	public $queries = array();
	static private $instance;
	
	public function __construct($c,$database)
	{
		include_once('parametros.php');
		$this->conn = $c;
		$this->db = $database;
		mysqli_select_db($this->conn,$this->db);
		mysqli_set_charset($this->conn, 'utf8');
	}
	
	static public function instance()
	{
		if (!isset(self::$instance)) {
			$name = __CLASS__;
			self::$instance = new $name;
		}
		return self::$instance;
	}
	
	public function esc($str)
	{  
		if (is_null($str)) return null; 
		return mysqli_real_escape_string($this->conn, $str); 
	}

	public function escape($str)
	{ 
		if (is_null($str)) return null; 
		return mysqli_real_escape_string($this->conn, $str); 
	} 
	
	public function escapeArray($arr)
	{
        foreach ($arr as $k => $v) {
        	if (!is_null($v)) {
            	$arr[$k] = $this->escape($v);
            }
        }
        return $arr;
	}
	
	public function lastError() {
		return mysqli_error($this->conn);
	}

	public function query($query)
	{
		$this->queryCount++;
		$this->queries[] = $query;
		
		$result = mysqli_query($this->conn, $query);
		
		if ($result === false) {
			$this->debug($query);
		}
		
		if (!$result||mysqli_num_rows($result) == 0) {
			return array();
		}
		
		$salida = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$salida[] = $row;
		}
		mysqli_free_result($result);
		
		return $salida;
	}
	
	public function get_correoalumnos()
	{
			$q="select email from alumnos";
			$r=$this->query($q);
			return $r;
	 }
	public function check_respondido($correo)
	{
			$q="select email from alumnos a, respuestas r where a.idalumnofct=r.idalumnofct and email='".$correo."'";
			$resultado=$this->query($q);
			if(count($resultado)==0){echo "no respondido seguro"; return 0;}
			else return 1;
	 }
	public function showciclo($idciclofct,$per)
	{
			if($idciclofct=='') return;
			$idciclofct=trim($idciclofct);
			$q="select denciclo,codciclo from ciclos where idciclofct=".$idciclofct;
			$r=$this->query($q);
			if(empty($r)) return 0;
			else
			$aciclo=$r[0]['denciclo'].'<br><br>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;';
			
			$html='<div class="row" style="border-bottom:0"><button type="button" data-toggle="collapse" data-target="#'.$idciclofct.$per.'" class="btn btn-primary bciclo">'.$aciclo.'</button></div><br>';
			print($html);
	 }

	public function get_centrousuario($u)
	{
				$q="select nombrecentro from usuarios u,centros c where u.idcentrofct=c.idcentrofct and  usernamefct='".$u."'";
				$r=$this->query($q);
				if(empty($r)) return 0;
				else return $r[0];
				
	}
	public function get_tipousuario($u)
	{
				$q="select idgrupo from usuarios u where  usernamefct='".$u."'";
				$r=$this->query($q);
				if(empty($r)) return 0;
				else 
				return $r[0]['idgrupo'];
	}	
	public function get_datosusuario($u)
	{
				$t=$this->get_tipousuario($u);
				if($t=='alumno')	
				$q="select idgrupo,a.idcentrofct,a.idtutorfct,u.idusuariofct,fecha_fct,centrocodificado from usuarios u left join alumnos a on u.idusuariofct=a.idusuariofct left join centros cen on a.idcentrofct=cen.idcentrofct where  usernamefct='".$u."'";
				else
				$q="select u.idgrupo,u.idcentrofct,t.idtutorfct,u.idusuariofct, cen.centrocodificado from usuarios u left join  tutores t on u.idusuariofct=t.idusuariofct left join centros cen on cen.idcentrofct=u.idcentrofct where  usernamefct='".$u."'";
				if(DEBUG) print($q);
				$r=$this->query($q);
				if(empty($r)) return 0;
				else return $r[0];
				
	}

	public function get_ciclos($centro,$ffct,$dato='id',$tipo='director',$idtutor='',$idusuariofct='')
	{
		if($dato=='id')
			{
			$indice='idciclofct';
			if($tipo=='director') {
				$q=" select distinct(a.idciclofct),ci.codciclo from centros c,  alumnos a,ciclos ci where ci.idciclofct=a.idciclofct and c.idcentrofct=a.idcentrofct and a.idcentrofct=".$centro." and fecha_fct='".$ffct."'";	
				}
			elseif($tipo=='tutor')	{
				$q=" select distinct(idciclofct),idciclofct from tutores t where idtutorfct='".$idtutor."'";	
				}
			else{
				$q=" select distinct(a.idciclofct),codciclo from ciclos c, alumnos a where a.idciclofct=c.idciclofct and a.idusuariofct='".$idusuariofct."'";	
				}
			
			}
		else
			{
			$indice='denciclo';
			if($tipo=='director') {
				$q=" select distinct(ci.denciclo),ci.denciclo from centros c,  alumnos a,ciclos ci where ci.idciclofct=a.idciclofct and c.idcentrofct=a.idcentrofct  and a.idcentrofct=".$centro." and fecha_fct='".$ffct."'";	
				}
			else {
				$q=" select distinct(denciclo),denciclo from tutores t,ciclos c where t.idciclofct=c.idciclofct and  idtutorfct='".$idtutor."'";	
			}
			}
		if(DEBUG) print($q);
		$aciclos=array();
		$r=$this->query($q);
		if(empty($r)) return $aciclos;
		else
			foreach ($r as $k=>$v) 
				$aciclos[]=$r[$k][$indice];
		return $aciclos;
	}
	public function showciclos($usuario){
			$ciclos=$this->get_ciclos($usuario);
			foreach ($ciclos as $ciclo)
				$this->showciclo($ciclo,$estudio);

	}
	public function get_alumnos($ciclo,$centro,$tipo,$per,$tutor='',$idusuariofct='',$ffct=''){
			$alumnos=array();
			if($ciclo=='') return $alumnos;
			if($tipo=='alumno')
				$q=' select distinct(a.idalumnofct) ida, a.nombre n,a.primer_apellido pa, a.segundo_apellido sa,a.telefono t,a.email e,fecha_fct ffct from  alumnos a,ciclos c,centros ce where ce.idcentrofct=a.idcentrofct and a.idciclofct=c.idciclofct and ce.idcentrofct="'.$centro.'" and a.fecha_fct="'.$ffct.'" and c.idciclofct="'.$ciclo.'" and a.idusuariofct="'.$idusuariofct.'"';
			else 
				$q=' select distinct(a.idalumnofct) ida, a.nombre n,a.primer_apellido pa, a.segundo_apellido sa,a.telefono t,a.email e,fecha_fct ffct from  alumnos a,ciclos c,centros ce where ce.idcentrofct=a.idcentrofct and a.idciclofct=c.idciclofct and ce.idcentrofct="'.$centro.'" and fecha_fct="'.$ffct.'" and c.idciclofct="'.$ciclo.'"'; 
			$r=$this->query($q);
			if(DEBUG) print($q);
			foreach ($r as $k=>$v) 
				foreach ($r[$k] as $val){ 
					$alumnos[$k]['nombrec']=$r[$k]['n'].' '.$r[$k]['pa'];
					$alumnos[$k]['telefono']=$r[$k]['t'];
					$alumnos[$k]['email']=$r[$k]['e'];
					$alumnos[$k]['idalumno']=$r[$k]['ida'];
					$alumnos[$k]['fecha_fct']=$r[$k]['ffct'];
					#$alumnos[$k]['idtutorfct']=$tutor;
					}
			return $alumnos;
			}
	public function get_respuestas($alumno,$ffct){
			$ares=array();
			$q='select * from respuestas r where r.idalumnofct='.$alumno.' and fecha_fct="'.$ffct.'"' ;
			if(DEBUG) print($q);
			$r=$this->query($q);
			if(count($r)==0)
				{
				return 0;}
			else
			{
				$ares['periodo']=$r[0]['periodo'];
				$ares['fct']=$r[0]['fct'];
				$ares['trabaja']=$r[0]['trabaja'];
				$ares['relacionado']=$r[0]['relacionado'];
				$ares['contrato']=$r[0]['contrato'];
				$ares['mismaempresa']=$r[0]['mismaempresa'];
			}	 
			return $ares;	
				}
	public function showalumno($alumno){
		$respuestas=$this->get_respuestas($alumno['idalumno'],$alumno['fecha_fct']);	
		if($respuestas==0)
		{
$html= ' <div class="col-25 pres"><button type="" class="btn btn-primary cabecera">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button></div>';
		$html=$html.'<div class="row">
      <div class="col-25 ">
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Datos alumno</button></div>
        <h4>'.strtoupper($alumno["nombrec"]).'</h4>
        <h4><a href="tel:+'.$alumno["telefono"].'">'.$alumno["telefono"].'</a></h4>
        <h4><a href = "mailto: '.$alumno["email"].'">'.$alumno["email"].'</a></h4>
		 <input type="checkbox" value="reset['.$alumno['idalumno'].'][]" name="reset" class="reset"><span id="vaciar">VACIAR DATOS</span><br>
      </div>
	<div class="preg col-25"> 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">'.P1.'</button></div>
		 <input type="hidden" name="codciclo['.$alumno['idalumno'].'][]" value="existe">
		 <input type="hidden" name="dni['.$alumno['idalumno'].'][]" value="existe">
		 <input type="hidden" name="nombre['.$alumno['idalumno'].'][]" value="existe">
		 <input type="radio" name="fct['.$alumno['idalumno'].'][]" value="si">SI<br>
		  <input type="radio" name="fct['.$alumno['idalumno'].'][]" value="exento">EXENTO<br>
	</div>

	<div class="preg col-25 trab" > 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Situación laboral a los 67 meses</button></div>
		 <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" class="trabajasa" value="trabaja">TRABAJA<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="en desempleo">EN DESEMPLEO<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="estudia">ESTUDIA<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="nsnc">NS/NC<br>
	</div>
	<div class="sitrabaja" id="'.$alumno['idalumno'].'">
	<div class=" col-25 preg"> 
 <div class="col-25 pres preg"><button type="" class="pres btn btn-primary">¿En un trabajo relacionado con el título cursado?</button></div>
		 <input type="radio" name="relacionado['.$alumno['idalumno'].'][]" value="si">SI<br>
		  <input type="radio" name="relacionado['.$alumno['idalumno'].'][]" value="no">NO<br>
	</div>
	<div class=" col-25 preg"> 
 <div class="col-25 pres "><button type="" class="pres btn btn-primary">¿En la misma empresa de FCT?</button></div>
		 <input type="radio" name="mismaempresa['.$alumno['idalumno'].'][]" value="si">SI<br>
		  <input type="radio" name="mismaempresa['.$alumno['idalumno'].'][]" value="no">NO<br>
	</div>
	<div class=" col-25 preg"> 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Tipo contrato</button></div>
		 <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="fijo">FIJO<br>
		  <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="autonomo">CUENTA PROPIA<br>
		  <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="otro">OTRO<br>
	</div>
	</div>
</div>
<br>';
		}
	else{
		$f1=$f2=$t1=$t2=$t3=$t4=$r1=$r2=$c1=$c2=$c3=$m1=$m2='';
		
		if($respuestas['fct']=='SI') $f1='checked';
		elseif($respuestas['fct']=='EXENTO') $f2='checked';
		
		if($respuestas['trabaja']=='TRABAJA') $t1='checked';
		elseif ($respuestas['trabaja']=='EN DESEMPLEO') $t2='checked';
		elseif ($respuestas['trabaja']=='ESTUDIA') $t3='checked';
		elseif ($respuestas['trabaja']=='NSNC') $t4='checked';
		
		if($respuestas['relacionado']=='SI') $r1='checked';
		elseif($respuestas['relacionado']=='NO') $r2='checked';

		if($respuestas['contrato']=='FIJO') $c1='checked';
		elseif($respuestas['contrato']=='AUTONOMO') $c2='checked';
		elseif($respuestas['contrato']=='OTRO') $c3='checked';

		if($respuestas['mismaempresa']=='SI') $m1='checked';
		elseif($respuestas['mismaempresa']=='NO') $m2='checked';

		$html='<div class="row">
      <div class="col-25">
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Datos alumno</button></div>
        <h4 style="color:grey">'.strtoupper($alumno['nombrec']).'</h4>
        <h4 style="color:grey"><a href="tel:+'.$alumno["telefono"].'">'.$alumno["telefono"].'</a></h4>
        <h4 style="color:grey"><a href = "mailto: '.$alumno["email"].'">'.$alumno["email"].'</a></h4>
		 <input type="checkbox" class="reset"  value="reset['.$alumno['idalumno'].'][]" name="reset"><span id="vaciar">VACIAR DATOS</span><br>
      </div>
	<div class=" col-25 preg"> 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">¿Ha titulado en el periodo de Septiembre a Diciembre de 2017?</button></div>
		 <input type="hidden" name="codciclo['.$alumno['idalumno'].'][]" >
		 <input type="hidden" name="dni['.$alumno['idalumno'].'][]">
		 <input type="hidden" name="nombre['.$alumno['idalumno'].'][]" >
		 <input type="radio" name="fct['.$alumno['idalumno'].'][]" value="si" '.$f1.'>SI<br>
		  <input type="radio" name="fct['.$alumno['idalumno'].'][]" value="exento" '.$f2.'>EXENTO<br>
	</div>

	<div class="col-25 trab preg" > 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Situación laboral a los 6 meses</button></div>
		 <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" class="trabajasa" value="trabaja" '.$t1.'>TRABAJA<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="en desempleo" '.$t2.'>EN DESEMPLEO<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="estudia" '.$t3.'>ESTUDIA<br>
		  <input type="radio" name="trabaja['.$alumno['idalumno'].'][]" value="nsnc" '.$t4.' >NS/NC<br>
	</div>
	<div class="sitrabaja '.$t1.'" id="'.$alumno['idalumno'].'">
	<div class=" col-25 preg"> 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">¿En un trabajo relacionado con el título cursado?</button></div>
		 <input type="radio" name="relacionado['.$alumno['idalumno'].'][]" value="si" '.$r1.'>SI<br>
		  <input type="radio" name="relacionado['.$alumno['idalumno'].'][]" value="no" '.$r2.'>NO<br>
	</div>
	<div class="  col-25 preg">
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">¿En la misma empresa de FCT?</button></div>
		 <input type="radio" name="mismaempresa['.$alumno['idalumno'].'][]" value="si" '.$m1.'>SI<br>
		  <input type="radio" name="mismaempresa['.$alumno['idalumno'].'][]" value="no" '.$m2.'>NO<br>
	</div>
	<div class=" col-25 preg"> 
 <div class="col-25 pres"><button type="" class="pres btn btn-primary">Tipo contrato</button></div>
		 <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="fijo" '.$c1.'>FIJO<br>
		  <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="autonomo" '.$c2.'>CUENTA PROPIA<br>
		  <input type="radio" name="contrato['.$alumno['idalumno'].'][]" value="otro" '.$c3.'>OTRO<br>
	</div>
	</div>
</div>
<br>';
}
print($html);
		}
	public function showalumnos($ciclo,$centro,$tu,$per,$tutor='',$idusuariofct='',$fecha_fct=''){
			$na=0;
			$alumnos=$this->get_alumnos($ciclo,$centro,$tu,$per,$tutor,$idusuariofct,$fecha_fct);
			foreach ($alumnos as $k=>$v) 
				{
				if($alumnos[$k]['idalumno']=='724545') continue;
				$this->showalumno($alumnos[$k]);
				}

	}
	public function nuevo_alumno($r,$centro,$tutor,$ffct,$periodo){
		$aldata=array();
		if(DEBUG) print_r($r);
		$aldata=array_merge($aldata,$r);
		$aldata['idcentrofct']=$centro;
		$aldata['idtutorfct']=$tutor;
		$aldata['fecha_fct']=$ffct;
		$aldata['periodo']=$periodo;
		#$periodo=$r['periodo'];
		#obtenemos la denominacion del ciclo
		$q="select idciclofct from alumnos where idciclofct like '%".trim($r['codciclo'])."%' limit 1";
		$res=$this->query($q);
		#Si no existe el ciclo
		if(count($res)==0)
		{ 
			return 0;
		}
		else
		{
			$aldata['idciclofct']=$r['codciclo'];
		}
		#obtenemos el id correspondiente
		$q="select idalumnofct from alumnos order by idalumnofct desc limit 1";
		$res=$this->query($q);
		$tam=count($res);
		if( $tam==0) return 0;
		else
		{
		$aldata['idalumnofct']=$res[0]['idalumnofct']+1;
		$alrespuestas=$aldata;
		#borramos las respuestas condicionales si no han clickado en el boton de TRABAJA
			if($alrespuestas['trabaja']!='TRABAJA')
			{
				$alrespuestas['contrato']=null;
				$alrespuestas['relacionado']=null;
				$alrespuestas['mismaempresa']=null;
			}
		unset($alrespuestas['nombre']);
		unset($alrespuestas['dni']);
		unset($alrespuestas['idciclofct']);
		unset($alrespuestas['idcentrofct']);
		unset($alrespuestas['idtutorfct']);
		unset($alrespuestas['fecha_fct']);
		unset($aldata['codciclo']);
		unset($aldata['fct']);
		unset($aldata['trabaja']);
		unset($aldata['contrato']);
		unset($aldata['mismaempresa']);
		unset($aldata['relacionado']);
		unset($aldata['periodo']);
		$ret=$this->insert_registro('alumnos',$aldata);
		if($ret==3)
		return 3;
		$resp=$this->insert_respuestas($alrespuestas,$centro,$tutor,$periodo,$ffct);
		
		if($resp) return 1;
		else return 0;
		}
	}
	public function get_idtutor($u){

		$q="select idtutor from tutorciclo where username='".$u."'";

		$res=$this->query($q);
		$tam=count($res);
		if($tam==0) return 0;
		else return $res[0]['idtutor'];		

				}
	public function existe_alumno($r){
		$q="select idalumnofct from alumnos where idalumnofct='".$r['idalumnofct']."'";
		$res=$this->query($q);
		$tam=count($res);
		if($tam==0) return 0;
		else return 1;		

		}
	public function insert_respuestas($r,$centro,$tutor,$periodo,$fecha_fct){
		#descartamos respuestas vacias
		if(array_key_exists('fct',$r) or array_key_exists('contrato',$r) or array_key_exists('relacionado',$r) or array_key_exists('trabaja',$r) or array_key_exists('mismaempresa',$r)) 
		{
		$r['periodo']=$periodo;	
		$r['fecha_fct']=$fecha_fct;	
		if(!array_key_exists('fct',$r)) $r['fct']='SI';
		if ($this->existe_alumno($r)) 
		{
			unset($r['nombre']);	
			unset($r['dni']);	
			unset($r['codciclo']);	
			unset($r['email']);	
			unset($r['telefono']);	
		#borramos las respuestas condicionales si no han clickado en el boton de TRABAJA
			if(!array_key_exists('trabaja',$r))   
				{
				$r['contrato']=null;
				$r['relacionado']=null;
				$r['mismaempresa']=null;
				}
			elseif($r['trabaja']!='trabaja')
				{
				$r['contrato']=null;
				$r['relacionado']=null;
				$r['mismaempresa']=null;
				}
			if(!$this->existe_respuesta($r['idalumnofct'],$periodo,$fecha_fct))
			{
				if(DEBUG) print("NO EXISTE RESPUESTA");
				$out=$this->insert_registro('respuestas',$r);
			}
			else
			{
				if(!array_key_exists('trabaja',$r)) $r['trabaja']=null;
				$out=$this->update_respuestas($r);
			}
		}
		else
		{
			print("NO EXISTE EL ALUMNO");
			$out=$this->nuevo_alumno($r,$centro,$tutor,$fecha_fct,$periodo);
		}
		return $out;
		}
		elseif($this->existe_alumno($r)==0)
			{
			print("NO EXISTE EL ALUMNO");
			$r['fct']='EXENTO';
			$out=$this->nuevo_alumno($r,$centro,$tutor,$fecha_fct,$periodo);
			}
		return 1;
	}
	
	public function existe_respuesta($id,$periodo)
	{
	if(DEBUG){ print("Existe respuestas"); print_r($periodo);}
	$q="select idalumnofct from respuestas where idalumnofct=".$id." and periodo='".$periodo."'";
	$r=$this->query($q);
	if(!$r) return 0;
	if( $r[0]['idalumnofct']!='') 
		return 1;
	else return 0;		
	}
	public function update_respuestas($r)
	{
	$res=1;
	$regvacio=0;
	$idalumno=$r['idalumnofct'];
	unset($r['nombre']);
	unset($r['dni']);
	unset($r['codciclo']);
	if(count(array_keys($r))==1)
		$regvacio=1;
	unset($r['idalumnofct']);
	if(DEBUG) print_r($r);
	if(count(array_keys($r))>=1)
		{
		$res=$this->update('respuestas',$r,array('where'=>array('idalumnofct='.$idalumno,'periodo="'.$r['periodo'].'"')));
		}
	return $res;

	}


	public function count($table, $opts = array())
	{
		$where = "";
		
		if (!empty($opts['where'])) {
			$where = $this->where($opts['where']);
		}
		
		$query = "SELECT COUNT(*) AS result FROM $table $where";
		
		$row = $this->queryOne($query);
		
		return (int)$row['result'];
	}
	
	public function lastId()
	{
		return mysqli_insert_id($this->conn);
	}
	
	protected function debug($query)
	{
		//echo "<br>Error in the sentence: ". $query . "<br>";
		//echo mysqli_error();
		//$e = new Exception();
		//pr($e->getTraceAsString());
	}
	
	public function insert_registro($table, $data)
	{
		$this->queryCount++;
		
		$fields = $this->escapeArray(array_keys($data));
		$values = $this->escapeArray(array_values($data));
		
		foreach ($values as $k => $val) {
			if (is_null($val)) {
				$values[$k] = 'NULL';
			} else {
				$values[$k] = "'$val'";
			}
		}
		
		$query = "INSERT INTO $table(`".join("`,`",$fields)."`) VALUES(".join(",", $values).")";
		$this->queries[] = $query;
		$ret=mysqli_query($this->conn, $query);
		$out=1;
		if(DEBUG) print($query);
		if (!$ret) {
			$out=3;
   			die('Invalid query: ' . mysqli_error($this->conn));
			}
		
		return $out;
	}
	
	public function execute($query)
	{
		$this->queryCount++;
		$this->queries[] = $query;
		
		return mysqli_query($this->conn, $query);
	}
	public function multiExecute($multiQuery)
	{
		$this->queryCount++;
		$this->queries[] = $multiQuery;
		
		return mysqli_multi_query($this->conn, $multiQuery);
	}
	
	public function getAffectedRows()
	{
		return mysqli_affected_rows($this->conn);
	}
	
	public function select($table, $opts = array())
	{
		$fields = "*";
		$where = '';
		$order = '';
		
		if (!empty($opts['fields'])) {
			if (is_array($opts['fields'])) {
				$fields = join(",", $opts['fields']);
			} else {
				$fields = $opts['fields'];
			}
		}
		
		if (!empty($opts['where'])) {
			$where = $this->where($opts['where']);
		}
		
		if (!empty($opts['order'])) {
			$order = "ORDER BY " . $opts['order'];
		}
		
		$query = "SELECT $fields FROM $table $where $order";
		
		if (!empty($opts['limit'])) {
			if ($opts['limit'] === 1 || $opts['limit'] == '1') {
				return $this->queryOne($query." LIMIT 1");
			}
			
			$query .= " LIMIT ".$opts['limit'];
		}
		
		return $this->query($query);
	}
	
	public function selectOne($table, $opts = array())
	{
		$opts['limit'] = 1;
		return $this->select($table, $opts);
	}
	
	public function update($table, $data, $opts = array())
	{
		$where = "";
		if (!empty($opts['where'])) {
			$where = $this->where($opts['where']);
		}
		
		$update = array();
		foreach ($data as $field => $value) {
			if (is_null($value)) {
				$update[] = "`$field` = NULL";
			} else {
				$update[] = "`$field` = '".$this->esc($value)."'";
			}
		}
		
		$query = "UPDATE $table SET ".join(" , ", $update)." $where";
		if(DEBUG) print($query);
		return $this->execute($query);
	}
	
	public function where($conditions)
	{
		$where = "";
		if (!empty($conditions) && is_array($conditions)) {
			$where = array();
			foreach ($conditions as $field => $value) {
				if (is_numeric($field) || empty($field)) {
					$where[] = " $value ";
				} else if (is_null($value)) {
					$where[] = " $field is null ";
				} else {
					$where[] = " $field = '".$this->escape($value)."' ";
				}
			}
			if (!empty($where)) {
				$where = " WHERE " . join(" AND ", $where);
			}
		} else if (!empty($conditions)) {
			$where = " WHERE " . $conditions;
		}
		return $where;
	}
	
	public function getById($table, $id, $fields = null)
	{
		if (!empty($fields)) {
			$query = "SELECT $fields FROM $table WHERE ID = '".(int)$id."'";
		} else {
			$query = "SELECT * FROM $table WHERE ID = '".(int)$id."'";
		}
		return $this->queryOne($query);
	}
	
	public function queryOne($query)
	{
		$this->queryCount++;
		$this->queries[] = $query;
		
		$result = mysqli_query($this->conn, $query);
		if (!$result) {
			return false;
		}
		
		if (mysqli_num_rows($result) == 0) {
			return false;
		}
		$row = mysqli_fetch_assoc($result);
		
		mysqli_free_result($result);
		
		return $row;
	}
	
	public function begin()
	{ 
		return $this->execute("START TRANSACTION;"); 
	}
	public function rollback()
	{ 
		return $this->execute("ROLLBACK;"); 
	}
	public function commit()
	{ 
		return $this->execute("COMMIT;"); 
	}
}
