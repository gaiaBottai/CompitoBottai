<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");
$app->get('/alunni/{id}',"AlunniController:view");
$app->post('/alunni',"AlunniController:create");
$app->put('/alunni/{id}',"AlunniController:update");
$app->delete('/alunni/{id}',"AlunniController:destroy");

$app->get('/certificazioni',"CertificazioniController:index");
$app->get('/certificazioni/{id}',"CertificazioniController:view");
$app->post('/certificazioni',"CertificazioniController:create");
$app->put('/certificazioni/{id}',"CertificazioniController:update");
$app->delete('/certificazioni/{id}',"CertificazioniController:destroy");

$app->run();
