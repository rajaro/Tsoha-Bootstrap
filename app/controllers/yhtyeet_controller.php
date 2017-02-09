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
    
    public static function edit($id) {
        $yhtye = Yhtye::find($id);
        View::make('yhtye/yhtye_show.html', array('yhtye' => $yhtye));
        
    }
    
    public static function store() {
        $params = $_POST;
        
        $yhtye = new Yhtye(array(
            'nimi' =>  $params['nimi'],
            'kuvaus' => $params['kuvaus'],
        ));
        
        $errors = $yhtye->errors();
        
        if(count($errors) == 0) {
        
        $yhtye->save();
        Redirect::to('/yhtye/' . $yhtye->id, array('message' => 'Yhtye on lisätty'));
        } else {
            $yhtyeet = Yhtye::all();
            Redirect::to('/yhtyeet', array('errors' => $errors),
                    array('yhtyeet' => $yhtyeet));
        }

    }
    
    public static function destroy($id) {
        $yhtye = new Yhtye(array('id' => $id));
        $yhtye->delete();
        Redirect::to('/yhtyeet', array('message' => 'Yhtye on poistettu onnistuneesti!'));
        
    }
    
    public static function update($id) {
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus']
            
        );
        $yhtye = new Yhtye($attributes);
        $yhtye->update();
        $yhtyeet = Yhtye::all();
        View::make('yhtye/yhtyeet.html', array('yhtyeet' => $yhtyeet));
    }
}
