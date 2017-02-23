<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EsiintymispaikkaController extends BaseController{
    
    public static function paikat() {
        $paikat = Esiintymispaikka::all();
        View::make('esiintymispaikka/lista.html', array('paikat' => $paikat));
    
    }
    
    public static function paikka_nayta($id) {
        $paikka = Esiintymispaikka::find($id);
        View::make('esiintymispaikka/paikka_nayta.html', array('paikka' => $paikka));
    }
    
    public static function paikka_new() {
        View::make('esiintymispaikka/new.html');
    }
    
    public static function destroy($id) {
        $paikka = new Esiintymispaikka(array('id' => $id));
        $paikka->delete();
        Redirect::to('/keikka', array('message' => 'Esiintymispaikka on poistettu onnistuneesti!'));
        
    }
    
    public static function store() {
        $params = $_POST;
              
        $paikka = new Esiintymispaikka(array(
            'nimi' => $params['nimi'],
            'osoite' => $params['osoite'],
        ));
               
        $paikka->save();
        Redirect::to('/keikka', array('message' => 'Paikka on lisätty'));

    }
    
    
    
    
}
