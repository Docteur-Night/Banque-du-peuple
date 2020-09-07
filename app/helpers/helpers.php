<?php 
use App\Models\Bancaire;
use App\Models\Caisse;
use App\Models\Client;


if(!file_exists('title'))
{
    function titleShowed($title){
        $name = "BDP";
        return !empty($title)?$title.'|'.$name:$name;
    }
}

if(!file_exists('active_function')){
    function active_function($route)
    {
        return  Route::is($route)?'active':'';
    }
}

if(!function_exists('filter_date')){
    function filter_date($date)
    {

        if(!ctype_digit($date))
        {
            $week = 0;
            $date = strtotime($date);
            
            if(date('Ymd',$date) == date('Ymd'))
            {
                return "Aujourd'hui à ".date('H',$date).'h'.date('i',$date);
            }

            for($i =1; $i <= 365; $i++)
            {
                if ($i == 1)
                {
                    if(date('Ymd', $date) == date('Ymd', strtotime('- '.$i.' DAY')))
                    return 'Hier à '.date('H:i:s', $date);
                }else if($i % 7 == 0)
                {
                    $week++;
                    //semaine
                    return "Il y a ".$week." semaine à ".date('H:i:s', $date);
                }    
                else{
                     if(date('Ymd', $date) == date('Ymd', strtotime('- '.$i.' DAY')))
                    return 'Il y a '.$i.' jours à '.date('H:i:s', $date);
                }
            }      
        }
    }
}


if(!function_exists('endDate'))
{
    function endDate($comptes)
    {
       foreach($comptes as $compte):
            if($compte['date_fin'] != NULL)
            {
                if(!ctype_digit($compte['date_fin']))
                {
                    $date = strtotime($compte['date_fin']);

                    if(date('Y-m-d', $date) == date('Y-m-d')){
                        $d = Bancaire::whereId($compte['id'])->update(['date_fin'=> NULL, 'etat'=>true]);

                    }
                }
            }
       endforeach;
    }
}


if(!function_exists("remunerationDate"))
{
    function remunerationDate($comptes, $id)
    {
        foreach($comptes as $compte):
        
            if($compte['type'] == 'courant')
            {
                if(!ctype_digit($compte['created_at']))
                {
                    $date = strtotime($compte['created']);
                        
                   
                 }   
                
            }
        endforeach;
    }
}


if(!function_exists("takeAccount"))
{
      // helpers
      function takeAccount(int $id) 
      {  
           $compte = Client::find($id)->compte;
           
          return $compte;
      }
  
}


