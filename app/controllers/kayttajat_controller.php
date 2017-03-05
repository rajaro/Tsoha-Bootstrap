<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KayttajaController extends BaseController {
    
    public static function login(){
      View::make('kayttaja/login.html');
  }
  
  
  public static function handle_login(){
    $params = $_POST;

    $kayttaja = Kayttaja::authenticate($params['nimi'], $params['password']);

    if(!$kayttaja){
      View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
    }else{
      $_SESSION['kayttaja'] = $kayttaja->id;

      Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
    }
  }
  
  public static function rekisterointi() {
      View::make('/kayttaja/rekisterointi.html');
  }
  
  public static function logout(){
    $_SESSION['kayttaja'] = null;
    Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
  }
  
  public static function store(){
       $params = $_POST;
              
        $kayttaja = new Kayttaja(array(
            'nimi' => $params['nimi'],
            'password' => $params['password'],
        ));
               
        $kayttaja->save();
        Redirect::to('/keikka', array('message' => 'Rekisteröityminen onnistui!'));

  }
}