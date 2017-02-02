<?php


class YhtyeController extends BaseController{
    
    public static function yhtyeet() {
        $yhtyeet = Yhtye::all();
        View::make('yhtye/yhtyeet.html', array('yhtyeet' => $yhtyeet));
    
    }
    
    public static function yhtye_nayta($id) {
        $yhtye = Yhtye::find($id);
        View::make('yhtye/yhtye_show.html', array('yhtye' => $yhtye));
    }
    
    public static function yhtye_new() {
        View::make('yhtye/new.html');
    }
    
    public static function store() {
        $params = $_POST;
        
        $yhtye = new Yhtye(array(
            'nimi' =>  $params['nimi'],
            'kuvaus' => $params['kuvaus'],
        ));
        
        $yhtye->save();
        Redirect::to('/yhtye/' . $yhtye->id, array('message' => 'Yhtye on lisätty'));

    }
    
 
    
}