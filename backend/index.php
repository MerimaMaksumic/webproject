<?php

require 'vendor/autoload.php';
require 'config.php';

require 'rest/routes/book_routes.php';
require 'rest/routes/auth_routes.php';


Flight::start();

