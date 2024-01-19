
<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| app Routes
|--------------------------------------------------------------------------
*/




Route::get('/{vue_route}',[LoginController::class,'Index'])->where('vue_route', '(.*)');





// Route::any('{slug}', function(){
//     return view('home');
// })->where('{slug}', '^(?!/api).*$');



// pdf routes
Route::get('pdf', [PdfController::class, 'createPDF']);
