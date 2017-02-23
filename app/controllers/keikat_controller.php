<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KeikkaController extends BaseController{
    
    public static function index() {
        $keikat = Keikka::all();
        $yhtyeet = Yhtye::all();
        $paikat = Esiintymispaikka::all();
        View::make('keikka/index.html', array('keikat' => $keikat, 'yhtyeet' => $yhtyeet,
            'paikat' => $paikat));
    
    }
    
    public static function keikka_nayta($id) {
        $keikka = Keikka::find($id);
        $bandi = Yhtye::find($keikka->yhtye_id);
        $paikka = Esiintymispaikka::find($keikka->paikka_id);
        View::make('keikka/keikka_show.html', array('keikka' => $keikka, 'yhtye' => $bandi));
    }
    
    public static function keikka_new() {
        $yhtyeet = Yhtye::all();
        $paikat = Esiintymispaikka::all();
        View::make('keikka/new.html', array('yhtyeet' => $yhtyeet, 'paikat' => $paikat));
    }
    
    public static function destroy($id) {
        $keikka = new Keikka(array('id' => $id));
        $keikka->delete();
        Redirect::to('/keikka', array('message' => 'Yhtye on poistettu onnistuneesti!'));
        
    }
    
    public static function store() {
        $params = $_POST;
        
      //  $yhtyeids = $params['yhtyeet'];
        
        
        $keikka = new Keikka(array(
            'yhtye_id' =>  $params['yhtye_id'],
            'paikka_id' => $params['paikka_id'],
            'pvm' => $params['pvm'],
            'hinta' => $params['hinta']
        ));
        
   /*     foreach($yhtyeids as $yhtyeid){
            $attributes['yhtyeet'][] = $yhtyeid;
        }*/

        $keikka->save();
        Redirect::to('/keikka/' . $keikka->id, array('message' => 'Keikka on lisätty'));

    }
    
    public static function update($id) {
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'yhty_id' => $params['yhtye_id'],
            'kuvaus' => $params['kuvaus']
            
        );
        $yhtye = new Keikka($attributes);
        $yhtye->update();
        $yhtyeet = Yhtye::all();
        View::make('yhtye/yhtyeet.html', array('yhtyeet' => $yhtyeet));
    }
    
    
    
}
