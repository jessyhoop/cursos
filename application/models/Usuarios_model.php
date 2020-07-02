<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_usuarios() {
        $this->db->select("correoelectronico,nombre,rol,rfc,idusuario");
        $this->db->where("status", 1);
        $query = $this->db->get('usuario');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_lista_roles() {
        $this->db->select("id,rol");
        $query = $this->db->get('rol');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_usuario($id_usuario) {
        $this->db->select("correoelectronico,nombre,rol,rfc,idusuario");
        $this->db->where("idusuario", $id_usuario);
        $query = $this->db->get('usuario');
        return $query->result_array();
    }

    function elimina_usuario($id_usuario) {

        $this->db->set('status', 0);
        $this->db->where('idusuario', $id_usuario);
        return $this->db->update('usuario');
    }

    function update_usuario($id_usuario, $correoelectronico) {
        $this->db->set('correoelectronico', $correoelectronico);
        $this->db->where('idusuario', $id_usuario);
        $this->db->update('usuario');
    }

    function update_passwd_usuario($id_usuario, $passwd) {
        $this->db->set('passwd', sha1($passwd));
//        $this->db->set('passwd', $pass);
        $this->db->where('idusuario', $id_usuario);
        return $this->db->update('usuario');
    }

    function insert_datos_usuario($correoelectronico, $passwd, $rol, $status) {
        $data = array(
            'correoelectronico' => $correoelectronico,
            'passwd' => sha1($passwd),
            'rol' => $rol,
            'status' => $status,
            'fecha_registro' =>
            date("Y-m-d H:i:s")
        );
        $query = $this->db->insert('usuario', $data);
        if ($query) {

            return $this->db->insert_id();
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

    function insert_usuario_alumno($data) {
        $datos_usuario = array(
            'correoelectronico' => $data['correo_usuario'],
            'passwd' => sha1($data['passwd_usuario']),
            'rol' => 3,
            'status' => 1,
            'fecha_registro' =>
            date("Y-m-d H:i:s")
        );
        $this->db->insert('usuario', $datos_usuario);
        $id_usuario = $this->db->insert_id();

        $datos_alumno = array(
            'nombre' => $data['nombre_usuario'],
            'apellido_p' => $data['apellidop_usuario'],
            'apellido_m' => $data['apellidom_usuario'],
            'rfc' => $data['rfc_usuario'],
            'num_cuenta' => $data['numcuenta_usuario'],
            'status' => 1,
            'usuario_idusuario' => $id_usuario,
            'nombre_completo' => $data['apellidop_usuario'] . ' ' .
            $data['apellidom_usuario'] . '' .
            $data['nombre_usuario']
        );
        $this->db->insert('alumno', $datos_alumno);
        $id_alumno = $this->db->insert_id();

        $carrera1 = array(
            'id_alumno' => $id_alumno,
            'id_carrera' => $data['carrera1'],
            'status' => 1,
        );
        if (array_key_exists('carrera2', $data)) {
            $carrera2 = array(
                'id_alumno' => $id_alumno,
                'id_carrera' => $data['carrera2'],
                'status' => 1,
            );
            $this->db->insert('alumno_carrera', $carrera1);
            $this->db->insert('alumno_carrera', $carrera2);
        } else {
            $this->db->insert('alumno_carrera', $carrera1);
        }
        if ($this->db->trans_status() === FALSE) {
            //Hubo errores en la consulta, entonces se cancela la transacción.   
            $this->db->trans_rollback();
            return false;
        } else {
            //Todas las consultas se hicieron correctamente.  
            $this->db->trans_commit();
            return true;
        }
    }

    function valida_existe_usuario($correoelectronico) {
        $this->db->select('Count(usuario.idusuario) as cantidad');
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

    function valida_existe_usuario_update($correoelectronico, $id_usuario) {
        $this->db->select('Count(usuario.idusuario) as cantidad');
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("usuario.idusuario !=", $id_usuario);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

    function get_existe_usuario_by_correo_num_cuenta($correoelectronico, $num_cuenta) {
        $this->db->select('usuario.idusuario');
        $this->db->join('profesor', 'profesor.usuario_idusuario = usuario.idusuario', 'left');
        $this->db->join('alumno', ' alumno.usuario_idusuario = usuario.idusuario', 'left');
        $this->db->where("profesor.status", 1);
        $this->db->where("profesor.num_cuenta", $num_cuenta);
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $this->db->or_where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("alumno.num_cuenta", $num_cuenta);
        $this->db->where("alumno.status", 1);
        $this->db->where("usuario.status", 1);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

}
