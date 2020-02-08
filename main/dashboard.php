<?php
require 'cfg/config.php';
if(!loggedin()) redirect('index');
$title = "Dashboard";
include 'html/header.inc.php'; ?>
<h4>Posts will appear here shortly.</h4><hr/>
<?php 
include 'html/sidebar.inc.php';
include 'html/footer.inc.php';