<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Importar_csv extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('importar_csv_model');
		$this->load->library('csvimport'); 
        //cargamos la libreria html2pdf
        //$this->load->library('html2pdf');
        //$this->load->library('form_validation');
        //cargamos el modelo pdf_model
        $this->load->helper('url'); //agrega base_url
        //$this->load->helper('form');
        //$this->load->library('session');
        //$this->load->model('cursos_alumno_model');
        //$this->load->model('carreras_model');
    }

    public function index() {
        $this->load->view('ccaragon/admin_cargar_csv');
    }

	public function cargar_datos(){
		$result = $this->importar_csv_model->select();
		$output= '
		<h3>Datos importados</h3>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
			<tr>
				<th>No.</th>
				<th>nombre</th>
				<th>no. de trabajador</th>
				<th>Correo Electronico</th>
			</tr>
		
		';
		$count =0; 
		if($result->num_rows()>0){
			foreach($result->result() as $row){
				$count=$count+1;
				$output.='
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->nombre.'</td>
						<td>'.$row->num_cuenta.'</td>
						<td>'.$row->correoelectronico.'</td>
					</tr>
				';
			}
		}else{
			$output.='<tr><td colspan="5" align="center">Datos no disponobles</td></tr>';	 
		}
		$count.='</table> </div>';
		echo $output;
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
        $this->html2pdf->paper('a4', 'landscape');
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
                'fecha_inicio' =>strtoupper( $this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_inicio'])),
                'fecha_fin' => strtoupper($this->convertir_fecha_formato_sql_a_diagonal($alumnos_by_curso[0]['fecha_fin'])),
                'hora_inicio' => date("H:i", strtotime($alumnos_by_curso[0]['hora_inicio'])),
                'hora_fin' => date("H:i", strtotime($alumnos_by_curso[0]['hora_fin'])),
                'alumnos' => $alumnos_by_curso);

            $this->html2pdf->html(utf8_decode($this->load->view('ccaragon/pdf_reporte_por_curso', $data, true)));
            //si el pdf se guarda correctamente lo mostramos en pantalla
            if ($this->html2pdf->create('save')) {
                $this->show();
            }
        } else {
            echo "no hay registros  ";
        }
    }

    public function convertir_fecha_formato_sql_a_diagonal($fecha) {
        $valores = explode('-', $fecha);
        if (count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])) {
            return $valores[2] . '/' . $valores[1] . '/' . $valores[0];
        }
        return FALSE;
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
