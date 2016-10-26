<?php
foreach($error as $e) {
	echo '<p class="error red-text">Error : ' . $e . '</p>';
}

if (isset($_SESSION['error'])) {
    foreach($_SESSION['error'] as $e) {
        echo '<p class="error red-text">Error : ' . $e . '</p>';
    }
    
    $_SESSION['error'] = null;
}

foreach($success as $s) {
	echo '<p class="sucecss green-text">Success : ' . $s . '</p>';
}