<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            @page { margin: 30px 40px 54px 40px }
            #footer {
                position: fixed;
                left: 0px;
                bottom: -180px;
                right: 0px;
                height: 150px;
                background-color: #869791;
                /*color: #fff;*/
                text-align: center;
            }
            #footer .page:after {
                content: counter(page, upper-roman);
            }
        </style>
    </head>
    <body>
        <!--header para cada pagina-->
        <table width="100%" style=' vertical-align: bottom; font-family:serif ; font-size: 12pt;'>
            <tr>
                <td  width="20%"><img src="images/unam.jpg"/></td>
                <td align='center' ><span ><strong > UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO<br/>
                            FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N<br/><br/>
                            </br>
                            </br>
                            <p> CURSOS </p> 
                        </strong> </span></td>
                <td width="20%" align="right"> <img src="images/aragon.png"/></td>
            </tr>
        </table>
        <table width="100%" style=' vertical-align: bottom; font-family:serif ; font-size: 12pt;'>
            <thead style='font-size:10pt; border: 1px solid #00000C'>
                <tr>
                    <td><strong>MATERIA: </strong><?php echo utf8_encode($curso); ?> </td>
                    <td  ><strong>PROFESOR: </strong><?php echo utf8_encode($nombre_profesor); ?></td>
                    <td><strong>TURNO: </strong><?php echo $turno; ?></td>
                </tr>
                <tr>
                    <td><strong>CORREO ELECTRONICO: </strong><?php echo $datos_profesor['correoelectronico']; ?></td>
                    <td  ><strong>PERIODO: </strong><?php echo $fecha_inicio . " A " . $fecha_fin ?></td>
                    <td ><strong>HORARIO: </strong><?php echo $hora_inicio . " A  " . $hora_fin ?></td>
                </tr>
                <tr>
                    <td ><strong>RFC: </strong><?php echo $datos_profesor['rfc']; ?></td>
                    <td  ><strong># ALUMNOS INSCRITOS: </strong> <?php echo $alumnos_inscritos; ?></td>
                </tr>
            </thead>
        </table>
        <!--<p>D A T O S.</p>-->
        <table width="100%" style='padding:10px'>
            <thead style='border-bottom: 1px solid #00000C; font-size: 8pt; '>
                <tr>
                    <th width="5%">NO</th>
                    <th width="30%">NOMBRE COMPLETO</th>
                    <th width="10%">N&Uacute;MERO DE CUENTA</th>
                    <th width="30%">CORREO ELECTRONICO</th>
                    <th width="35%">CARRERA</th>
                </tr>
            </thead>
            <tbody  style=' font-family:monospace; font-size: 10pt;'>
                <?php $i=1; foreach ($alumnos as $alumno) { ?>
                    <tr>
                        <td ><?php echo $i; ?></td>
                        <td ><?php echo utf8_encode(strtoupper($alumno['nombre_alumno'])); ?></td>
                        <td ><?php echo utf8_encode(strtoupper($alumno['num_cuenta'])); ?></td>
                        <td ><?php echo $alumno['correoelectronico']; ?></td>
                        <td ><?php echo $alumno['carrera']; ?></td>

                    </tr>
                    <?php $i++; ?>
                <?php } ?>
            </tbody>
        </table>
        <div id="footer" style="">
            <table style='vertical-align: bottom;  font-size: 8pt;'>
                <tr>
                    <td  align='center' width="350">
                        <strong>UNIDAD DE SISTEMAS Y SERVICIOS EN C&Oacute;MPUTO </strong>
                    </td>                   
                    <td  align='LEFT' width="100">
                        <p class="page">P&Aacute;GINA:</p>
                    </td>                   
                    <td  align='center' width="200">
                        <strong>DEPARTAMENTO DE INFORM&Aacute;TICA </strong>
                    </td>                   
                </tr>
            </table>
        </div>
    </body>
</html>
