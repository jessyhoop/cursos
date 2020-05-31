<?php

defined("BASEPATH") OR die("El acceso al script no está permitido");

class cursos_alumno_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_alumnos_by_asistencia_curso() {
        $this->db->select("
                        curso.curso,
CONCAT(nombre,' ',apellido_p,' ',apellido_m) AS nombre_profesor,
CONCAT(curso.fecha_inicio,'  al  ',curso.fecha_fin) as periodo,
CONCAT(TIME_FORMAT(curso.hora_inicio, '%H:%i'),' a ',TIME_FORMAT(curso.hora_fin, '%H:%i')) as horario,
  count(alumno_curso.id_alumno_curso) AS total_inscritos,
    SUM(case when alumno_curso.asistio!='NO' then 1 else 0 end ) AS cursaron,
    SUM(case when alumno_curso.asistio='NO' then 1 else 0 end) AS no_cursaron");
        $this->db->join("curso", ''
                . 'curso.idcurso = alumno_curso.curso_idcurso');
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->group_by('curso.idcurso');  // Produces: GROUP BY title, date
        $query = $this->db->get('alumno_curso');
//        $arreglo=$consulta->result_array();
//        echo '<pre>';
//        print_r($this->db->last_query());
//        echo '</pre>';
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_count_by_carrera_curso($id_carrera, $curso) {
        $this->db->select("
            Count(alumno_curso.alumno_idalumno) as cantidad,
curso.curso,
carrera.carrera");
        $this->db->join("curso", 'alumno_curso.curso_idcurso = curso.idcurso');
        $this->db->join("alumno_carrera", 'alumno_curso.alumno_idalumno = alumno_carrera.id_alumno_carrera');
        $this->db->join("carrera", ' alumno_carrera.id_carrera = carrera.idcarrera ', 'RIGTH');
        $this->db->where("curso.status", 1);
        $this->db->where("carrera.status", 1);
        $this->db->where("alumno_curso.status", 1);
        $this->db->where("curso.curso", $curso);
        $this->db->where("carrera.idcarrera", $id_carrera);
        $this->db->group_by(array("curso.curso"));  // Produces: GROUP BY title, date
        $query = $this->db->get('alumno_curso');
//                        echo '<pre>';
//        print_r($this->db->last_query());
//        echo '</pre>';
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_cursos_by_alumno($id_alumno) {
        $this->db->select(" curso.curso,
            curso.turno,
            curso.fecha_inicio,
            curso.fecha_fin,
            curso.cupo,
            curso.status,
            curso.hora_fin,
            curso.hora_inicio,
            curso.idcurso,
            curso.carrera_idcarrera,
            curso.profesor_idprofesor,
            alumno_curso.alumno_idalumno,
            alumno_curso.curso_idcurso,
            alumno_curso.id_alumno_curso,
            alumno_curso.status,
            CONCAT(nombre,' ',apellido_p,' ',apellido_m) nombre,
            carrera.carrera");
        $this->db->join("curso", 'alumno_curso.curso_idcurso = curso.idcurso');
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("carrera", ' curso.carrera_idcarrera = carrera.idcarrera');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("carrera.status", 1);
        $this->db->where("alumno_curso.status", 1);
        $this->db->where("alumno_curso.alumno_idalumno", $id_alumno);
        $query = $this->db->get('alumno_curso');
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_correo_elec_by_profesor($id_profesor) {

        $this->db->select("
usuario.correoelectronico,
profesor.rfc");
        $this->db->join('profesor', 'profesor.usuario_idusuario = usuario.idusuario');
        $this->db->where("profesor.status", 1);
        $this->db->where("usuario.status", 1);
        $this->db->where("idprofesor", $id_profesor);
        $query = $this->db->get('usuario');
        return $query->row_array();
    }

    function get_alumnos_by_curso($id_curso) {
        $this->db->select("
        CONCAT(alumno.nombre,' ',alumno.apellido_p,' ',alumno.apellido_m) nombre_alumno,
        alumno.num_cuenta,
        usuario.correoelectronico,
        curso.curso,
        curso.turno,
        profesor.idprofesor,
        alumno.rfc,
        carrera.carrera,
        alumno.num_cuenta,
        curso.fecha_inicio,
        curso.fecha_fin,
        curso.hora_fin,
        curso.hora_inicio,
        alumno_curso.curso_idcurso,
         CONCAT(profesor.nombre,' ',profesor.apellido_p,' ',profesor.apellido_m) nombre_profesor,
        curso.idcurso");
        $this->db->join("alumno_carrera", ''
                . 'alumno_curso.alumno_idalumno = alumno_carrera.id_alumno_carrera');
        $this->db->join("alumno", ''
                . 'alumno_carrera.id_alumno = alumno.idalumno');
        $this->db->join("carrera", ''
                . 'alumno_carrera.id_carrera = carrera.idcarrera');
        $this->db->join("curso", 'alumno_curso.curso_idcurso = curso.idcurso');
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("usuario", 'alumno.usuario_idusuario = usuario.idusuario');

        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("alumno.status", 1);
        $this->db->where("alumno_curso.status", 1);
        $this->db->where("alumno_curso.curso_idcurso", $id_curso);
        $query = $this->db->get('alumno_curso');
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function valida_existe_alumno_curso($id_curso, $id_alumno) {
        $this->db->select('Count(alumno_curso.id_alumno_curso) as cantidad');
        $this->db->where("alumno_curso.curso_idcurso", $id_curso);
        $this->db->where("alumno_curso.alumno_idalumno", $id_alumno);
        $this->db->where("alumno_curso.status", 1);
        $query = $this->db->get('alumno_curso');
        return $query->row_array();
    }

    function count_alumnos_by_curso($id_curso) {
        $this->db->select('Count(id_alumno_curso) as cantidad');
        $this->db->where("alumno_curso.curso_idcurso", $id_curso);
        $this->db->where("alumno_curso.status", 1);
        $query = $this->db->get('alumno_curso');
        return $query->row_array();
    }

    function cupo_by_curso($id_curso) {
        $this->db->select('cantidad');
        $this->db->where("alumno_curso.curso_idcurso", $id_curso);
        $this->db->where("alumno_curso.status", 1);
        $query = $this->db->get('alumno_curso');
        return $query->row_array();
    }

    function eliminar_alumno_curso($id_alumno_cursos) {

        $this->db->set('status', 0);
        $this->db->where('id_alumno_curso', $id_alumno_cursos);
        return $this->db->update('alumno_curso');
    }

    function insert_alumno_curso($id_alumno, $id_curso, $status) {
        $data = array(
            'alumno_idalumno' => $id_alumno,
            'curso_idcurso' => $id_curso,
            'status' => $status
        );
        $query = $this->db->insert('alumno_curso', $data);

        if ($query) {

            return true;
        } else {
            $error = $this->db->error();
            return $error;
        }
    }

//    ---------------------------------- C S V-----------------

    function get_alumnos_curso() {
        $this->db->select(" alumno.nombre_completo,
curso.curso,
curso.turno,
curso.fecha_inicio,
curso.fecha_fin,
curso.hora_fin,
curso.hora_inicio,
profesor.apellido_p,
usuario.correoelectronico,
carrera.abreviatura,
concat(
profesor.nombre,
profesor.apellido_m,
profesor.apellido_p) as nombre_profesor,
alumno_carrera.id_carrera,
carrera.carrera");
        $this->db->join("alumno_carrera", 'alumno_curso.alumno_idalumno = alumno_carrera.id_alumno_carrera');
        $this->db->join("alumno", 'alumno_carrera.id_alumno = alumno.idalumno');
        $this->db->join("curso", 'alumno_curso.curso_idcurso = curso.idcurso');
        $this->db->join("profesor", 'curso.profesor_idprofesor = profesor.idprofesor');
        $this->db->join("carrera", ' alumno_carrera.id_carrera = carrera.idcarrera '
                . '');
        $this->db->join("usuario", ' alumno.usuario_idusuario = usuario.idusuario'
                . '');
        $this->db->where("curso.status", 1);
        $this->db->where("profesor.status", 1);
        $this->db->where("carrera.status", 1);
        $this->db->where("alumno_curso.status", 1);
        $query = $this->db->get('alumno_curso');
//                        echo '<pre>';
//        print_r($this->db->last_query());
//        echo '</pre>';
//        $arreglo=$consulta->result_array();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }

    function get_id_alumno_by_correo_name_carrera($nombre_alumno, $correo, $carrera) {

        $this->db->select("
alumno_carrera.id_alumno_carrera
");
        $this->db->join('alumno', 'alumno_carrera.id_alumno = alumno.idalumno');
        $this->db->join('carrera', 'alumno_carrera.id_carrera = carrera.idcarrera');
        $this->db->join('usuario', 'alumno.usuario_idusuario = usuario.idusuario');
        $this->db->where("usuario.status", 1);
        $this->db->where("nombre_completo", $nombre_alumno);
        $this->db->where("abreviatura", $carrera);
        $this->db->where("correoelectronico", $correo);
        $query = $this->db->get('alumno_carrera');
        return $query->row_array();
    }

}
