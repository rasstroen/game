<?php
require_once '../core/api.php';

$method = $_REQUEST['method'];
$api    = new API($method, $_REQUEST);

return $api->response();