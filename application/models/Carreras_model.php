<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class carreras_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_carreras() {
        $this->db->select("carrera,idcarrera,division.division,division.id_division");
        $this->db->join("division", 'carrera.id_division = division.id_division');
        $this->db->where("carrera.status", 1);
        $this->db->where("division.status", 1);
        $this->db->group_by(array('division.id_division','carrera.idcarrera'));
        $query = $this->db->get('carrera');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_divisiones() {
        $this->db->select("id_division,division");
        $this->db->where("division.status", 1);
        $query = $this->db->get('division');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_carrera_by_id($id_carrera) {
        $this->db->select("carrera");
        $this->db->where("idcarrera", $id_carrera);
        $this->db->where("status", 1);
        $query = $this->db->get('carrera');
//        $arreglo=$consulta->result_array();

        return $query->result_array();
    }

    function eliminar_carrera($id_carrera) {

        $this->db->set('status', 0);
        $this->db->where('idcarrera', $id_carrera);
        return $this->db->update('carrera');
    }

    function update_datos_carrera($id_carrera, $carrera, $semestre, $clave_carrera) {

        $this->db->set('carrera', $carrera);
        $this->db->where('idcarrera', $id_carrera);
        return $this->db->update('carrera');
    }

    function insert_datos_carrera($carrera, $status) {
        $data = array(
            'carrera' => $carrera,
            'status' => $status
        );
        $query = $this->db->insert('carrera', $data);

        if ($query) {

            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

//--------------------------------------C S V---------------------------------

    function get_carrera_by_abreviatura($abreviatura) {
        $this->db->select("carrera.carrera,
    carrera.abreviatura,
    carrera.idcarrera,
     division.division");
        $this->db->join("division", 'carrera.id_division = division.id_division');
        $this->db->where("carrera.status", 1);
        $this->db->where("division.status", 1);
        $this->db->where("carrera.abreviatura", $abreviatura);
        $query = $this->db->get('carrera');
        return $query->row_array();
    }

}
