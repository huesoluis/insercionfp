<?php 
class CSVS {
   public $sql_base; 
   public $acceso; 
   public $dato;
   public $names;
  public function __construct($filtro='',$sql='',$acceso='',$param='',$names=''){
    	$this->filtro = $filtro;
    	$this->sql_base = $sql;
    	$this->acceso = $acceso;
    	$this->param = $param;
    	$this->names = $names;
	}

  public function gen_csv($filtro='',$sql=''){
	$res=$this->acceso->gen_csv($this->acceso->c,$sql,$this->param,$this->names);
	 return ;
  }
   
   
}
 
?>
