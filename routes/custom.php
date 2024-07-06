<?php

/*
  * You can add here your custom routes
 */

use Illuminate\Support\Facades\Route;
use App\Models\Language;

// 1. Custom routes for Admin area
Route::prefix('account/admin')->name('admin.')->group(function () {
    // ....    


});

// 2. Custom routes for Frontend area
foreach (Language::get_active_languages() as $language) {
    if ($language->is_default == 1) {
        // DEFAULT LANGUAGE ROUTES

        
    } else {
        // OTHER LANGUAGES

        
    }
}
