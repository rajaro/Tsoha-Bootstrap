<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KeikkaController extends BaseController{
    
    public static function index() {
        $keikat = Keikka::all();
        
        View::make('keikka/index.html', array('keikat' => $keikat));
    
    }
    
    public static function keikka_nayta($id) {
        
    }
    
    public static function keikka_new() {
        View::make('keikka/new.html');
    }
    
    public static function store() {
        $params = $_POST;
        
        $keikka = new Keikka(array(
            'yhtye' =>  $params['yhtye'],
            'esiintymispaikka' => $params['esiintymispaikka'],
            'pvm' => $params['pvm']
        ));
        
        $keikka->save();
        Redirect::to('/keikka/' . $keikka->id, array('message' => 'Keikka on lisätty'));

    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Keikka (yhtye, esiintymispaikka, pvm) VALUES (:nimi, :esiintymispaikka, :pvm) RETURNING id');
        $query->execute(array(
            'yhtye' => $this.yhtye,
            'esiintymispaikka' => $this.esiintymispaikka,
            'pvm' => $this.pvm
        )); 
        
        $row = $query.fetch();
        $this->id = $row['id'];
    }
    
    
}
