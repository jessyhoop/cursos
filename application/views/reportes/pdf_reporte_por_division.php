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
                <!--<td  width="20%"><img src="images/unam.jpg"/></td>-->
                <td align='center' ><span ><strong > UNIVERSIDAD NACIONAL AUT&Oacute;NOMA DE M&Eacute;XICO<br/>
                            FACULTAD DE ESTUDIOS SUPERIORES ARAG&Oacute;N<br/><br/>
                            </br>
                            </br>
                            <p> CURSOS </p> 
                        </strong> </span></td>
                <!--<td width="20%" align="right"> <img src="images/aragon.png"/></td>-->
            </tr>
        </table>
        <table width="100%" style=' vertical-align: bottom; font-family:serif ; font-size: 12pt;'>
        </table>
        <!--<p>D A T O S.</p>-->
        <div>
            <?php

            function unique_multidim_array($array, $key) {
                $temp_array = array();
                $i = 0;
                $key_array = array();

                foreach ($array as $val) {
                    if (!in_array($val[$key], $key_array)) {
                        $key_array[$i] = $val[$key];
                        $temp_array[$i] = $val;
                    }
                    $i++;
                }
                return $temp_array;
            }

            $cursos = unique_multidim_array(($datos), 'curso');
            $carrera = unique_multidim_array(($datos), 'carrera');
//          print_r($carrera);

            echo '<pre>';
//            print_r($datos);
            echo '</pre>';
//            echo '<tr>';
//            foreach ($cursos as $value) {
//                echo '<th>' . $value['curso'] . '</th>';
//            }
//            echo '</tr>';
$index=0;
            echo '<table>';
            foreach ($carrera as $value) {
             echo '<tr>';
            foreach ($cursos as $vaue) {
                    
                echo '<td>' . $datos[$index]['carrera'] . '</td>';
                echo '<td>' . $datos[$index]['cantidad'] . '</td>';    
            
            }
             echo '</tr>';
                $index++;
             }
           
            echo '</table>';

//
////            
//            for ($index = 0 ; $index < count($datos); $index++) {
//                echo '<button>' . $datos[$index]['cantidad'] .'</button>';
//                if ($index%4 == 0) {
//                    echo '-';
//                }
//            }
//            echo '<table>';
//                echo '<tr>';
//                    for ($index = 0; $index < count($datos); $index++) {
//                        //                    
//                        echo '<td>' . $datos[$index]['cantidad'] . '</td>';
//            }
//                echo '</tr>';
//            echo '</table>';


            //
            //                for ($index = 0; $index < count($datos); $index++) {
            //                    
            //                echo  $index.'.' .$datos[$index]['cantidad'] ;
            //                    if($valor%5==0){
            //                        echo 'd';   
            //                    }
            //            }
            //                                    for ($index = 0; $index < count(($datos)); $index++) {
            //                                    }
            ?>
<!--            <table width="100%"
                   >
                <thead style='

                       border:1px solid #00000C'>
                    <tr>
                        <th>Area</th>;
<?php ?>


                    </tr>
                </thead>
                <tbody>
<?php
//foreach ($carrera as $value) {
//
//
//    echo
//    '                    <tr>
//<td>' . $dato = utf8_encode($value['carrera']) . '</td>'
?>


            <?php
//                    foreach ($datos as $datoo){
//                        if($dato==utf8_encode($datoo['carrera'])){
//                    echo            '<td> 9</td>';
//                    
//                        }else{
//                    echo            '<td> 9</td>';
//                            
//                            
////                        }
//                    }
//                    
//                                echo  '</tr>';
//                        }
//}
            ?>

                </tbody>
            </table>-->

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
