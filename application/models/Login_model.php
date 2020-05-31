<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 */
class Login_model extends CI_Model {

    //dsfds
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function validate_nombre_de_usaurio($name_user) {
        $query = $this->db->select('usuario');
        $query = $this->db->where('usuario', $name_user);
        $query = $this->db->get('usuario');
        return $query->num_rows() > 0 ? true : false;
    }

    function get_datos_profesor($id_usuario) {
        $this->db->select("
            profesor.idprofesor,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m)  nombre_completo,
            profesor.num_cuenta,
            profesor.status,
            profesor.rfc
            ");
        $this->db->where("profesor.usuario_idusuario", $id_usuario);
        $this->db->limit(1);
        $query = $this->db->get('profesor');
        return $query->num_rows() > 0 ? $query->row_array() : false;
    }

    function get_datos_alumno($id_usuario) {
        $this->db->select("
            alumno.idalumno,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m)  nombre_completo,
            alumno.num_cuenta,
            alumno.status,
            alumno.rfc
            ");
        $this->db->where("alumno.usuario_idusuario", $id_usuario);
        $this->db->limit(1);
        $query = $this->db->get('alumno');
        return $query->num_rows() > 0 ? $query->row_array() : false;
    }

    function login_usuario($correoelectronico, $password) {
        $password_enc = sha1($password);
        $this->db->select("
            usuario.correoelectronico,
            usuario.idusuario,
            usuario.rol,
            usuario.status
            ");
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("usuario.passwd", $password_enc);
        $this->db->limit(1);
        $query = $this->db->get('usuario');
//        $arreglo=$consulta->result_array();

        return $query->num_rows() > 0 ? $query->row_array() : false;
    }

//------------------------------------------------------------------------------//
}

?>