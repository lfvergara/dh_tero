<?php
require_once 'common/libs/PHPMailer/class.phpmailer.php';
require_once 'common/libs/domPDF/dompdf_config.inc.php';
//require_once 'common/libs/PHPMandrill/src/Mandrill.php';


class EmailHelper extends View {
        /*
	public function envia_contacto($array_dict) {
                $gui = file_get_contents("static/common/contacto.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($array_dict, $gui);
                $gui = $this->render($fecha_descompuesta, $gui);

                $origen = "autogestion@edelar.com.ar";
                $nombre = "EDELAR: Consultas y Contactos";
                $destino = "contactoweb.edelar@emdersa.com.ar";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress($destino);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($nombre);
                $mail->Body = $gui;

                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
	}

        public function envia_curriculum($array_dict) {
                $gui = file_get_contents("static/common/curriculum.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($array_dict, $gui);
                $gui = $this->render($fecha_descompuesta, $gui);

                $origen = "autogestion@edelar.com.ar";
                $nombre = "EDELAR: Servicio de CV";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress("jmiranday.edelar@emdersa.com.ar");
								$mail->AddAddress("mzucal.edelar@emdersa.com.ar");
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($nombre);
                $mail->Body = $gui;

                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
        }

        public function envia_activacion($correoelectronico, $nueva_contrasena, $clave_activacion) {
                $gui = file_get_contents("static/common/activacion.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($fecha_descompuesta, $gui);
                $gui = str_replace('{nueva_contrasena}', $nueva_contrasena, $gui);
                $gui = str_replace('{clave_activacion}', $clave_activacion, $gui);
                $gui = str_replace('{correoelectronico}', $correoelectronico, $gui);
                $origen = "autogestion@edelar.com.ar";
                $nombre = "EDELAR: Activar cuenta";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress($correoelectronico);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($nombre);
                $mail->Body = $gui;

                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
        }

        public function envia_recupera_contrasena($correoelectronico, $nueva_contrasena) {
                $gui = file_get_contents("static/common/recupera_contrasena.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($fecha_descompuesta, $gui);
                $gui = str_replace('{nueva_contrasena}', $nueva_contrasena, $gui);
                $origen = "autogestion@edelar.com.ar";
                $nombre = "EDELAR: Servicio de CV, Consultas y Contactos";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress($correoelectronico);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($nombre);
                $mail->Body = $gui;

                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
        }
        */

        public function envia_informe_mantenimientopreventivo($array_correos, $obj_mantenimientopreventivo) {
                $gui = file_get_contents("static/common/mailing/mantenimientopreventivo.html");
                $gui_pdf = file_get_contents("static/common/mailing/mantenimientopreventivo_pdf.html");

                $mantenimientopreventivo_id = $obj_mantenimientopreventivo->mantenimientopreventivo_id;
                $numero_eucop = str_replace('/', '_', $obj_mantenimientopreventivo->numero_eucop);
                $fecha_formato = $obj_mantenimientopreventivo->fecha_inicio;
                $departamentos = $obj_mantenimientopreventivo->departamentos;
                $obj_mantenimientopreventivo = $this->set_dict($obj_mantenimientopreventivo);
                $fecha_descompuesta = $this->descomponer_fecha();
                $fecha_descompuesta['{fecha_dia_semana}'] = utf8_decode($fecha_descompuesta['{fecha_dia_semana}']);

                $gui_pdf = $this->render($fecha_descompuesta, $gui_pdf);
                $gui_pdf = $this->render($obj_mantenimientopreventivo, $gui_pdf);
                $dia_actual = date('d');
                $mes_actual = date('m');
                $anio_actual = date('Y');

                $nombre_PDF = "PrensaCP-{$dia_actual}{$mes_actual}{$anio_actual}-{$numero_eucop}";
                $directorio = URL_PRIVATE . "mantenimientopreventivo/";
                if(!file_exists($directorio)) {
                        mkdir($directorio);
                        chmod($directorio, 0777);
                }

                $archivo = URL_PRIVATE . "mantenimientopreventivo/{$mantenimientopreventivo_id}";
                $output = $nombre_PDF . ".pdf";
                $mipdf = new DOMPDF();
                $mipdf ->set_paper("A4", "portrait");
                $mipdf ->load_html($gui_pdf);
                $mipdf->render();
                $pdfoutput = $mipdf->output();
                $filename = $output;
                $fp = fopen($archivo, "a");
                fwrite($fp, $pdfoutput);
                fclose($fp);
                $informe = $nombre_PDF . ".pdf";

                $asunto = "[{$numero_eucop}] Incidencia Programada: Dia {$fecha_formato}. - Dptos. {$departamentos}";
                $asunto = substr(utf8_decode($asunto), 0, 150);
                $gui = $this->render($obj_mantenimientopreventivo, $gui);
                $gui = $this->render($fecha_descompuesta, $gui);

                $origen = "incidencias-programadas@edelar.com.ar";
                $nombre = "EDELAR: Servicio de Incidencias Programadas";
                print_r($gui);
                exit;
                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                foreach ($array_correos as $correo) $mail->AddAddress($correo);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_encode($asunto);
                $mail->Body = $gui;
                $mail->AddAttachment($archivo, $informe);
                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
        }

        /*
	public function envia_turnoweb($correoelectronico,$documento,$numero,$fecha,$hora,$gestion,$oficina,$direccion) {
                $gui = file_get_contents("static/common/turnoweb.html");
                $fecha_descompuesta = $this->descomponer_fecha();
                $gui = $this->render($fecha_descompuesta, $gui);
                $gui = str_replace('{documento}', $documento, $gui);
                $gui = str_replace('{numero}', $numero, $gui);
                $gui = str_replace('{fecha}', $fecha, $gui);
		$gui = str_replace('{hora}', $hora, $gui);
		$gui = str_replace('{gestion}', $gestion, $gui);
		$gui = str_replace('{oficina}', $oficina, $gui);
		$gui = str_replace('{direccion}', $direccion, $gui);
                $origen = "autogestion@edelar.com.ar";
                $nombre = "EDELAR: Turno Web";

                $mail = new PHPMailer();
                $mail->From = $origen;
                $mail->FromName = $nombre;
                $mail->AddAddress($correoelectronico);
                $mail->AddReplyTo($origen);
                $mail->IsHTML(true);
                $mail->Subject = utf8_decode($nombre);
                $mail->Body = $gui;

                $mail->IsSMTP();
                $mail->Host = "smtp.mandrillapp.com";
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = "grodriguez.edelar@gmail.com";
                $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
                $mail->Send();
        }

	public function envia_turnoweb_confirmacion($correoelectronico,$token) {
					$gui = file_get_contents("static/common/turnowebconfirmacion.html");
					$fecha_descompuesta = $this->descomponer_fecha();
					$gui = $this->render($fecha_descompuesta, $gui);
					$gui = str_replace('{token}', $token, $gui);
					$origen = "autogestion@edelar.com.ar";
					$nombre = "EDELAR: Turno Web";
					print_r($gui);exit();
					// $mail = new PHPMailer();
					// $mail->From = $origen;
					// $mail->FromName = $nombre;
					// $mail->AddAddress($correoelectronico);
					// $mail->AddReplyTo($origen);
					// $mail->IsHTML(true);
					// $mail->Subject = utf8_decode($nombre);
					// $mail->Body = $gui;
					//
					// $mail->IsSMTP();
					// $mail->Host = "smtp.mandrillapp.com";
					// $mail->SMTPAuth = true;
					// $mail->Port = 2525;
					// $mail->Username = "grodriguez.edelar@gmail.com";
					// $mail->Password = "qgKWZFp15HWJQ1sMa5sd6Q";
					// $mail->Send();
	}

	public function envia_prueba(){
		$apikey = 'j2cBvcOwJFF7XuaXjFuzRA';
		$mandrill = new Mandrill($apikey);

		$message = new stdClass();
		$message->html = "PRUEBA";
		$message->text = "PRUEBA";
		$message->subject = "PRUEBA";
		$message->from_email = "drgalvan.edelar@emdersa.com.ar";
		$message->from_name  = "PRUEBA";//Nombre del remitente
		$message->to = array( array( "email" => "drgalvan.edelar@emdersa.com.ar") );
		$message->track_opens = true;

		$response = $mandrill->messages->send($message);

		return $response;
	}
        */
}
?>