<?php
set_include_path(WEB_901_INCLUDE_PATH);
define("INVENTORY_AMF_URL", INVENTORY_901_URL);
define("AMF_IDENTIFIER", "_901_inventory_");
require_once 'includes/amfphp/services/InventoryService.php';
?>