<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades;
use Illuminate\View\View;
use App\Models\Language;
use App\Models\Contact;
use App\Models\Config;
use App\Models\ConfigLang;
use App\Models\ThemeConfig;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Facades\View::composer('*', function (View $view) {
            $view->with('languages', Language::get_languages()); // active and inactive
            $view->with('active_languages', Language::get_active_languages()); // active languages
            $view->with('site_text_dir', Language::get_active_language()->dir);
          
            // general config
            $config = Config::config();
            $view->with('config', $config);

            // theme config
            $theme_config = ThemeConfig::config();
            $view->with('theme_config', $theme_config);

            // config depending on language
            $config_lang = ConfigLang::config();
            $view->with('config_lang', $config_lang);

            // Views variables
            $view->with('locale', config('app.locale'));                    

            if (Auth::user()) {
                if (Auth::user()->role == 'admin') {
                    // count unread forms messages 
                    $count_unread_contact_messages = Contact::whereNull('read_at')->whereNull('deleted_at')->count();
                    $view->with('count_unread_contact_messages', $count_unread_contact_messages);
                }
            }
        });
    }

}
