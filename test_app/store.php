<?php
require_once('functions.php');

savePostedData($_POST); // 追記
header('Location: ./index.php');

