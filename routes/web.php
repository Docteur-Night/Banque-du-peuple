<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('banque.home');
})->name('index');

Route::get('/moncompte/{client}', function(){

    return view('banque.account');

})->name('account');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//resource
Route::resource('client', 'ClientController');
Route::resource('bancaire', 'BancaireController');

Route::get('/gestion/{id}', function(){

 if(Auth::check()){
    $compteBanque = User::find(Auth::user()->id)->comptes;
    $compteClient  = User::find(Auth::user()->id)->clients;

    // compte recement créé
    
    $comptes =  $compteBanque->skip($compteBanque->count() - 2);
    $clients = $compteClient->skip($compteClient->count() - 2);
  
    return view('banque.responsable.gestion.show', compact('comptes','clients'));
 }

 return view('banque.responsable.gestion.show');

})->name('gestion.show');



Route::get('/gestion/{id}/mes-comptes', function(){

    return view('banque.responsable.gestion.listeComptes');
})->name('gestion.comptes');

Route::get('/gestion/{id}/mes-clients', function(){
    return view('banque.responsable.gestion.showclients');
})->name('gestion.clients');

Route::get('/gestion/{id}/transactions', function(){
    return view('banque.responsable.gestion.transactions');
})->name('gestion.transactions');


Route::get('/operations/{id}/operations', function(){
   return view('banque.caissier.operations.optionBancaire');
})->name('operation.show');


Route::get('/operation/caisse/{id}/transactions', function(){
    return view('banque.responsable.gestion.transactions');
})->name('operation.transactions');


Route::get('/operation/caisse/{id}/depot', function(){
   return view('banque.caissier.operations.depot');
})->name('operation.depot');

Route::get('/operation/caisse/{id}/retrait', function(){
    return view('banque.caissier.operations.retrait');
})->name('operation.retrait');



Route::get('/recu-pdf','RecuController@RecuTraitement')->name('recu');
Route::get('/releve-pdf','ReleveController@ReleveTraitement')->name('releve');


Route::get('/connect/Google', 'ApiController\GoogleController@redirectToProvider');
Route::get('/connect/Google/Callback', 'ApiController\GoogleController@handleProviderCallback');


