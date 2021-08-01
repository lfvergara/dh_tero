var map;
var lat;
var lon;
var zoom;
var poligonos = [];
var indice_poligonos = 0;
var indice_seleccion = 0;
var coordenadas_mapa_lat = -29.4156342;
var coordenadas_mapa_lon = -66.8679657;
var herramientasGraficas = ['polygon'];

class Poligono {
    constructor(indice, nombre, fillColor, strokeColor, coordenadas) {
        this.indice = indice;
        this.fillColor = fillColor;
        this.strokeColor = strokeColor;
        this.nombre = nombre;
        this.coordenadas = coordenadas;
    }
}

var drawingManager;
var shapeSeleccionado;
var colores = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082','#FA8258','#9FF781','#2E2E2E','#013ADF','#FFFF00','#86B404','#FF0000','#00FFFF'];
var colorSeleccionado;
var colorButtons = {};

function borrarSeleccion() {
    if (shapeSeleccionado) {
        shapeSeleccionado.setEditable(false);
        shapeSeleccionado = null;
    }
}

function setSeleccion(shape) {
    borrarSeleccion();
    shapeSeleccionado = shape;
    shape.setEditable(true);
    selectColor(shape.get('fillColor') || shape.get('strokeColor'));
}

function borrarShape() {
    if (shapeSeleccionado) {
        if (shapeSeleccionado.type == 'polygon') {
            borrarArray(poligonos, indice_seleccion);
            // indice_poligonos = indice_poligonos - 1;
        }
        
        shapeSeleccionado.setMap(null);
    }
}

function borrarArray(array, indice) {
    for (var i = 0; i < array.length; i++) {
        if (array[i].indice === indice) {
            array.splice(i, 1);
        }
    }
}

function selectColor(color) {
    colorSeleccionado = color;
    for (var i = 0; i < colores.length; ++i) {
        var currColor = colores[i];
        colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
    }

    var polygonOptions = drawingManager.get('polygonOptions');
    polygonOptions.fillColor = color;
    polygonOptions.trokeColor = color;
    drawingManager.set('polygonOptions', polygonOptions);
}

function setSelectedShapeColor(color) {
    if (shapeSeleccionado) {
        shapeSeleccionado.set('fillColor', color);
        shapeSeleccionado.set('strokeColor', color);
        editar(shapeSeleccionado);
    }
}

function makeColorButton(color) {
    var button = document.createElement('span');
    button.className = 'color-button';
    button.style.backgroundColor = color;
    google.maps.event.addDomListener(button, 'click', function() {
        selectColor(color);
        setSelectedShapeColor(color);
    });
    return button;
}

function buildColorPalette() {
    var colorPalette = document.getElementById('color-palette');
    for (var i = 0; i < colores.length; ++i) {
        var currColor = colores[i];
        var colorButton = makeColorButton(currColor);
        colorPalette.appendChild(colorButton);
        colorButtons[currColor] = colorButton;
    }
    selectColor(colores[0]);
}

function editar(e) {
    if (e.type == 'polygon') {
        var path = e.getPath();
        var seleccionado = poligonos[indice_seleccion];
        var nombre = seleccionado.nombre;
        poligonos[indice_seleccion] = getPoligono(path, e.get('fillColor'), e.get('strokeColor'),nombre);
    }
}

function getPoligono(path, fillColor, strokeColor,nombre) {
    var coordenadas = [];
    for (var i = 0; i < path.length; i++) {
        coordenadas.push({
            lat: path.getAt(i).lat(),
            lng: path.getAt(i).lng()
        });
    }
    var pol = new Poligono(indice_poligonos, nombre, fillColor, strokeColor, coordenadas);
    return pol;
}

function iniMapa() {
    map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 14,
        center: new google.maps.LatLng(coordenadas_mapa_lat, coordenadas_mapa_lon),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        zoomControl: true
    });
    var OptionsPolyRec = {
        strokeWeight: 0,
        fillOpacity: 0.45,
        editable: true,
        draggable: true
    };
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: herramientasGraficas
        },
        polygonOptions: OptionsPolyRec,
        map: map
    });
    google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
		var dragging = false;
        drawingManager.setDrawingMode(null);
        var newShape = e.overlay;
        newShape.type = e.type;
        agregar(e);
        google.maps.event.addListener(newShape, 'dragend', function() {
            editar(newShape);
        });
		google.maps.event.addListener(newShape, 'mousedown', function(mdEvent) {
    		if(mdEvent.vertex || (mdEvent.vertex == 0)){
				dragging = true;
			}
		});
		google.maps.event.addListener(newShape, 'mouseup', function(muEvent) {
			dragging = false;
		});
		google.maps.event.addListener(newShape, 'mousemove', function(mmEvent) {
			if(dragging){
				editar(newShape);
			}
		});
		google.maps.event.addListener(newShape, 'click', function() {
            indice_seleccion = newShape.zIndex;
            setSeleccion(newShape);
        });
        setSeleccion(newShape);
    });
    google.maps.event.addListener(drawingManager, 'drawingmode_changed', borrarSeleccion);
    google.maps.event.addListener(mapa, 'click', borrarSeleccion);
    google.maps.event.addDomListener(document.getElementById('borrar-boton'), 'click', borrarShape);
    buildColorPalette();

    function agregar(e) {
        if (e.type == 'polygon') {
            var path = e.overlay.getPath();
	        var nombre = prompt('Etiqueta del Poligono');

            if(nombre === undefined || nombre === "") {
                nombre = "Etiqueta no definido";
            }

            poligonos.push(getPoligono(path, e.overlay.get('fillColor'), e.overlay.get('strokeColor'),nombre));
            indice_poligonos++;
        }
    }

}
  
google.maps.event.addDomListener(window, 'load', iniMapa);
$(document).ready(function() {
	var bton = document.querySelector('#seleccionarcolor');
	var picker = new Picker(bton);
	picker.onDone = function(color) {
		selectColor(color.hex());
		setSelectedShapeColor(color.hex());
	};
});

function obtenerCoordenadas(){
    var zoomcenter = map.getZoom();
    var latitudcenter = map.getCenter().lat();
    var longitudcenter = map.getCenter().lng();
    guardarBarrio(zoomcenter,latitudcenter,longitudcenter);
}
