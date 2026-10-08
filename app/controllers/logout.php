<?php
session_start();
session_destroy();
header('Location: /clothesstreet/public/index.php');
exit;