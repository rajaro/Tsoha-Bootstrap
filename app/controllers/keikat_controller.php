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
        View::make('keikka/index.html', array('keikat' => $keikat, 'yhtyeet' => $yhtyeet));
    
    }
    
    public static function keikka_nayta($id) {
        $keikka = Keikka::find($id);
        $yhtye = Yhtye::find($keikka->yhtye_id);
        View::make('keikka/keikka_show.html', array('keikka' => $keikka, 'yhtye' => $yhtye));
    }
    
    public static function keikka_new() {
        $yhtyeet = Yhtye::all();
        View::make('keikka/new.html', array('yhtyeet' => $yhtyeet));
    }
    
    public static function destroy($id) {
        $keikka = new Keikka(array('id' => $id));
        $keikka->delete();
        Redirect::to('/keikka', array('message' => 'Yhtye on poistettu onnistuneesti!'));
        
    }
    
    public static function store() {
        $params = $_POST;
        
        $yhtyeid = $params['yhtye'];
        $yhtye = Yhtye::find($yhtyeid);
        
        $keikka = new Keikka(array(
            'yhtye_id' =>  $yhtyeid,
            'esiintymispaikka' => $params['esiintymispaikka'],
            'pvm' => $params['pvm'],
            'hinta' => $params['hinta']
        ));
        
        $keikka->save();
        Redirect::to('/keikka/' . $keikka->id, array('message' => 'Keikka on lisätty'));

    }
    
    
    
    
}
