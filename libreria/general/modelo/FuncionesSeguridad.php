<?php

class FuncionesSeguridad {

    /**
     *  Objeto de conexion base de datos
     *
     * @var BaseGeneral
     */
    private $objbase;

    /**
     *  Nombre de usuario en sesion
     *
     * @var String
     */
    private $usuario;

    public function __construct($usuario, $objbase) {
        $this->objbase = $objbase;
        $this->usuario = $usuario;
    }

    public function validaUsuarioMenuOpcion($idmenuopcion, $formulario) {

        $usuario = $formulario->datos_usuario();
        $condicion = " and pu.idpermisomenuopcion=pm.idpermisomenuopcion 
				and dpm.idpermisomenuopcion=pm.idpermisomenuopcion" .
                " and dpm.idmenuopcion=" . $idmenuopcion;
        if ($datosrolusuario = $this->objbase->recuperar_datos_tabla(" permisousuariomenuopcion pu, permisomenuopcion pm, detallepermisomenuopcion dpm", "pu.idusuario", $usuario['idusuario'], $condicion, '', 0)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function validaUsuarioMenuBoton($idmenuboton, $formulario) {

        $usuario = $formulario->datos_usuario();
        $condicion = " and u.usuario=ur.usuario 
				and ur.idrol=p.idrol" .
                " and p.idmenuboton=" . $idmenuboton;
        if ($datosrolusuario = $this->objbase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorolboton p", "u.idusuario", $usuario['idusuario'], $condicion, '', 0)) {
            return 1;
        }
        return 0;
    }

    public function validaOpcionUsuario($opcion) {
        $tabla = "usuario u,perfil p, perfilmenuopcion pm, menuopcion m";
        $nombrellave = "u.nombreusuario";
        $llave = $this->usuario;
        $condicion = " and u.idperfil=p.idperfil " .
                " and p.idperfil=pm.idperfil " .
                " and pm.idmenuopcion=m.idmenuopcion " .
                " and m.idmenuopcion=pm.idmenuopcion " .
                " and m.rutamenuopcion like '%" . $opcion . ".php'" .
                " and u.idestado='100' " .
                " and p.idestado='100' " .
                " and m.idestado='100' " .
                " and pm.idestado='100' ";
        if ($datosopciones = $this->objbase->recuperar_datos_tabla($tabla, $nombrellave, $llave, $condicion, "", 0, 0)) {
            return 1;
        }
        return 0;
    }

}

?>