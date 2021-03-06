<?php

  $routes->get('/', function() {
      KeikkaController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  

  
  $routes->get('/yhtyeet', function() {
      YhtyeController::yhtyeet();
  });
  
  $routes->get('/yhtye/new', function() {
      YhtyeController::yhtye_new();
  });
  
  $routes->get('/yhtye/:id', function($id) {
      YhtyeController::yhtye_nayta($id);
  });
  
  $routes->post('/yhtye', function(){
    YhtyeController::store();
});

$routes->post('/yhtye', function(){
    YhtyeController::create();
});

$routes->get('/yhtye/:id/edit', function($id) {
    YhtyeController::yhtye_nayta($id);
});
$routes->post('/yhtye/:id/delete', function($id) {
   YhtyeController::destroy($id); 
});

$routes->post('/yhtye/:id', function($id) {
    YhtyeController::update($id);
});

$routes->post('/keikka/:id/delete', function($id) {
    KeikkaController::destroy($id);
});

$routes->post('/keikka/:id', function($id) {
    KeikkaController::update($id);
});

  $routes->get('/keikka', function() {
  KeikkaController::index();
});

  $routes->get('/keikka/new', function() {
    KeikkaController::keikka_new();
});


$routes->get('/keikka/:id', function($id) {
  KeikkaController::keikka_nayta($id);
});

$routes->get('/esiintymispaikka', function() {
    EsiintymispaikkaController::paikat();
});

$routes->post('/esiintymispaikka', function() {
    EsiintymispaikkaController::store();
});

$routes->get('/esiintymispaikka/new', function() {
    EsiintymispaikkaController::paikka_new();
});

$routes->post('/esiintymispaikka/:id/delete', function($id) {
    EsiintymispaikkaController::destroy($id);
});

$routes->post('/keikka', function(){
    KeikkaController::store();
});

$routes->post('/keikka', function(){
    KeikkaController::create();
});

$routes->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  KayttajaController::login();
});
$routes->post('/login', function(){
  // Kirjautumisen käsittely
  KayttajaController::handle_login();
});

$routes->post('/logout', function(){
  KayttajaController::logout();
});

$routes->post('/rekisterointi', function() {
    KayttajaController::store();
});
    
$routes->get('/rekisterointi', function() {
    KayttajaController::rekisterointi();
});
    


