var BlitzMap = new function() {
	var mapObj, mapOptions, infWindow;
	var mapOverlays = new Array();
	var isEditable = false;
	var mapContainerId, sideBar, mapDiv, mapStorageId;

  	//PARA INICIAR Y GRAFICAR POLIGONO
	this.init = function() {

		var mapOptions = {
			center: new google.maps.LatLng( 19.006295, 73.309021 ),
			zoom: 4,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};

	  	infWindow = new google.maps.InfoWindow();

		if( isEditable ) {
			//PERMITE CREAR UN NUEVO POLIGONO
			drwManager = new google.maps.drawing.DrawingManager({
				drawingControl: true,
				drawingControlOptions: {
					position: google.maps.ControlPosition.TOP_CENTER,
					drawingModes: [
						google.maps.drawing.OverlayType.POLYGON
					]
				},
   				polygonOptions: { editable: true },
			});
		}

		if( mapDiv ) {
			mapObj = new google.maps.Map( mapDiv, mapOptions );
			infWindow.setMap( mapObj );
			if( isEditable ) {
				drwManager.setMap( mapObj );
				google.maps.event.addListener( drwManager, "overlaycomplete", overlayDone );
			}

			if( mapStorageId ) {
				//SE DIBUJA EL MAPA CON DATOS CARGADOS
				setMapData(document.getElementById( mapStorageId ).value);
			}
		}
	}

  	//PARA EDITAR POLIGONO
	this.setMap = function( divId, edit, inputId ) {
  		/*PARA BORRAR*/
	 	if( document.getElementById( divId ) ) {
			mapContainerId = divId;
			mapDiv = document.createElement('div');
			mapDiv.id = divId + "_map";
			setStyle( mapDiv, { height: "100%", width: "100%", position:"absolute", "zIndex":1, left:"0" } );

			document.getElementById( mapContainerId ).appendChild( mapDiv );
			sideBar = document.createElement('div');
			sideBar.id = divId + "_sidebar";
			setStyle( sideBar, { height: "100%", width: "250px", display:"none", "backgroundColor":"#e6e6e6", "borderLeft":"5px solid #999", position:"absolute", "zIndex":"1", right:"0", fontFamily:"Arial", overflowY:'auto' } );

			document.getElementById( mapContainerId ).appendChild( sideBar );
			setStyle( document.getElementById( mapContainerId ), { position:"relative" } );
    		/*PARA BORRAR*/
		}

	 	if( edit == true ) {
			isEditable = true;
		}

	 	if( document.getElementById( inputId ) ) {
			mapStorageId = inputId;
	   	}
	}

	function openInfowindow( overlay, latLng, content ) {
		var div = document.createElement('div');
		div.innerHTML = content;
		setStyle( div, {height: "100%"} );
		infWindow.setContent( div );
		infWindow.setPosition( latLng );
		infWindow.relatedOverlay = overlay;
		var t = overlay.get( 'fillColor' );
		infWindow.open( mapObj );
	}

	this.closeInfoWindow = function() {
		this.updateOverlay();
		infWindow.close();
	}

	this.updateOverlay = function() {
		infWindow.relatedOverlay.title = document.getElementById( 'BlitzMapInfoWindow_title' ).value;
		infWindow.relatedOverlay.setOptions( {fillColor: '#'+document.getElementById( 'BlitzMapInfoWindow_fillcolor' ).value.replace('#','') } );
		setStyle( document.getElementById( 'BlitzMapInfoWindow_fillcolor' ), { 'background-color': '#'+document.getElementById( 'BlitzMapInfoWindow_fillcolor' ).value.replace('#','') } );

		infWindow.relatedOverlay.setOptions( {fillOpacity: Number( document.getElementById( 'BlitzMapInfoWindow_fillopacity' ).value ) } );
	}

	function getEditorContent( overlay ) {
		var content = '<style>'
			+ '#BlitzMapInfoWindow_container input:focus, #BlitzMapInfoWindow_container textarea:focus{border:2px solid #7DB1FF;} '
			+ '#BlitzMapInfoWindow_container .BlitzMapInfoWindow_button{background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #cccccc;cursor:pointer;} '
			+ '.BlitzMapInfoWindow_button:hover{background-color:#2883CE;border-color:#05439F;} '
			+ '</style>'
			+ '<form style="height:100%"><div id="BlitzMapInfoWindow_container" style="height:100%">'
			+ '<div id="BlitzMapInfoWindow_details">'
			+ '<div style="padding-bottom:3px;">Etiqueta:&nbsp;&nbsp;<input type="text" id="BlitzMapInfoWindow_title" value="'+overlay.title+'" style="width:150px;padding:3px;" ></div>'
			+ '</div>'
			+ '<div id="BlitzMapInfoWindow_styles" style="display:none;width:100%;">'
			+ '<div style="height:25px;padding-bottom:2px;font-weight:bold;">Styles &amp; Colors</div>';

			var fillColor = ( overlay.fillColor == undefined )? "#000000":overlay.fillColor;
			content += '<div style="height:25px;padding-bottom:3px;">Fill Color: <input type="text" id="BlitzMapInfoWindow_fillcolor" value="'+ fillColor +'" style="border:2px solid #dddddd;width:30px;height:20px;font-size:0;float:right" ></div>';

			var fillOpacity = ( overlay.fillOpacity == undefined )? 0.3:overlay.fillOpacity;
			content += '<div style="height:25px;padding-bottom:3px;">Fill Opacity(percent): <input type="text" id="BlitzMapInfoWindow_fillopacity" value="'+ fillOpacity.toString() +'"  style="border:2px solid #dddddd;width:30px;float:right" onkeyup="BlitzMap.updateOverlay()" ></div>';

		content += '</div><br><div style="position:relative; bottom:0px;"><input type="button" value="Aceptar" class="BlitzMapInfoWindow_button" onclick="BlitzMap.closeInfoWindow()" style="background-color:#2883CE;color:#ffffff;padding:3px 10px;border:2px double #ffffff;border-radius: 5px;cursor:pointer;float:right;" title="Apply changes to the overlay">'
				+ '<div style="clear:both;"></div>';
				+ '</div>';
				+ '</div></form>'

		return content;
	}

	function overlayDone( event ) {
		var uniqueid =  uniqid();
		event.overlay.uniqueid =  uniqueid;
		event.overlay.title = "";
		event.overlay.content = "";
		event.overlay.type = event.type;
		mapOverlays.push( event.overlay );
		AttachClickListener( event.overlay );
		openInfowindow( event.overlay, getShapeCenter( event.overlay ), getEditorContent( event.overlay ) );
	}

	function getShapeCenter( shape ) {
		return shape.getPaths().getAt(0).getAt(0);
	}

	function AttachClickListener( overlay ) {
		google.maps.event.addListener( overlay, "click", function(clkEvent) {
			var infContent = GetContent( overlay );
			openInfowindow( overlay, clkEvent.latLng, infContent );
		} ) ;
	}

  function GetContent( overlay ) {
		var content =
			'<div><h3>'+overlay.title+'</h3>'+overlay.content+'<br></div>'
			+ GetInfoWindowFooter( overlay );
		return content;
	}

  function GetInfoWindowFooter( overlay ) {
		var content =
			'<div id="'+mapContainerId+'_dirContainer" style="bottom:0;padding-top:3px; font-size:13px;font-family:arial">'
		  + '<div  style="border-top:1px dotted #999;">'
		  + '<style>.BlitzMap_Menu:hover{text-decoration:underline; }</style>'
		  + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;" onclick="BlitzMap.getDirections()">Directions</span>'
		  + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Search nearby</span>'
		  + '<span class="BlitzMap_Menu" style="color:#ff0000; cursor:pointer;padding:0 5px;">Save to map</span>'
		  + '</div></div>';
		return content;
	}

	function uniqid() {
		var newDate = new Date;
		return newDate.getTime();
	}

	function setMapData( jsonString ) {
		if( jsonString.length == 0 ) {
			return false;
		}

		var inputData = JSON.parse( jsonString );
		if( inputData.zoom ) {
			mapObj.setZoom( inputData.zoom );
		} else {
			mapObj.setZoom( 10 );
		}

		if( inputData.tilt ) {
			mapObj.setTilt( inputData.tilt );
		} else {
			mapObj.setTilt( 0 );
		}

		if( inputData.mapTypeId ) {
			mapObj.setMapTypeId( inputData.mapTypeId );
		} else {
			mapObj.setMapTypeId( "terrain" );
		}

    	mapObj.setCenter( new google.maps.LatLng( inputData.center.lat, inputData.center.lng ) );
		var tmpOverlay, ovrOptions;
		var properties = new Array( 'fillColor', 'strokeColor');
		for( var m = inputData.overlays.length-1; m >= 0; m-- ) {
			ovrOptions = new Object();
			for( var x=properties.length; x>=0; x-- ) {
				if( inputData.overlays[m][ properties[x] ] ) {
					ovrOptions[ properties[x] ] = inputData.overlays[m][ properties[x] ];
				}
			}
      
	      	var tmpPaths = new Array();
	      	for( var n=0; n < inputData.overlays[m].paths.length; n++ ) {
	        	var tmpPath = new Array();
	        	for( var p=0; p < inputData.overlays[m].paths[n].length; p++ ) {
	          		tmpPath.push(  new google.maps.LatLng( inputData.overlays[m].paths[n][p].lat, inputData.overlays[m].paths[n][p].lng ) );
		        }
	        	
	        	tmpPaths.push( tmpPath );
	      	}
	      
	      	ovrOptions.paths = tmpPaths;
	      	tmpOverlay = new google.maps.Polygon( ovrOptions );
			tmpOverlay.type = inputData.overlays[m].type;
			tmpOverlay.setMap( mapObj );
			if( isEditable && inputData.overlays[m].type != "marker") {
				tmpOverlay.setEditable( true );
	        	tmpOverlay.setDraggable( true );
			}

			var uniqueid =  uniqid();
			tmpOverlay.uniqueid =  uniqueid;
			if( inputData.overlays[m].title ) {
				tmpOverlay.title = inputData.overlays[m].title;
			} else {
				tmpOverlay.title = "";
			}

			if( inputData.overlays[m].content ) {
				tmpOverlay.content = inputData.overlays[m].content;
			} else {
				tmpOverlay.content = "";
			}

			//attach the click listener to the overlay
			AttachClickListener( tmpOverlay );

			//save the overlay in the array
			mapOverlays.push( tmpOverlay );
		}
	}

	function mapToObject() {
		var tmpMap = new Object;
		var tmpOverlay, paths;
		tmpMap.zoom = mapObj.getZoom();
		tmpMap.tilt = mapObj.getTilt();
		tmpMap.mapTypeId = mapObj.getMapTypeId();
		tmpMap.center = { lat: mapObj.getCenter().lat(), lng: mapObj.getCenter().lng() };
		tmpMap.overlays = new Array();

		for( var i=0; i < mapOverlays.length; i++ ) {
			if( mapOverlays[i].getMap() == null ) {
				continue;
			}
		
			tmpOverlay = new Object;
			tmpOverlay.type = mapOverlays[i].type;
			tmpOverlay.title = mapOverlays[i].title;
			tmpOverlay.content = mapOverlays[i].content;

			if( mapOverlays[i].fillColor ) {
				tmpOverlay.fillColor = mapOverlays[i].fillColor;
			}

			if( mapOverlays[i].fillOpacity ) {
				tmpOverlay.fillOpacity = mapOverlays[i].fillOpacity;
			}

			if( mapOverlays[i].strokeColor ) {
				tmpOverlay.strokeColor = mapOverlays[i].strokeColor;
			}

			if( mapOverlays[i].strokeOpacity ) {
				tmpOverlay.strokeOpacity = mapOverlays[i].strokeOpacity;
			}

			if( mapOverlays[i].strokeWeight ) {
				tmpOverlay.strokeWeight = mapOverlays[i].strokeWeight;
			}

			tmpOverlay.paths = new Array();

			paths = mapOverlays[i].getPaths();
			for( var j=0; j < paths.length; j++ ) {
				tmpOverlay.paths[j] = new Array();
				for( var k=0; k < paths.getAt(j).length; k++ ) {
					tmpOverlay.paths[j][k] = { lat: paths.getAt(j).getAt(k).lat().toString() , lng: paths.getAt(j).getAt(k).lng().toString() };
				}
			}

			tmpMap.overlays.push( tmpOverlay );
		}

		return tmpMap;
  	}

	this.toJSONString = function() {
		var result = JSON.stringify( mapToObject() );
		if( mapStorageId ) {
			document.getElementById( mapStorageId ).value =  result;
		}

      	editarPoligono(result);
		return result;
	}

  	function editarPoligono(result) {
    	var mantenimientopreventivo_id = document.getElementById("mantenimientopreventivo_id").value;
    	$.ajax({
        	type: "POST",
            url: "/dh_tero/mantenimientopreventivo/actualizar_coordenadas",
            data: {'mantenimientopreventivo_id': mantenimientopreventivo_id,'array': JSON.stringify(result)},
            success: function() {
            	window.location.href = "/dh_tero/mantenimientopreventivo/configurar/" + mantenimientopreventivo_id;
            }
    	});
  	}

  	function getStyle( elem, prop ) {
	    if( document.defaultView && document.defaultView.getComputedStyle ) {
	    	return document.defaultView.getComputedStyle(elem, null).getPropertyValue(prop);
	    } else if( elem.currentStyle ) {
	    	var ar = prop.match(/\w[^-]*/g);
	    	var s = ar[0];
	    	for(var i = 1; i < ar.length; ++i) {
	    		s += ar[i].replace(/\w/, ar[i].charAt(0).toUpperCase());
	    	}
	    	
	    	return elem.currentStyle[s];
	    } else {
	    	 return 0;
	    }
	}

  	function setStyle( domElem, styleObj ) {
	    if( typeof styleObj == "object" ) {
	    	for( var prop in styleObj ) {
	    		domElem.style[ prop ] = styleObj[ prop ];
	    	}
	    }
	}
}

google.maps.event.addDomListener(window, "load", BlitzMap.init);