/* ****************************************************************************************** */
/* PARA MENÚ 
/* ****************************************************************************************** */
CREATE TABLE IF NOT EXISTS menu (
    menu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , icon VARCHAR(50)
    , url VARCHAR(50)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS submenu (
    submenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , icon VARCHAR(50)
    , url VARCHAR(50)
    , menu INT(11)
    , INDEX(menu)
    , FOREIGN KEY (menu)
        REFERENCES menu (menu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS item (
    item_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , url VARCHAR(50)
    , detalle VARCHAR(100)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS configuracionmenu (
    configuracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , nivel INT(11)
    , gerencia INT(11)
    , INDEX (gerencia)
    , FOREIGN KEY (gerencia)
        REFERENCES gerencia (gerencia_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS submenuconfiguracionmenu (
    submenuconfiguracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES configuracionmenu (configuracionmenu_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES submenu (submenu_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS itemconfiguracionmenu (
    itemconfiguracionmenu_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES configuracionmenu (configuracionmenu_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES item (item_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS archivo (
    archivo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , url VARCHAR(100)
    , fecha_carga DATE
    , formato VARCHAR(50)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS video (
    video_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , url VARCHAR(100)
    , fecha_carga DATE
) ENGINE=InnoDb;

/* ****************************************************************************************** */
/* PARA USUARIO DESARROLLADOR
/* ****************************************************************************************** */
CREATE TABLE IF NOT EXISTS usuariodetalle (
    usuariodetalle_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , apellido VARCHAR(50)
    , nombre VARCHAR(50)
    , correoelectronico VARCHAR(250)
    , token TEXT
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS usuario (
    usuario_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(50)
    , nivel INT(1)
    , usuariodetalle INT(11)
    , INDEX (usuariodetalle)
    , FOREIGN KEY (usuariodetalle)
        REFERENCES usuariodetalle (usuariodetalle_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

INSERT INTO usuariodetalle (usuariodetalle_id, apellido, nombre, correoelectronico, token) 
VALUES (1, 'Admin', 'admin', 'admin@admin.com', 'ff050c2a6dd7bc3e4602e9702de81d21');

INSERT INTO usuario (usuario_id, denominacion, nivel, usuariodetalle) 
VALUES (1, 'admin', 3, 1);

/* ****************************************************************************************** */
/* PARA OBJETOS DE CASOS DE USO 
/* ****************************************************************************************** */
CREATE TABLE IF NOT EXISTS provincia (
    provincia_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS departamento (
    departamento_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , unicom INT(11)
    , INDEX (unicom)
    , FOREIGN KEY (unicom)
        REFERENCES unicom (unicom_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS localidad (
    localidad_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(150)
    , detalle TEXT
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS gerencia (
    gerencia_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS centrocosto (
    centrocosto_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , codigo INT(4)
    , denominacion VARCHAR(250)
    , gerencia INT(11)
    , INDEX (gerencia)
    , FOREIGN KEY (gerencia)
        REFERENCES gerencia (gerencia_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS unicom (
    unicom_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , nomenclatura VARCHAR(4)
    , estado INT(1)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS documentotipo (
    documentotipo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS infocontacto (
    infocontacto_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(150)
    , valor TEXT
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS rse (
    rse_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion TEXT
    , epigrafe TEXT
    , contenido TEXT
    , fecha DATE
    , hora TIME
    , activo INT(1)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS archivorse (
    archivorse_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES rse (rse_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES archivo (archivo_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS videorse (
    videorse_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES rse (rse_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES video (video_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS areainteres (
    areainteres_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS oficinadia (
    oficinadia_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , lunes INT(1)    
    , martes INT(1)    
    , miercoles INT(1)    
    , jueves INT(1)    
    , viernes INT(1)    
    , sabado INT(1)    
    , domingo INT(1)    
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS oficina (
    oficina_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , direccion VARCHAR(250)
    , hora_desde TIME
    , hora_hasta TIME
    , turnero_online INT(1)
    , oficinadia INT(11)
    , INDEX (oficinadia)
    , FOREIGN KEY (oficinadia)
        REFERENCES oficinadia (oficinadia_id)
        ON DELETE SET NULL
    , unicom INT(11)
    , INDEX (unicom)
    , FOREIGN KEY (unicom)
        REFERENCES unicom (unicom_id)
        ON DELETE SET NULL
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS tramite (
    tramite_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , nomenclatura VARCHAR(2)
    , online INT(1)
    , requisito TEXT
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS destinatario (
    destinatario_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
    , correoelectronico VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS agenda (
    agenda_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS destinatarioagenda (
    destinatarioagenda_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES agenda (agenda_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES destinatario (destinatario_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS mantenimientocategoria (
    mantenimientocategoria_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS mantenimientoinstitucion (
    mantenimientoinstitucion_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS barrio (
    barrio_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion TEXT
    , latitud TEXT
    , longitud TEXT
    , zoom INT(11)
    , departamento INT(11)
    , INDEX (departamento)
    , FOREIGN KEY (departamento)
        REFERENCES departamento (departamento_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS coordenada (
    coordenada_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , latitud TEXT
    , longitud TEXT
    , altitud INT(11)
    , etiqueta TEXT
    , fillcolor TEXT
    , strokecolor TEXT
    , indice INT(11)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS coordenadabarrio (
    coordenadabarrio_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES barrio (barrio_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES coordenada (coordenada_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS mantenimientoubicacion (
    mantenimientoubicacion_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , sector TEXT
    , calles TEXT
    , latitud TEXT
    , longitud TEXT
    , zoom INT(11)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS departamentomantenimientoubicacion (
    departamentomantenimientoubicacion_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES mantenimientoubicacion (mantenimientoubicacion_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES departamento (departamento_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS mantenimientopreventivo (
    mantenimientopreventivo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , numero_eucop VARCHAR(10)
    , fecha_inicio DATE
    , hora_inicio TIME
    , hora_fin TIME
    , motivo TEXT
    , descripcion TEXT
    , responsable_edelar VARCHAR(250)
    , responsable_contratista VARCHAR(250)
    , informe INT(1)
    , aprobado INT(1)
    , mantenimientocategoria INT(11)
    , INDEX (mantenimientocategoria)
    , FOREIGN KEY (mantenimientocategoria)
        REFERENCES mantenimientocategoria (mantenimientocategoria_id)
        ON DELETE CASCADE
    , mantenimientoinstitucion INT(11)
    , INDEX (mantenimientoinstitucion)
    , FOREIGN KEY (mantenimientoinstitucion)
        REFERENCES mantenimientoinstitucion (mantenimientoinstitucion_id)
        ON DELETE CASCADE
    , mantenimientoubicacion INT(11)
    , INDEX (mantenimientoubicacion)
    , FOREIGN KEY (mantenimientoubicacion)
        REFERENCES mantenimientoubicacion (mantenimientoubicacion_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS coordenadamantenimientopreventivo (
    coordenadamantenimientopreventivo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , latitud TEXT
    , longitud TEXT
    , altitud INT(1)
    , etiqueta TEXT
    , fillcolor TEXT
    , strokecolor TEXT
    , indice INT(11)
    , mantenimientopreventivo_id INT(11)    
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS distcetnis (
    distcetnis_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , nis VARCHAR(8)
    , distribuidor VARCHAR(8)
    , cet VARCHAR(8)
    , distrito INT(1)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS distribuidor (
    distribuidor_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , distribuidor VARCHAR(10)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS ceta (
    ceta_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , ceta VARCHAR(10)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS distribuidormantenimientopreventivo (
    distribuidormantenimientopreventivo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES mantenimientopreventivo (mantenimientopreventivo_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES distribuidor (distribuidor_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS cetamantenimientopreventivo (
    cetamantenimientopreventivo_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES mantenimientopreventivo (mantenimientopreventivo_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES ceta (ceta_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS rangoturnero (
    rangoturnero_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , fecha_desde DATE
    , fecha_hasta DATE
    , estado INT(1)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS configuracionturnero (
    configuracionturnero_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , cantidad_gestores INT(11)
    , duracion_turno INT(11)
    , rangoturnero INT(11)
    , INDEX (rangoturnero)
    , FOREIGN KEY (rangoturnero)
        REFERENCES rangoturnero (rangoturnero_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS configuracionturnerooficina (
    configuracionturnerooficina_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES oficina (oficina_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES configuracionturnero (configuracionturnero_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS curriculum (
    curriculum_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , apellido VARCHAR(250)
    , nombre VARCHAR(250)
    , localidad VARCHAR(250)
    , direccion VARCHAR(250)
    , correo VARCHAR(250)
    , telefono BIGINT(15)
    , estudio VARCHAR(250)
    , titulo VARCHAR(250)
    , estadocivil VARCHAR(250)
    , mensaje VARCHAR(250)
    , fecha_carga DATE
    , areainteres INT(11)
    , INDEX (areainteres)
    , FOREIGN KEY (areainteres)
        REFERENCES areainteres (areainteres_id)
        ON DELETE CASCADE
    , provincia INT(11)
    , INDEX (provincia)
    , FOREIGN KEY (provincia)
        REFERENCES provincia (provincia_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS tarjetacredito (
    tarjetacredito_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS tipogestioncomercial (
    tipogestioncomercial_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(200)
    , cantidadarchivo INT(11)
    , codigo TEXT
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS gestioncomercial (
    gestioncomercial_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , suministro INT(7)
    , fecha DATE
    , dni INT(8)
    , apellido VARCHAR(150)
    , nombre VARCHAR(150)
    , correoelectronico VARCHAR(150)
    , telefono BIGINT(13)
    , tipogestioncomercial INT(11)
    , INDEX (tipogestioncomercial)
    , FOREIGN KEY (tipogestioncomercial)
        REFERENCES tipogestioncomercial (tipogestioncomercial_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS estadogestioncomercial (
    estadogestioncomercial_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , denominacion VARCHAR(250)
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS gestioncomercialhistorico (
    gestioncomercialhistorico_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , fecha DATE
    , hora TIME
    , detalle TEXT
    , estadogestioncomercial INT(11)
    , INDEX (estadogestioncomercial)
    , FOREIGN KEY (estadogestioncomercial)
        REFERENCES estadogestioncomercial (estadogestioncomercial_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS gestioncomercialhistoricogestioncomercial (
    gestioncomercialhistoricogestioncomercial_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES gestioncomercial (gestioncomercial_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES gestioncomercialhistorico (gestioncomercialhistorico_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS archivogestioncomercial (
    archivogestioncomercial_id INT(11) NOT NULL 
        AUTO_INCREMENT PRIMARY KEY
    , compuesto INT(11)
    , INDEX(compuesto)
    , FOREIGN KEY (compuesto)
        REFERENCES gestioncomercial (gestioncomercial_id)
        ON DELETE CASCADE
    , compositor INT(11)
    , FOREIGN KEY (compositor)
        REFERENCES archivo (archivo_id)
        ON DELETE CASCADE
) ENGINE=InnoDb;