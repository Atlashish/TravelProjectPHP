<?php

namespace App;

$router->get('project/countries', 'CountriesControllers::readAll');
$router->get('project/countries/:id', 'CountriesControllers::read');
$router->post('project/countries', 'CountriesControllers::create');
$router->patch('project/countries/:id', 'CountriesControllers::update');
$router->delete('project/countries/:id', 'CountriesControllers::delete');

$router->get('project/travels', 'TravelsControllers::readAll');
$router->get('project/travels/:id', 'TravelsControllers::read');
$router->post('project/travels', 'TravelsControllers::create');
$router->patch('project/travels/:id', 'TravelsControllers::update');
$router->delete('project/travels/:id', 'TravelsControllers::delete');

