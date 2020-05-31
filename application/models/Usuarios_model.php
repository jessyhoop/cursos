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
    
    
    
    

    function update_usuario($id_usuario,
            $correoelectronico) {
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
    function valida_existe_usuario($correoelectronico) {
        $this->db->select('Count(usuario.idusuario) as cantidad');
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }
    function valida_existe_usuario_update($correoelectronico,$id_usuario) {
        $this->db->select('Count(usuario.idusuario) as cantidad');
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("usuario.idusuario !=", $id_usuario);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

    function get_existe_usuario_by_correo_num_cuenta($correoelectronico,$num_cuenta) {
        
        $this->db->select('usuario.idusuario');
        $this->db->join('profesor','profesor.usuario_idusuario = usuario.idusuario','left');
        $this->db->join('alumno',' alumno.usuario_idusuario = usuario.idusuario','left');
        $this->db->where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("profesor.num_cuenta", $num_cuenta);
        $this->db->where("profesor.status", 1);
        $this->db->or_where("usuario.correoelectronico", $correoelectronico);
        $this->db->where("alumno.num_cuenta", $num_cuenta);
        $this->db->where("alumno.status", 1);
        $this->db->where("usuario.status", 1);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

}
