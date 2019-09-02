<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_sitio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['iniciar'] = 'C_sitio/iniciar';
$route['salir'] = 'C_sitio/salir';
$route['usuarios'] = 'C_sitio/usuarios';
$route['preguntas'] = 'C_sitio/preguntas';
$route['agregar_usuario'] = 'C_sitio/agregar_usuario';
$route['modificar_usuario'] = 'C_sitio/modificar_usuario';
$route['guardar'] = 'C_usuario/guardar';

$route['eliminar'] = 'C_usuario/eliminar';
$route['modificar'] = 'C_usuario/modificar';

$route['cuestionario'] = 'C_sitio/cuestionario';
$route['respuestas'] = 'C_cuestionario/guarda_respuestas';
$route['archivo'] = 'C_cuestionario/archivo';

$route['agregar_preg'] = 'C_sitio/agregar_pregunta';
$route['elimina_preg'] = 'C_cuestionario/eliminar_preg';

$route['carga_r'] = 'C_cuestionario/carga_respuestas';
$route['guardar_preg'] = 'C_cuestionario/guardar_pregunta';
$route['actualiza_preg'] = 'C_cuestionario/actualizar_pregunta';
$route['modifica_preg'] = 'C_sitio/modificar_pregunta';


$route['listado-respuestas'] = 'C_sitio/respuestas';
$route['elimina_resp'] = 'C_cuestionario/eliminar_resp';

$route['guarda_op'] = 'C_cuestionario/guarda_opcion';
$route['calificar'] = 'C_sitio/calificar';
$route['califica_us'] = 'C_sitio/calificar_usuario';
$route['envia_calif'] = 'C_cuestionario/envia_calif';

$route['listado-cuestionarios']  = 'C_cuestionario/listar_cuestionarios';
$route['capturar_cuest'] = 'C_cuestionario/capturar_cuestionario';
$route['capturar_preguntas'] = 'C_cuestionario/capturar_preguntas';