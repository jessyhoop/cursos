<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class cursos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_cursos_by_alumno($id_ususario) {
        $this->db->select("
                        curso.idcurso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.hora_inicio,
            curso.hora_fin,
            curso.curso,
            curso.profesor_idprofesor,
            curso.carrera_idcarrera,
            curso.status,
            curso.cupo,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre,
            carrera.carrera");
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("carrera", 'curso.carrera_idcarrera = carrera.idcarrera');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("carrera.status", 1);
        $this->db->where("curso.profesor_idprofesor", $id_ususario);
        $query = $this->db->get('curso');
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_cursos_by_profesor($id_profesor) {
        $this->db->select("
                        curso.idcurso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.hora_inicio,
            curso.hora_fin,
            curso.curso,
            curso.profesor_idprofesor,
            curso.carrera_idcarrera,
            curso.status,
            curso.cupo,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre,
            carrera.carrera");
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("carrera", 'curso.carrera_idcarrera = carrera.idcarrera');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("carrera.status", 1);
        $this->db->where("curso.profesor_idprofesor", $id_profesor);
        $query = $this->db->get('curso');
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_cursos_all() {
        $this->db->select("
                        curso.idcurso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.hora_inicio,
            curso.hora_fin,
            curso.curso,
            curso.profesor_idprofesor,
            curso.carrera_idcarrera,
            curso.status,
            curso.cupo,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre,
            carrera.carrera");
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("carrera", 'curso.carrera_idcarrera = carrera.idcarrera');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("carrera.status", 1);
        $query = $this->db->get('curso');
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_distinc_curso() {
        $this->db->select("
DISTINCT(curso.curso)
            ");
        $this->db->where("curso.status", 1);
        $query = $this->db->get('curso');
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_cupo_by_curso($id_curso) {
        $this->db->select("curso.cupo");
        $this->db->where("idcurso", $id_curso);
        $this->db->where("status", 1);
        $query = $this->db->get('curso');
        return $query->row_array();
    }

    function get_curso_by_id($id_curso) {
        $this->db->select("curso.idcurso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.hora_inicio,
            curso.hora_fin,
            curso.curso,
            curso.cupo,
            profesor.idprofesor,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre,
            carrera.idcarrera,
            carrera.carrera");
        $this->db->join("carrera", 'curso.carrera_idcarrera = carrera.idcarrera');
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->where("idcurso", $id_curso);
        $this->db->where("carrera.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("curso.status", 1);
        $query = $this->db->get('curso');
//        $arreglo=$consulta->result_array();

        return $query->row_array();
    }

    function valida_existe_curso($id_carrera, $curso, $turno_curso, $profesor_id, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin
    ) {
        $this->db->select('Count(curso.idcurso) as cantidad');
        $this->db->where("curso.turno", $turno_curso);
        $this->db->where("curso.carrera_idcarrera", $id_carrera);
        $this->db->where("curso.curso", $curso);
        $this->db->where("curso.profesor_idprofesor", $profesor_id);
        $this->db->where("curso.status", 1);
        $this->db->where("curso.fecha_inicio", $fecha_inicio);
        $this->db->where("curso.fecha_fin", $fecha_fin);
        $this->db->where("curso.hora_inicio", $hora_inicio);
        $this->db->where("curso.hora_fin", $hora_fin);
        $this->db->where("curso.status", 1);
        $query = $this->db->get('curso');
        return $query->row_array();
    }

    function eliminar_curso($id_cursos) {

        $this->db->set('status', 0);
        $this->db->where('idcurso', $id_cursos);
        return $this->db->update('curso');
    }

    function update_datos_curso(
    $id_curso, $turno, $id_carrera, $curso, $cupo, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin) {

        $this->db->set('carrera_idcarrera', $id_carrera);
        $this->db->set('turno', $turno);
        $this->db->set('curso', $curso);
        $this->db->set('cupo', $cupo);
        $this->db->set('fecha_inicio', $fecha_inicio);
        $this->db->set('fecha_fin', $fecha_fin);
        $this->db->set('hora_inicio', $hora_inicio);
        $this->db->set('hora_fin', $hora_fin);
        $this->db->where('idcurso', $id_curso);
        return $this->db->update('curso');
    }

    function insert_datos_curso($id_carrera, $curso, $turno_curso, $profesor_id, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin, $cupo, $status) {
        $data = array(
            'carrera_idcarrera' => $id_carrera,
            'turno' => $turno_curso,
            'profesor_idprofesor' => $profesor_id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'curso' => $curso,
            'cupo' => $cupo,
            'status' => $status
        );
        $query = $this->db->insert('curso', $data);

        if ($query) {

            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }

//        --------------------------------------C S V-------------------
        function get_curso_by_name_fecha_hora($curso, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin) {
            $this->db->select('curso.idcurso,
            curso.curso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.`status`,
            curso.cupo,
            curso.hora_fin,
            curso.hora_inicio,
            curso.carrera_idcarrera,
            curso.profesor_idprofesor');
            $this->db->where("curso.curso", $curso);
            $this->db->where("curso.fecha_inicio", $fecha_inicio);
            $this->db->where("curso.fecha_fin", $fecha_fin);
            $this->db->where("curso.hora_inicio", $hora_inicio);
            $this->db->where("curso.hora_fin", $hora_fin);
            $query = $this->db->get('curso');
            return $query->row_array();
        }

    }

    function get_curso_by_name_fecha_hora($curso, $fecha_inicio, $fecha_fin, $hora_inicio, $hora_fin) {
        $this->db->select('curso.idcurso,
        curso.curso,
        curso.turno,
        curso.fecha_inicio,
        curso.fecha_fin,
        curso.`status`,
        curso.cupo,
        curso.hora_fin,
        curso.hora_inicio,
        curso.carrera_idcarrera,
        curso.profesor_idprofesor');
        $this->db->where("curso.curso", $curso);
        $this->db->where("curso.fecha_inicio", $fecha_inicio);
        $this->db->where("curso.fecha_fin", $fecha_fin);
        $this->db->where("curso.hora_inicio", $hora_inicio);
        $this->db->where("curso.hora_fin", $hora_fin);
        $query = $this->db->get('curso');
        return $query->row_array();
    }
//----------------------------------- CSV-------------------------------

}
