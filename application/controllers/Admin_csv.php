<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_csv extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //cargamos la libreria html2pdf
        $this->load->library('html2pdf');
        $this->load->library('form_validation');
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('html'); //agrega base_url
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('csvimport');
        $this->load->model('cursos_alumno_model');
        $this->load->model('carreras_model');
        $this->load->model('cursos_model');
        $this->load->model('alumnos_model');
        $this->load->model('profesores_model');
    }

    public function index() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('ccaragon/home_csv_view');
        }
    }

    public function csv_alumno_carrera() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('csv/csv_alumno_carrera_view');
        }
    }

    public function csv_alumno_curso() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('csv/csv_alumno_curso_view');
        }
    }

    public function csv_alumno() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('csv/csv_alumno_view');
        }
    }

    public function csv_cursos() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('csv/csv_curso_view');
        }
    }

    public function csv_profesores() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('csv/csv_profesores_view');
        }
    }

    function load_data_profesores() {
        $result = $this->profesores_model->get_profesores();
        $output = '
		 <h3 align="center">Profesores CSV</h3>
        <div class="table-responsive">
        	<table class="table table-bordered table-striped">
        		<tr>
        			<th> Nombre</th>
        			<th> Apellido P</th>
        			<th> Apellido M</th>
                                    <th scope="col">Num.Centa/Trabajador</th>
        			<th> RFC</th>
        			<th> id_usuario</th>
        			<th> correo Electronico</th>
		';
        $count = 0;
        if ($result) {
            foreach ($result as $row) {
                $count = $count + 1;
                $output .= '
				<tr>
					<td>' . $row['nombre'] . '</td>
					<td>' . $row['apellido_p'] . '</td>
					<td>' . $row['apellido_m'] . '</td>
					<td>' . $row['num_cuenta'] . '</td>
					<td>' . $row['rfc'] . '</td>
					<td>' . $row['usuario_idusuario'] . '</td>
					<td>' . $row['correoelectronico'] . '</td>
				</tr>
				';
            }
        } else {
            $output .= '
			<tr>
	    		<td colspan="5" align="center">Data not Available</td>
	    	</tr>
			';
        }
        $output .= '</table></div>';
        echo $output;
    }

    function import_profesores() {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        foreach ($file_data as $row) {
            $data[] = array(
                'nombre' => $this->nombre(($row["profesor"])),
                'apellidop_usuario' => $this->apellido_pat(($row["profesor"])),
                'apellidom_usuario' => $this->apellido_mat($row["profesor"]),
                'rfc_usuario' => 'HJIEJOSJ42EA',
                'numcuenta_usuario' => '123456789'
            );
        };
//echo $row;
//        print_r(mb_detect_encoding(utf8_encode($row)));
        for ($i = 0; $i < count($data); $i++) {
            $usuario = $this->usuarios_model->insert_datos_usuario(
                    'profesor@ragon.unam.mx', '12345678', 2, 1);
            $this->profesores_model->insert($data[$i]['nombre'], $data[$i]['apellidop_usuario'], $data[$i]['apellidom_usuario'], $data[$i]['numcuenta_usuario'], $data[$i]['rfc_usuario'], 1, $usuario);
        }
    }

    function load_data_cursos() {
        $result = $this->cursos_model->get_cursos_all();
        $output = '
		 <h3 align="center">Datos cursos</h3>
        <div class="table-responsive">
        	<table class="table table-bordered table-striped">
        		<tr>
        			<th class="th-sm">Numero </th>
        			<th class="th-sm">Turno </th>
                                <th class="th-sm">Curso </th>
                                <th class="th-sm">Carrera </th>
                                <th class="th-sm">Profesor</th>
                                <th class="th-sm">Fecha Inicio</th>
                                <th class="th-sm">Fecha Fin</th>
                                <th class="th-sm">Hora Inicio</th>
                                <th class="th-sm">Hora Fin</th>
                                <th class="th-sm">Cupo</th>
		';
        $count = 0;
        if ($result) {
            foreach ($result as $row) {
                $count = $count + 1;
                $output .= '
				<tr>
					<td>' . $count . '</td>
					<td>' . $row['turno'] . '</td>
					<td>' . $row['curso'] . '</td>
					<td>' . $row['carrera'] . '</td>
					<td>' . $row['nombre'] . '</td>
					<td>' . $row['fecha_inicio'] . '</td>
					<td>' . $row['fecha_fin'] . '</td>
					<td>' . $row['hora_inicio'] . '</td>
					<td>' . $row['hora_fin'] . '</td>
					<td>' . $row['cupo'] . '</td>
				</tr>
				';
            }
        } else {
            $output .= '
			<tr>
	    		<td colspan="5" align="center">Data not Available</td>
	    	</tr>
			';
        }
        $output .= '</table></div>';
        echo $output;
    }

    function import_cursos() {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        foreach ($file_data as $row) {
            $data[] = array(
                'carrera_idcarrera' => 1,
                'turno' => $this->turno($this->hora_inicio($row['Horario'])),
                'profesor_idprofesor' => $this->profesores_model->get_id_by_nombre_prof(
                        $this->nombre(($row["profesor"])), $this->apellido_pat(($row["profesor"])), $this->apellido_mat(($row["profesor"]))
                ),
                'fecha_inicio' => $this->convertir_fecha_formato_sql_a_diagonal($row['Fecha']),
                'fecha_fin' => $this->convertir_fecha_formato_sql_a_diagonal($row['Fecha']),
                'hora_inicio' => $this->hora_inicio($row['Horario']),
                'hora_fin' => $this->hora_fin($row['Horario']),
                'curso' => $row['Curso'],
                'cupo' => 20,
                'status' => 1
            );
        }
//        echo '<pre>';
//        print_r($data[0]['profesor_idprofesor']['idprofesor']);
//        echo '</pre>';
        for ($i = 0; $i < count($data); $i++) {
            $this->cursos_model->insert_datos_curso(
                    $data[$i]['carrera_idcarrera'], $data[$i]['curso'], $data[$i]['turno'], $data[$i]['profesor_idprofesor']['idprofesor'], $data[$i]['fecha_inicio'], $data[$i]['fecha_fin'], $data[$i]['hora_inicio'], $data[$i]['hora_fin'], $data[$i]['cupo'], $data[$i]['status']);
        }
    }

    function load_data_alumno() {
        $result = $this->alumnos_model->get_alumnos();
        $output = '
		 <h3 align="center">Importar archivo CSV </h3>
        <div class="table-responsive">
        
        	<table class="table table-bordered table-striped">
                
        		<tr>
        			<th> nombreCompleto</th>
        			<th> nombre</th>
        			<th> apellido_p</th>
        			<th> apellido_m</th>
                                    <th scope="col">Num.Centa/Trabajador</th>
        			<th> rfc</th>
        			<th> id_usuario</th>
        			<th> correo_electronico</th>
		';
        $count = 0;
        if ($result) {
            foreach ($result as $row) {
                $count = $count + 1;
                $output .= '
				<tr>
					<td>' . $row['nombre_com'] . '</td>
					<td>' . $row['nombre'] . '</td>
					<td>' . $row['apellido_p'] . '</td>
					<td>' . $row['apellido_m'] . '</td>
					<td>' . $row['num_cuenta'] . '</td>
					<td>' . $row['rfc'] . '</td>
					<td>' . $row['usuario_idusuario'] . '</td>
					<td>' . $row['correoelectronico'] . '</td>
				</tr>
				';
            }
        } else {
            $output .= '
			<tr>
	    		<td colspan="5" align="center">Datos no encontrados</td>
	    	</tr>
			';
        }
        $output .= '</table></div>';
        echo $output;
    }

    function import_alumno() {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        for ($index = 0; $index < count($file_data); $index++) {
            $data[] = [
                'nombre_completo' => $file_data[$index]["nombreCompleto"],
                'nombre' => $file_data[$index]["Nombre"],
                'apellidop_usuario' => $file_data[$index]["Apellido Paterno"],
                'apellidom_usuario' => $file_data[$index]["Apellido Materno"],
                'rfc_usuario' => 'HJIEJOSJ42EA',
                'numcuenta_usuario' => '123456789',
                'correo_ele' => $file_data[$index]['Correo'],
            ];
        }

//        echo '<pre>';
//        print_r($data);
//        echo '<pre>';
        for ($i = 0; $i < count($data); $i++) {
            $usuario = $this->usuarios_model->insert_datos_usuario(
                    $data[$i]['correo_ele'], '12345678', 3, 1);
            $this->alumnos_model->insert_datos_alumno_csv($data[$i]['nombre_completo'], $data[$i]['nombre'], $data[$i]['apellidop_usuario'], $data[$i]['apellidom_usuario'], $data[$i]['rfc_usuario'], $data[$i]['numcuenta_usuario'], 1, $usuario);
        }
    }

    public function load_data_alumno_curso() {
        $result = $this->cursos_alumno_model->get_alumnos_curso();
        echo json_encode($result);
    }

    function load_data_alumno_carrera() {
        $result = $this->alumnos_model->get_alumnos_carrera_division();
        $output = '
		 <h3 align="center">Imported User Details from CSV File</h3>
        <div class="table-responsive">
        	<table class="table table-bordered table-striped">
        		<tr>
        			<th> No</th>
        			<th> nombreCompleto</th>
        			<th> correo_electronico</th>
        			<th> carrera</th>
        			<th> abreviatura</th>
        			<th> division</th>
		';
        $count = 0;
        if ($result) {
            foreach ($result as $row) {
                $count = $count + 1;
                $output .= '
				<tr>
					<td>' . $count . '</td>
					<td>' . $row['nombre_completo'] . '</td>
					<td>' . $row['correoelectronico'] . '</td>
					<td>' . $row['carrera'] . '</td>
					<td>' . $row['abreviatura'] . '</td>
					<td>' . $row['division'] . '</td>
				</tr>
				';
            }
        } else {
            $output .= '
			<tr>
	    		<td colspan="5" align="center">Data not Available</td>
	    	</tr>
			';
        }
        $output .= '</table></div>';
        echo $output;
    }

    function import_alumno_carrera() {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        for ($index = 0; $index < count($file_data); $index++) {
            $data[] = [
                'id_alumno' => $this->alumnos_model->get_id_alumno_by_correo_nombre_completo($file_data[$index]["nombreCompleto"], $file_data[$index]["Correo"]),
                'nombre_com' => $file_data[$index]["nombreCompleto"],
                'id_carrera' => $this->carreras_model->get_carrera_by_abreviatura($file_data[$index]["Carrera"]
                ),
            ];
        }

//        echo '<pre>';
//        print_r($data);
//        echo '<pre>';
        for ($i = 0; $i < count($data); $i++) {
            $this->alumnos_model->insert_alumno_carreras(
                    $data[$i]['id_carrera']['idcarrera'], $data[$i]['id_alumno']['idalumno']
                    , 1);
        }
    }

    public function import_alumno_curso() {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
        for ($index = 0; $index < count($file_data); $index++) {
            $id_alumno = $this->cursos_alumno_model->get_id_alumno_by_correo_name_carrera(
                    $file_data[$index]["Nombre"], $file_data[$index]["Correo"], $file_data[$index]["Carrera"]);
            $id_curso = $this->cursos_model->get_curso_by_name_fecha_hora(
                    $file_data[$index]["Curso"], ($file_data[$index]["fecha"]), ($file_data[$index]["fecha"]), $this->hora_inicio($file_data[$index]["hora"]), $this->hora_fin($file_data[$index]["hora"]));
            if ($id_alumno && $id_curso) {
                if ($id_alumno > 0 && $id_curso > 0) {
                    $data[] = [
                        'id_alumno' => $id_alumno,
                        'id_curso' => $id_curso,
                        'asistio' => ($file_data[$index]["Inscrito"]),
                    ];
                } else {
                    $data_no_save[] = [
                        'id_alumno' => $id_alumno,
                        'id_curso' => $id_curso,
                        'carrera' => $file_data[$index]["Carrera"],
                        'nombre' => $file_data[$index]["Nombre"],
                        'correo' => $file_data[$index]["Correo"],
                        'curso' => $file_data[$index]["Curso"],
                        'fecha' => $file_data[$index]["fecha"],
                        'hora' => $file_data[$index]["hora"],
                        'asistio' => ($file_data[$index]["Inscrito"]),
                    ];
                }
            } else {
                echo '0';
            }
        }
        if (count($file_data) == count($data)) {
//            echo '<pre>';
//            print_r($data);
//        echo '</pre>';
            for ($i = 0; $i < count($data); $i++) {
                $this->cursos_alumno_model->insert_alumno_curso(
                        $data[$i]['id_alumno']['id_alumno_carrera'], $data[$i]['id_curso']['idcurso'], $data[$i]['asistio'], 1);
            }
            echo '0';
        } else {
            echo json_encode($data_no_save);
        }
    }

}

function convertir_fecha_formato_sql_a_diagonal($fecha) {
    $valores = explode('/', $fecha);
    //dd-mm-aa
    return $valores[2] . '-' . $valores[1] . '-' . $valores[0];
}

function multiexplode($delimiters, $data) {
    $MakeReady = str_replace($delimiters, $delimiters[0], $data);
    $Return = explode($delimiters[0], $MakeReady);
    return $Return;
}

function hora_inicio($horario) {
    $hora_inicio = $this->multiexplode(array('-', 'a'), $horario);
    return $hora_inicio[0];
}

function hora_fin($horario) {
    $hora_fin = $this->multiexplode(array('-', 'a'), $horario);
    return $hora_fin[1];
}

function cambiar_acentos($nombre_comp) {
    $nombre = explode(' ', $nombre_comp);
    return $nombre[0];
}

function nombre($nombre_comp) {
    $nombre = explode(' ', $nombre_comp);
    switch (count($nombre)) {
        case 3:
            return $nombre[0];
            break;
        case 4:
            return $nombre[0] . ' ' . $nombre[1];
            break;
        case 5:
            return $nombre[0] . ' ' . $nombre[1] . ' ' . nombre[2];
            break;
    }
}

function apellido_pat($nombre_comp) {
    $apellido_pat = explode(' ', $nombre_comp);
    switch (count($apellido_pat)) {
        case 3:
            return ($apellido_pat[1]);
            break;
        case 4:
            return ($apellido_pat[2]);
            break;
        case 5:
            return ($apellido_pat[3]);
            break;
    }
}

function apellido_mat($nombre_comp) {
    $apellido_mat = explode(' ', $nombre_comp);
    switch (count($apellido_mat)) {
        case 3:
            return $apellido_mat[2];
            break;
        case 4:
            return $apellido_mat[3];
            break;
        case 5:
            return $apellido_mat[4];
            break;
    }
}

function turno($horario) {
    if ($horario <= 12) {
        return 'Matunio';
    } else {
        return 'vespertino';
    }
}

function asistio($asistio) {
    switch ($asistio) {
        case 'SÍ':
            return '1';
            break;
        case 'NO':
            return '0';
            break;
    }
}
