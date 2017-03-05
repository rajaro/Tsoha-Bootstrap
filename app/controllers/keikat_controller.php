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
        foreach ($keikat as $keikka) {
            $yhtyeids = $keikka->findBandit($keikka->id);
            foreach ($yhtyeids as $yhtyeid) {
                $keikka->yhtyeet[] = Yhtye::find($yhtyeid);                 
                
            }
        }
        $paikat = Esiintymispaikka::all();
        View::make('keikka/index.html', array('keikat' => $keikat, 'yhtyeet' => $yhtyeet,
            'paikat' => $paikat));
    
    }
    
    public static function keikka_nayta($id) {
        $bandids = Keikka::findBandit($id);
        $paikat = Esiintymispaikka::all();
        $yhtyeet = array();
        foreach($bandids as $bandid) {
            $yhtye = Yhtye::find($bandid);
            $yhtyeet[] = new Yhtye(array(
                'id' => $yhtye->id,
                'nimi' => $yhtye->nimi,
                'kuvaus' => $yhtye->kuvaus
            ));          
        }
        $keikka = Keikka::find($id);
     //   $paikka = Esiintymispaikka::find($keikka->paikka_id);
        View::make('keikka/keikka_show.html', array('paikat' => $paikat, 'keikka' => $keikka, 'yhtyeet' => $yhtyeet));
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
        
        $yhtyeet = $params['yhtye_id'];
        
        
        $keikka = new Keikka(array(
            'yhtye_id' =>  $params['yhtye_id'],
            'paikka_id' => $params['paikka_id'],
            'pvm' => $params['pvm'],
            'hinta' => $params['hinta'],
            'yhtyeet' => array()
        ));
        
        foreach ($yhtyeet as $yhtye) {
            $keikka->yhtyeet[] = $yhtye;
        }
        
        $errors = $keikka->errors();
        if (count($errors) == 0) {

        $keikka->save();
        Redirect::to('/keikka/' . $keikka->id, array('message' => 'Keikka on lisätty'));
        } else {
            $yhtyeet = Yhtye::all();
            $paikat = Esiintymispaikka::all();
            $keikat = Keikka::all();
            Redirect::to('/keikka', array('errors' => $errors, 'keikat' => $keikat, 'yhtyeet' => $yhtyeet,
            'paikat' => $paikat));
        }
    }
    
    public static function update($id) {
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'pvm' => $params['pvm'],
            'hinta' => $params['hinta']
            
        );
        $keikka = new Keikka($attributes);
        $keikka->update();
        $keikat = Keikka::all();
        View::make('keikka/index.html', array('keikat' => $keikat));
    }
    
    
    
}
