<?php
require 'app/models/keikka.php';
  class HelloWorldController extends BaseController{

   /* public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }*/

    public static function sandbox(){
        $primordial = Keikka::find(1);
        $keikat = Keikka::all();
        
        Kint::dump($keikat);
        Kint::dump($primordial);
 
    }
  public static function keikka_lista(){
    View::make('suunnitelmat/keikka_lista.html');
  }

  public static function keikka_nayta(){
    View::make('suunnitelmat/keikka_nayta.html');
  }
  
  public static function esiintymispaikka(){
      View::make('suunnitelmat/esiintymispaikka.html');
  }


}
  
