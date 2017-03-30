<?php

function redirect_to($loc) {
	header("Location: " . $loc);
	exit;
}

function is_post_request() {
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}
?>