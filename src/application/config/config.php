<?php
/* Configuration for: Error reporting */
error_reporting(E_ALL);
ini_set("display_errors", 1);

 /* Configuration for: Project URL*/
// <<<<<<< HEAD
define('URL', 'http://localhost/gl/src/');
// define('URL',	 'http://localhost:8888/GL/src/');
// =======

// define('URL', 'http://localhost/GL/src/');
// define('URL',	 'http://localhost:8888/GL/src/');
// >>>>>>> df105692da542c9e009f80237bc087a927b015e7
//define('URL', 'http://tsalmon.fr/GL/src/');

/*Configuration for: Database*/
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME',  'hfgl');
define('DB_USER', 'root');
define('DB_PASS', 'root');
