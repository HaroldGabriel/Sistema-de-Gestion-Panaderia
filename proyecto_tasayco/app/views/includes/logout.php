
<?php
session_start();
session_unset();
session_destroy();
header('Location: /proyecto_final/proyecto_tasayco/public/');
exit();
?>
