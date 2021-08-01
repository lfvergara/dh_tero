<!--LST_COORDENADA-->
var triangleCoords_{i} = [
  {lista_coordenadas}
];

poligono_{i} = new google.maps.Polygon({
  paths: triangleCoords_{i},
  strokeColor: 'filcolor',
  fillColor: 'strockcolor'
});

google.maps.event.addListener(poligono_{i}.getPath(), 'set_at', function() {
  var vertices_{i} = poligono_{i}.getPath();
  coordenadas_{i} = [];
  for (var i =0; i < vertices_{i}.length; i++) {
    coordenadas_{i}.push({
      lat: vertices_{i}.getAt(i).lat(),
      lng: vertices_{i}.getAt(i).lng()
    });
  }
});

poligono_{i}.setMap(map);
poligono_{i}.addListener('click', function(event) {
  var variable = 'etiqueta';
  var evento = event.latLng;
  showArrays(variable,evento);
});
<!--LST_COORDENADA-->