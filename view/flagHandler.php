<?php
foreach($error as $e) {
	echo '<p class="error red-text">Error : ' . $e . '</p>';
}

foreach($success as $s) {
	echo '<p class="sucecss green-text">Success : ' . $s . '</p>';
}