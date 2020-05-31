<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class profesores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function valida_existe($numero_cuenta, $rfc) {
        $this->db->select('COUNT(profesor.idprofesor) AS cantidad');
        $this->db->from('profesor');
        $this->db->where('(profesor.rfc = \'' . $rfc . '\' OR profesor.num_cuenta = \'' . $numero_cuenta_ . '\')');
        $this->db->where('profesor.status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_id_by_nombre_prof($nombre, $apellido_p, $apelido_m) {
        $this->db->select("idprofesor");
        $this->db->from('profesor');
        $this->db->where('profesor.nombre', $nombre);
        $this->db->where('profesor.apellido_p', $apellido_p);
        $this->db->where('profesor.apellido_m', $apelido_m);
        $this->db->where('profesor.status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    function valida_existe_profesor_update($numero_cuenta_, $rfc, $id_usuario) {
        $this->db->select('COUNT(profesor.idprofesor) AS cantidad');
        $this->db->from('profesor');
        $this->db->where('(profesor.rfc = \'' . $rfc . '\' OR profesor.num_cuenta = \'' . $numero_cuenta_ . '\')');
        $this->db->where('profesor.status', 1);
        $this->db->where('profesor.usuario_idusuario != ', $id_usuario);
        $query = $this->db->get();
        return $query->row_array();
//        $this->db->select('Count(profesor.idprofesor) as cantidad');
//        $this->db->where("profesor.rfc", $rfc);
//        $this->db->or_where("profesor.num_cuenta", $numero_cuenta_);
//        $this->db->where("profesor.status", 1);
//        $this->db->where("profesor.usuario_idusuario!=", $id_usuario);
//        $query = $this->db->get('profesor');
//        return $query->row_array();
    }

    function get_profesores() {
        $this->db->select("CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre_com,"
                . "usuario.correoelectronico,
            usuario.status,
            profesor.idprofesor,
            profesor.nombre,
            profesor.apellido_p,
            profesor.apellido_m,
            profesor.num_cuenta,
            profesor.rfc,
            profesor.usuario_idusuario");
        $this->db->join("usuario", ' profesor.usuario_idusuario = usuario.idusuario');
        $this->db->where("usuario.status", 1);
        $this->db->where("profesor.status", 1);
        $query = $this->db->get('profesor');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function insert($nombre, $apellido_paterno, $apellido_materno, $rfc, $cuenta, $status, $usuario_id) {
        $data = array(
            'nombre' => $nombre,
            'apellido_p' => $apellido_paterno,
            'apellido_m' => $apellido_materno,
            'num_cuenta' => $cuenta,
            'rfc' => $rfc,
            'status' => $status,
            'usuario_idusuario' => $usuario_id
        );
        $query = $this->db->insert('profesor', $data);
        if ($query) {
            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

    function update_profesor($nombre, $apellido_paterno, $apellido_materno, $rfc, $cuenta, $usuario_id) {
        $this->db->set('nombre', $nombre);
        $this->db->set('apellido_p', $apellido_paterno);
        $this->db->set('apellido_m', $apellido_materno);
        $this->db->set('rfc', $rfc);
        $this->db->set('num_cuenta', $cuenta);
        $this->db->where('usuario_idusuario', $usuario_id);
        $this->db->update('profesor');
    }

    function elimina_usuario($id_usuario) {

        $this->db->set('status', 0);
        $this->db->where('usuario_idusuario', $id_usuario);
        return $this->db->update('profesor');
    }

}
