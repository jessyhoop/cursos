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
                            <p> REPORTE ASISTENCIA DE ALUMNOS POR CURSO </p> 
                        </strong> </span></td>
                <td width="20%" align="right"> <img src="images/aragon.png"/></td>
            </tr>
        </table>
        <table width="100%" style=' vertical-align: bottom; font-family:serif ; font-size: 12pt;'>
        </table>
        <!--<p>D A T O S.</p>-->
        <div>
            <table width="100%" style='padding:10px'>
                <thead style='border-bottom: 1px solid #00000C; font-size: 8pt; '>
                    <tr>
                        <th width='5%'>No</th>
                        <th width='30%'>CURSO</th>
                        <th width='20%'>PROFESOR</th>
                        <th width='20%'>P&Eacute;RIODO</th>
                        <th width='10%'> HORARIO</th>
                        <th width='10%'> TOTAL INSCRITOS</th>
                        <th width='5%' style="text-align:left">CURSARON</th>
                        <!--<th width='5%'>NO <br>CURSARON</th>-->
                    </tr>
                </thead>
                <tbody  style=' font-family:monospace; font-size: 10pt;'>
                    <?php
                    $cont = 1;
                    $total_cursaron = 0;
                    $total_inscritos = 0;
                    foreach ($datas as $data) {
                        $total_inscritos += $data['total_inscritos'];
                        $total_cursaron += $data['cursaron'];
                        ?>
                        <tr>
                            <td ><?php echo $cont; ?></td>
                            <td ><?php echo utf8_encode($data['curso']); ?></td>
                            <td ><?php echo utf8_encode($data['nombre_profesor']); ?></td>
                            <td ><?php echo $data['periodo']; ?></td>
                            <td ><?php echo $data['horario']; ?></td>
                            <td ><?php echo $data['total_inscritos']; ?></td>
                            <td ><?php echo $data['cursaron']; ?></td>
                            <!--<td ><?php // echo $data['no_cursaron'];   ?></td>-->
                        </tr>
                        <?php $cont++;
                        ?>
                    <?php } ?>
                    <tr>
                        <td colspan="5" style="text-align:right;   font-size: 12pt;"> <strong>TOTAL:</strong> </td>
                        <td> <?php echo $total_inscritos; ?> </td>
                        <td> <?php echo $total_cursaron; ?> </td>
                    <tr>
                </tbody>
            </table>
        </div>
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
