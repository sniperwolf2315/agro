<?php
define( 'PROJECT_ROOT_PATH', __DIR__ . '/../' );

// include main configuration file
// require_once PROJECT_ROOT_PATH . '/inc/config.php';
include 'config.php';

// include the base controller file
// require_once PROJECT_ROOT_PATH . '/Controller/Api/BaseController.php';
include  '/controller/API/baseController.php';

// include the use model file
include '/model/userModel.php';

?>