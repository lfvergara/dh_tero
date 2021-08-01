function enviarWhatsapp(idmantenimiento){
	var a = jQuery.noConflict();
	var host = "http://"+window.location.hostname;
	var urlmapa = host + urlMjson + 'wsp_coordenadas/' + idmantenimiento;
    var consultaMantenimiento = a.ajax({
        url: urlMjson + 'wsp_consultar/' + idmantenimiento,
        dataType: 'text',
        async: false
    }).responseText;
	var mantenimiento = JSON.parse(consultaMantenimiento);
	var slinea_web = '%0A';
	var slinea_movil = "\n";
	var url = "";
	var slinea = "";
	if (isMobile()){
		slinea =slinea_movil;
		var mensaje = crearMensaje(mantenimiento,slinea,urlmapa);
		url = 'whatsapp://send?text=' + window.encodeURIComponent(mensaje);
	}
	else{
		slinea =slinea_web;
		var mensaje = crearMensaje(mantenimiento,slinea,urlmapa);
		url = 'https://web.whatsapp.com/send?text=' + mensaje;
	}
    window.open(url, '_blank');
}

function isnula(texto){
	var ret = "";
	if (typeof texto != 'undefined'){
		ret = texto;
	}
	return ret;
}

function crearMensaje(mantenimiento,slinea,urlmapa){
	var mensaje = '⚠Mantenimineto Preventivo⚠ ' + slinea;
	mensaje = mensaje + '▪Motivo: ' + isnula(mantenimiento.motivo) + ' ' + slinea;
	mensaje = mensaje + '▪Número EUCOP: ' + isnula(mantenimiento.numero_eucop) + ' ' + slinea;
	mensaje = mensaje + '▪Inicio: ' + isnula(mantenimiento.fecha_inicio) + ' a las ' + isnula(mantenimiento.hora_inicio) + ' ' + slinea;
	mensaje = mensaje + '▪Fin: ' + isnula(mantenimiento.fecha_inicio) + ' a las ' + isnula(mantenimiento.hora_fin) + ' ' + slinea;
	mensaje = mensaje + '▪Descripción: ' + isnula(mantenimiento.descripcion) + ' ' + slinea;
	mensaje = mensaje + '▪Reponsable Edelar: ' + isnula(mantenimiento.responsable_edelar) + ' ' + slinea;
	mensaje = mensaje + '▪Reponsable Contratista: ' + isnula(mantenimiento.responsable_contratista) + ' ' + slinea;
	mensaje = mensaje + '▪Sector: ' + isnula(mantenimiento.sector) + ' ' + slinea;
	mensaje = mensaje + '▪Calles: ' + isnula(mantenimiento.calles) + ' ' + slinea + slinea;
	if (mantenimiento.haycord){
		mensaje = mensaje + "🗺Mapa " + slinea + urlmapa;
	}
	else{
		mensaje = mensaje + "🗺Mapa " + slinea + "Sin georeferencia";
	}
	return mensaje;
}

function isMobile() {
  try{ document.createEvent("TouchEvent"); return true; }
  catch(e){ return false; }
}