<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_reportes_generales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //cargamos la libreria html2pdf
        $this->load->library('html2pdf');
        $this->load->library('form_validation');
        //cargamos el modelo pdf_model
        $this->load->helper('url'); //agrega base_url
        $this->load->helper('html'); //agrega base_url
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('cursos_alumno_model');
        $this->load->model('carreras_model');
        $this->load->model('cursos_model');
    }

    public function index() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('ccaragon/home_reportes_view');
        }
    }

    public function reporte_por_curso_view() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('reportes/admin_reporte_por_curso_view');
        }
    }

    public function reporte_por_division_view() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('reportes/admin_reporte_por_division_view');
        }
    }

    public function reporte_por_asistencia_view() {
        if (!$this->session->userdata('logueado') && $this->session->userdata('tipo_user') != 1) {
            redirect(base_url() . 'index.php/Login');
        } else {
            $this->load->view('reportes/admin_reporte_por_asistencia_view');
        }
    }

    public function generar_pdf_alumnos_by_curso() {
        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
        //importante el slash del final o no funcionar� correctamente
        $this->html2pdf->folder('./files/pdfs/');
        //establecemos el nombre del archivo
        $this->html2pdf->filename('test.pdf');
        //establecemos el tipo de papel
//        $html2pdf = new HTML2PDF('P','A4','da', true, 'UTF-8');
//        $this->html2pdf->paper('a4', 'portrait', 'UTF-8');
        $this->html2pdf->paper('a4', 'landscape', 'UTF-8');

        $alumnos_by_curso = array();
        //obtenemos los datos d ela bd 
        $alumnos_by_curso = $this->cursos_alumno_model->get_alumnos_by_curso($this->input->get('id_curso'));
        if ($alumnos_by_curso) {
            $data = array(
                'nombre_profesor' => strtoupper($alumnos_by_curso[0]['nombre_profesor']),
                'curso' => strtoupper($alumnos_by_curso[0]['curso']),
                'datos_profesor' => $this->cursos_alumno_model->get_correo_elec_by_profesor($alumnos_by_curso[0]['idprofesor']),
                'turno' => strtoupper($alumnos_by_curso[0]['turno']),
                'alumnos_inscritos' => count($alumnos_by_curso),
                'fecha_inicio' => strtoupper($this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_inicio'])),
                'fecha_fin' => strtoupper($this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_fin'])),
                'hora_inicio' => date("H:i", strtotime($alumnos_by_curso[0]['hora_inicio'])),
                'hora_fin' => date("H:i", strtotime($alumnos_by_curso[0]['hora_fin'])),
                'alumnos' => $alumnos_by_curso);

            $this->html2pdf->html(utf8_decode($this->load->view('reportes/pdf_reporte_por_curso', $data, true)));
            //si el pdf se guarda correctamente lo mostramos en pantalla
            if ($this->html2pdf->create('save')) {
                $this->show();
            }
        } else {
            echo "no hay registros  ";
        }
    }

    public function generar_pdf_division() {
        $alumnos_by_division = array();

        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
        //importante el slash del final o no funcionar� correctamente
        $this->html2pdf->folder('./files/pdfs/');
        //establecemos el nombre del archivo
        $this->html2pdf->filename('test.pdf');
        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'landscape', 'UTF-8');
        $carreras = $this->carreras_model->get_carreras();
        $cursos = $this->cursos_model->get_distinc_curso();
        $divisiones = $this->carreras_model->get_divisiones();
//echo '<pre>';
//        print_r($carreras);
//echo '</pre>';
        $nuevo = array();
        $cant_cursos = array();
        $cant_division = array();

        foreach ($carreras as $carrera) {
            foreach ($cursos as $curso) {

                $datas[] = array(
                    'id_carrera' => $carrera['idcarrera'],
                    'carrera' => $carrera['carrera'],
                    'curso' => $curso['curso'],
                    'division' => $carrera['division'],
                    'cantidad' => $this->get_count_by_carrera_curso($carrera['idcarrera'], $curso['curso'], $this->input->get('fecha_inicio'), $this->input->get('fecha_fin')));
            }
        }

//        foreach ($datas as $data) {
//            $id_carreras[] = ["id_carrera" => $data["id_carrera"],'carrera'=>['carrera'], 'cantidad' => $data['cantidad']];
//        }
        //obtenemos los id de evaluacion
//        $id_carreras_unicas= array_uniCque($id_carreras);
//print_r($datas);
        $total = 0;
        $subtotal = 0;
        $subtotal_division = 0;
        foreach ($carreras as $id_carrera_unica) {
            $contador = 0;
            foreach ($datas as $id_carrea) {
                if ($id_carrera_unica['idcarrera'] == $id_carrea['id_carrera']) {
                    $total = $total + $id_carrea['cantidad'];
                    $carrerass = $id_carrea['carrera'];
                    $contador++;
                }
            }
            $ele['total'] = $total;
            $ele['carrera'] = $carrerass;

            array_push($nuevo, $ele);
            $total = 0;
        }
//        ------------------------cursos-----------
        foreach ($cursos as $curso) {
            $cont = 0;
            foreach ($datas as $id_carrea) {
                if ($curso['curso'] == $id_carrea['curso']) {
                    $subtotal = $subtotal + $id_carrea['cantidad'];
                    $carrerass = $id_carrea['curso'];
                    $cont++;
                }
            }
            $curso_cant['total_curso'] = $subtotal;
            $curso_cant['carrera'] = $carrerass;

            array_push($cant_cursos, $curso_cant);
            $subtotal = 0;
        }
//        --------------------division--------------
        foreach ($cursos as $curso) {
            $j = 0;
            foreach ($divisiones as $division) {
                foreach ($datas as $dato) {
                    if (
                            $division['division'] == $dato['division'] &&
                            $curso['curso'] == $dato['curso']
                    ) {
                        $subtotal_division = $subtotal_division + $dato['cantidad'];
                        $division_nombre = $dato['division'];
                        $curso_nom = $dato['curso'];
                        $j++;
                    }
                }
                $division_cant['total_curso'] = $subtotal_division;
                $division_cant['division'] = $division_nombre;
                $division_cant['curso'] = $curso_nom;

                array_push($cant_division, $division_cant);
                $subtotal_division = 0;
            }
        }
//---------------------tabla------------------
        echo '<table style="border:1px solid #00000C" >';
        echo '<tr>';
        echo '<td>area</td>';
        foreach ($cursos as $curso) {
            //                    
            echo '<td>' . $curso['curso'] . '</td>';
        }
        echo '<td>Total</td>';

        echo '</tr>';

        $dato = 1;

        for ($car = 0; $car < count($carreras); $car++) {
//            if ($carreras[$car]['division'] == 'División de Ciencias Sociales') {

            if ($carreras[$car]['division'] != $carreras[$car - 1]['division']) {

                echo "<tr>";
                echo "<td colspan='4' style='text-align:right;'>" . $carreras[$car]['division'] . "</td>";
                echo "</tr>";
            }
            echo '<tr>';
            echo '<td>' . ($car + 1) . '-' . $carreras[$car]['carrera'] . '</td>';
            for ($cur = 0; $cur < count($cursos); $cur++) {
                for ($dat = 0; $dat < count($datas); $dat++) {
                    if (($carreras[$car]['carrera'] == $datas[$dat]['carrera']) &&
                            ($cursos[$cur]['curso'] == $datas[$dat]['curso'])) {
                        echo '<td>' . $datas[$dat]['cantidad'] . '</td>';
                    }
                }
            }


//            for ($n = 0; $n < count($nuevo); $n++) {
//                    echo '<td>' . 's' . '</td>';
            if ($carreras[$car]['carrera'] == $nuevo[$car]['carrera']) {
                echo '<td>';

                echo $nuevo[$car]['total'];
                echo '</td>';
//            }
            }
        }
        echo '</tr>';
        echo '<tr>';
        echo '<td>total</td>';
        echo '</tr>';
        echo '</table>';

//        if ($alumnos_by_curso) {
//                'curso' => strtoupper($alumnos_by_curso[0]['curso']),
//                'datos_profesor' => $this->cursos_alumno_model->get_correo_elec_by_profesor($alumnos_by_curso[0]['idprofesor']),
//                'turno' => strtoupper($alumnos_by_curso[0]['turno']),
//                'alumnos_inscritos' => count($alumnos_by_curso),
//                'fecha_inicio' => strtoupper($this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_inicio'])),
//                'fecha_fin' => strtoupper($this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_fin'])),
//                'hora_inicio' => date("H:i", strtotime($alumnos_by_curso[0]['hora_inicio'])),
//                'hora_fin' => date("H:i", strtotime($alumnos_by_curso[0]['hora_fin'])),
//                'alumnos' => $alumnos_by_curso);
//            $this->html2pdf->html(utf8_decode($this->load->view("reportes/pdf_reporte_por_division",
//                    array('datos'=>$alumnos_by_division), true)));
//            if ($this->html2pdf->create('save')) {
//                $this->show();
//            
//        } else {
//            echo "no hay registros  ";
//        }
    }

    public function reporte_por_division() {
        $alumnos_by_division = array();
        $carreras = $this->carreras_model->get_carreras();
        $cursos = $this->cursos_model->get_distinc_curso();
        $divisiones = $this->carreras_model->get_divisiones();
//echo '<pre>';
//        print_r($carreras);
//echo '</pre>';
        $nuevo = array();
        $cant_cursos = array();
        $cant_division = array();

        foreach ($carreras as $carrera) {
            foreach ($cursos as $curso) {

                $datas[] = array(
                    'id_carrera' => $carrera['idcarrera'],
                    'carrera' => $carrera['carrera'],
                    'curso' => $curso['curso'],
                    'division' => $carrera['division'],
                    'cantidad' => $this->get_count_by_carrera_curso($carrera['idcarrera'], $curso['curso'], $this->input->get('fecha_inicio'), $this->input->get('fecha_fin')
                ));
            }
        }
        $total = 0;
        $subtotal = 0;
        $subtotal_division = 0;
        foreach ($carreras as $id_carrera_unica) {
            $contador = 0;
            foreach ($datas as $id_carrea) {
                if ($id_carrera_unica['idcarrera'] == $id_carrea['id_carrera']) {
                    $total = $total + $id_carrea['cantidad'];
                    $carrerass = $id_carrea['carrera'];
                    $contador++;
                }
            }
            $ele['total'] = $total;
            $ele['carrera'] = $carrerass;

            array_push($nuevo, $ele);
            $total = 0;
        }
//        ------------------------cursos-----------
        foreach ($cursos as $curso) {
            $cont = 0;
            foreach ($datas as $id_carrea) {
                if ($curso['curso'] == $id_carrea['curso']) {
                    $subtotal = $subtotal + $id_carrea['cantidad'];
                    $carrerass = $id_carrea['curso'];
                    $cont++;
                }
            }
            $curso_cant['total_curso'] = $subtotal;
            $curso_cant['carrera'] = $carrerass;

            array_push($cant_cursos, $curso_cant);
            $subtotal = 0;
        }
//        --------------------division--------------
        foreach ($cursos as $curso) {
            $j = 0;
            foreach ($divisiones as $division) {
                foreach ($datas as $dato) {
                    if (
                            $division['division'] == $dato['division'] &&
                            $curso['curso'] == $dato['curso']
                    ) {
                        $subtotal_division = $subtotal_division + $dato['cantidad'];
                        $division_nombre = $dato['division'];
                        $curso_nom = $dato['curso'];
                        $j++;
                    }
                }
                $division_cant['total_curso'] = $subtotal_division;
                $division_cant['division'] = $division_nombre;
                $division_cant['curso'] = $curso_nom;

                array_push($cant_division, $division_cant);
                $subtotal_division = 0;
            }
        }

        $tabla = '';

        $tabla .= '<table class="table table-striped text-left ">';
        $tabla .= '<thead>';
        $tabla .= '<tr>';
//        $tabla.='<th rowspan="2"rowspan="2">carrera</th>';
        $tabla .= '<th class="table-primary" style="vertical-align:top">Carrera\Curso  </th>';
        foreach ($cursos as $curso) {
            $tabla .= '<th  class="table-primary" style="vertical-align:top">' . $curso['curso'] . '</th>';
        }
        $tabla .= '<th class="table-primary" style="vertical-align:top">Total</th>';

        $tabla .= '</tr>';
        $tabla .= '</thead>';
        $tabla .= '</tbody>';

        $dato = 1;
        $total_inscritos = 0;

        for ($car = 0; $car < count($carreras); $car++) {
//
//                echo "<tr>";
//                echo "<td colspan='4' style='text-align:right;'>" . $carreras[$car]['division'] . "</td>";
//                echo "</tr>";
//            }
            $tabla .= '<tr>';
            $tabla .= '<td class="table-primary">' . $carreras[$car]['carrera'] . '</td>';
            for ($cur = 0; $cur < count($cursos); $cur++) {
                for ($dat = 0; $dat < count($datas); $dat++) {
                    if (($carreras[$car]['carrera'] == $datas[$dat]['carrera']) &&
                            ($cursos[$cur]['curso'] == $datas[$dat]['curso'])) {
                        $tabla .= '<td>' . $datas[$dat]['cantidad'] . '</td>';
                    }
                }
            }


//            for ($n = 0; $n < count($nuevo); $n++) {
//                    echo '<td>' . 's' . '</td>';
            if ($carreras[$car]['carrera'] == $nuevo[$car]['carrera']) {
                $total_inscritos += $nuevo[$car]['total'];

                $tabla .= '<td>';

                $tabla .= $nuevo[$car]['total'];
                $tabla .= '</td>';
//            }
            }
        }
        $tabla .= '</tr>';
//        $tabla .= '<tr>';
//
//            for ($dat = 0; $dat < count($datas); $dat++) {
//        for ($cur = 0; $cur < count($cursos); $cur++) {
//                $total_inscritos += $datas[$dat]['cantidad'];
//
//                $tabla .= '<td>' .$total_inscritos . '</td>';   $tabla .= '<tr>';
        $tabla .= ' <td colspan="6" style="text-align:right;   font-size: 12pt;"> <strong>TOTAL:</strong> </td>';
        $tabla .= ' <td>';
        $tabla .= $total_inscritos;
        $tabla .= ' </td>';
     
//            }
//        }
//        $tabla .= '</tr>';
//                        $tabla .= '<td>' .  $carreras[$car]['carrera']. '</td>';
        $tabla .= '<tr>';
        $tabla .= ' <td colspan="6" style="text-align:right;   font-size: 12pt;"> <strong>TOTAL:</strong> </td>';
        $tabla .= ' <td>';
        $tabla .= $total_inscritos;
        $tabla .= ' </td>';
        $tabla .= '</tr>';
        $tabla .= '</tbody>';
        $tabla .= '</table>';
        echo $tabla;

//---------------------tabla------------------
    }

    public function generar_pdf_asistencia() {
        $alumnos_by_division = array();

        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
        //importante el slash del final o no funcionar� correctamente
        $this->html2pdf->folder('./files/pdfs/');
        //establecemos el nombre del archivo
        $this->html2pdf->filename('test.pdf');
        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'landscape', 'UTF-8');
        $datas = $this->cursos_alumno_model->get_alumnos_by_asistencia_curso();
        if ($datas) {
//            print_r($datas);
//
            $this->html2pdf->html(utf8_decode($this->load->view('reportes/pdf_reporte_por_asistencia', array('datas' => $datas), true)));
            //si el pdf se guarda correctamente lo mostramos en pantalla
            if ($this->html2pdf->create('save')) {
                $this->show();
            }
        } else {
            echo "no hay registros  ";
        }
//echo '<pre>';
//        print_r($datas);
//echo '</pre>';
    }

    public function convertir_fecha_formato_sql_a_diagonal($fecha) {
        $valores = explode('-', $fecha);
        if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
            return $valores[2] . '/' . $valores[1] . '/' . $valores[0];
        }
        return FALSE;
    }

    public function get_count_by_carrera_curso($idcarrera, $curso, $fecha_inicio, $fecha_fin) {
        $cantidad = $this->cursos_alumno_model->get_count_by_carrera_curso(
                $idcarrera, $curso, $fecha_inicio, $fecha_fin);
        if ($cantidad > 0) {
            return $cantidad[0]['cantidad'];
        } else {
            return 0;
        }
    }

    public function get_mes_texto($mes_numero) {
//                $arreglo_meses = ["01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL", "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO", "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE"];


        switch ($mes_numero) {
            case '01':
                $mes_numero = "ENERO";
                break;
            case '02':
                $mes_numero = "FEBRERO";
                break;
            case '03':
                $mes_numero = "MARZO";
                break;
            case '04':
                $mes_numero = "ABRIL";
                break;
            case '05':
                $mes_numero = "MAYO";
                break;
            case '06':
                $mes_numero = "JUNIO";
                break;
            case '07':
                $mes_numero = "JULIO";
                break;
            case '08':
                $mes_numero = "AGOSTO";
                break;

            case '09':
                $mes_numero = "SEPTIEMBRE";
                break;

            case '10':
                $mes_numero = "OCTUBRE";
                break;

            case '11':
                $mes_numero = "NOVIEMBRE";
                break;

            case '12':
                $mes_numero = "DICIEMBRE";
                break;
        }
        return $mes_numero;


//        $fecha= explode(' ', $fecha_completa);
//        
//        $fecha_com=  explode('-');
//        return $fecha;
    }

//    ---------------------------------F UN CIONES GENERALES PARA PDF----------------
    private function createFolder() {
        if (!is_dir("./files")) {
            mkdir("./files", 0777);
            mkdir("./files/pdfs", 0777);
        }
    }

    public function downloadPdf() {
        //si existe el directorio
        if (is_dir("./files/pdfs")) {
            //ruta completa al archivo
            $route = base_url("files/pdfs/test.pdf");
            //nombre del archivo
            $filename = "test.pdf";
            //si existe el archivo empezamos la descarga del pdf
            if (file_exists("./files/pdfs/" . $filename)) {
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header('Content-disposition: attachment; filename=' . basename($route));
                header("Content-Type: application/pdf");
                header("Content-Transfer-Encoding: binary");
                header('Content-Length: ' . filesize($route));
                readfile($route);
            }
        }
    }

    //función para crear y enviar el pdf por email
    //ejemplo de la libreria sin modificar
    public function mail_pdf() {

        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();

        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./files/pdfs/');

        //establecemos el nombre del archivo
        $this->html2pdf->filename('test.pdf');

        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'portrait');

        //datos que queremos enviar a la vista, lo mismo de siempre
        $data = array(
            'title' => 'Listado de las provincias españolas en pdf',
            'provincias' => $this->pdf_model->getProvincias()
        );

        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $this->html2pdf->html(utf8_decode($this->load->view('reporte_individual', $data, true)));


        //Check that the PDF was created before we send it
        if ($path = $this->html2pdf->create('save')) {

            $this->load->library('email');

            $this->email->from('your@example.com', 'Your Name');
            $this->email->to('israel965@yahoo.es');

            $this->email->subject('Email PDF Test');
            $this->email->message('Testing the email a freshly created PDF');

            $this->email->attach($path);

            $this->email->send();

            echo "El email ha sido enviado correctamente";
        }
    }

    //esta función muestra el pdf en el navegador siempre que existan
    //tanto la carpeta como el archivo pdf
    public function show() {
        if (is_dir("./files/pdfs")) {
            $filename = "test.pdf";
            $route = ("http://localhost/cursos/files/pdfs/test.pdf");
            if (file_exists("./files/pdfs/" . $filename)) {
                header('Content-type: application/pdf');
                readfile($route);
            }
        }
    }

}
