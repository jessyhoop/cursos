<?php

class Importar_csv_model extends CI_Model{
	
	 public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	function select(){
		$this->db->select('*');
		$this->db->from('alumno, usuario');
		$this->db->where('alumno.usuario_idusuario=usuario.idusuario');
		$this->db->order_by('alumno.idalumno','DESC');
		$query = $this->db->get();
		return $query;
	} 
	
	
}
?>