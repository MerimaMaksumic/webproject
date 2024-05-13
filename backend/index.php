<?php

require 'vendor/autoload.php';
require 'config.php';

require 'rest/routes/book_routes.php';
require 'rest/routes/auth_routes.php';
require 'rest/routes/users_routes.php';
require 'rest/routes/categories_routes.php';
require 'rest/routes/wishlist_routes.php';
require 'rest/routes/cart_routes.php';


Flight::start();

