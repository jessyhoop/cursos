<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class Alumnos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function valida_existe_alumno($numero_cuenta_, $rfc) {
        $this->db->select('COUNT(alumno.idalumno) AS cantidad');
        $this->db->from('alumno');
        $this->db->where('(alumno.rfc = \'' . $rfc . '\' OR alumno.num_cuenta = \'' . $numero_cuenta_ . '\')');
        $this->db->where('alumno.status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }

    function valida_existe_alumno_update($numero_cuenta_, $rfc, $id_suario) {
        $this->db->select('COUNT(alumno.idprofesor) AS cantidad');
        $this->db->from('alumno');
        $this->db->where('(alumno.rfc = \'' . $rfc . '\' OR alumno.num_cuenta = \'' . $numero_cuenta_ . '\')');
        $this->db->where('alumno.status', 1);
        $this->db->where("alumno.usuario_idusuario!=", $id_suario);
        $query = $this->db->get();
//        echo '<pre>';
//        print_r($this->db->last_query());
//        echo '</pre>';
        return $query->row_array();
    }

    function get_alumnos() {
        $this->db->select("CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre_com,"
                . "usuario.correoelectronico,
            usuario.status,
            alumno.idalumno,
            alumno.nombre,
            alumno.apellido_p,
            alumno.apellido_m,
            alumno.num_cuenta,
            alumno.rfc,
            alumno.usuario_idusuario");
        $this->db->join("usuario", ' alumno.usuario_idusuario = usuario.idusuario');
        $this->db->where("usuario.status", 1);
        $this->db->where("alumno.status", 1);
        $query = $this->db->get('alumno');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function insert_datos_alumno($nombre, $apellido_paterno, $apellido_materno, $rfc, $cuenta, $status, $usuario_id) {
        $data = array(
            'nombre' => $nombre,
            'apellido_p' => $apellido_paterno,
            'apellido_m' => $apellido_materno,
            'rfc' => $rfc,
            'num_cuenta' => $cuenta,
            'status' => $status,
            'usuario_idusuario' => $usuario_id,
            'nombre_completo' => $apellido_paterno.' '.$apellido_materno.''.$nombre
        );
        $query = $this->db->insert('alumno', $data);
        if ($query) {
            return $this->db->insert_id();
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

    function insert_alumno_carreras($id_carrera, $id_alumno,$status) {
        $data = array(
            'id_alumno' => $id_alumno,
            'id_carrera' => $id_carrera,
            'status' => $status,
        );
        $query = $this->db->insert('alumno_carrera', $data);
        if ($query) {
            return TRUE;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

    function elimina_alumno($id_usuario) {

        $this->db->set('status', 0);
        $this->db->where('usuario_idusuario', $id_usuario);
        return $this->db->update('alumno');
    }

    function update_alumno($nombre, $apellido_paterno, $apellido_materno, $rfc, $cuenta, $usuario_id) {
        $this->db->set('nombre', $nombre);
        $this->db->set('apellido_p', $apellido_paterno);
        $this->db->set('apellido_m', $apellido_materno);
        $this->db->set('rfc', $rfc);
        $this->db->set('num_cuenta', $cuenta);
        $this->db->where('usuario_idusuario', $usuario_id);
        $this->db->update('alumno');
    }

//    ----------------------- C S V-------------------------------------
    function get_id_alumno_by_correo_nombre_completo($nombre_completo, $correo_ele) {
        $this->db->select('alumno.idalumno,
alumno.nombre_completo,
usuario.correoelectronico');
        $this->db->join("usuario", ' alumno.usuario_idusuario = usuario.idusuario');
        $this->db->where('alumno.nombre_completo', $nombre_completo);
        $this->db->where('usuario.correoelectronico', $correo_ele);
        $this->db->where('alumno.status', 1);
        $this->db->where('usuario.status', 1);
        $this->db->where('alumno.status', 1);
        $this->db->limit(1);
        $query = $this->db->get('alumno');
//        echo '<pre>';
//        print_r($this->db->last_query());
//        echo '</pre>';
        return $query->row_array();
    }

    function get_alumnos_carrera_division() {
        $this->db->select("alumno.nombre_completo,
        usuario.correoelectronico,
        carrera.carrera,
        carrera.abreviatura,
        division.division");
        $this->db->join("alumno", ' alumno_carrera.id_alumno = alumno.idalumno');
        $this->db->join("carrera", ' alumno_carrera.id_carrera = carrera.idcarrera');
        $this->db->join("division", ' carrera.id_division = division.id_division');
        $this->db->join("usuario", ' alumno.usuario_idusuario = usuario.idusuario');
        $this->db->where("usuario.status", 1);
        $this->db->where("alumno.status", 1);
        $this->db->where("alumno_carrera.status", 1);
        $this->db->where("carrera.status", 1);
        $query = $this->db->get('alumno_carrera');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function insert_datos_alumno_csv($nombre_completo, $nombre, $apellido_paterno, $apellido_materno, $rfc, $cuenta, $status, $usuario_id) {
        $data = array(
            'nombre' => $nombre,
            'nombre_completo' => $nombre_completo,
            'apellido_p' => $apellido_paterno,
            'apellido_m' => $apellido_materno,
            'rfc' => $rfc,
            'num_cuenta' => $cuenta,
            'status' => $status,
            'usuario_idusuario' => $usuario_id
        );
        $query = $this->db->insert('alumno', $data);

        if ($query) {

            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

}
