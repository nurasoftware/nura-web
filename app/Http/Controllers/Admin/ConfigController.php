<?php

namespace App\Http\Controllers\Admin;

/*
 * NuraWeb - Free and Open Source Website Builder
 *
 * Copyright (C) 2024  Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 *
 * LICENSE:
 * NuraWeb is licensed under the GNU General Public License v3.0
 * Permissions of this strong copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.
 *    
 * @copyright   Copyright (c) 2024, Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 * @license     https://opensource.org/licenses/GPL-3.0  GPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <contact@nurasoftware.com>
 * 
 * 
 * IMPORTANT: DO NOT edit this file manually. All changes will be lost after software update.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Models\Upload;
use App\Models\Contact;
use App\Models\Config;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Language;
use App\Models\ConfigLang;
use App\Models\ThemeMenu;
use App\Models\ThemeStyle;
use App\Models\Tools;
use Artisan;
use Str;

class ConfigController extends Controller
{
    

    /**
     * Config settings.
     */
    public function module(Request $request)
    {
        if (!(Auth::user()->role == 'admin')) return redirect(route('admin'));

        $module = $request->module;
        if (!$module) $module = 'general';
        if (!($module == 'general' || $module == 'email' || $module == 'website' || $module == 'contact' || $module == 'integration' || $module == 'modules' || $module == 'icons' || $module == 'whitelabel')) return redirect(route('admin'));

        if ($module == 'general') {
            $site_labels = array();

            foreach (Language::get_languages() as $lang) {
                $site_labels[$lang->id]['site_label']  = ConfigLang::get_config($lang->id, 'site_label');
            }
        }

        if ($module == 'contact') {
            $contact_custom_text = array();
            foreach (Language::get_languages() as $lang) {
                $contact_custom_text[$lang->id]['lang'] = $lang;
                $contact_custom_text[$lang->id]['content']  = ConfigLang::get_config($lang->id, 'contact_custom_text');
            }
        }

        return view('admin.index', [
            'view_file' => 'config.config-' . $module,
            'active_menu' => 'config',
            'active_submenu' => 'config.settings',
            'active_tab' => $module,

            'contact_custom_text' => $contact_custom_text ?? null,
            'site_labels' => $site_labels ?? null, // used in "general" tab
        ]);
    }

    /**
     * Process config settings
     */
    public function update_module(Request $request)
    {
        if (!(Auth::user()->role == 'admin')) return redirect(route('admin'));

        // disable action in demo mode:
        if (config('app.demo_mode')) return redirect(route('admin'))->with('error', 'demo');


        $module = $request->module;

        if (!$module) $module = 'general';

        if (!($module == 'general' || $module == 'email' || $module == 'contact' || $module == 'integration' || $module == 'modules' || $module == 'icons' || $module == 'whitelabel')) return redirect(route('admin'));

        $inputs = $request->except('_token');

        if ($module == 'general') {
            foreach (Language::get_languages() as $lang) {
                ConfigLang::update_config($lang->id, 'site_label', $request['site_label_' . $lang->id] ?? null);
            }
        }

        if ($request->module == 'contact') {
            $langs = Language::get_languages();
            foreach ($langs as $lang) {
                ConfigLang::update_config($lang->id, 'contact_custom_text', $request['contact_custom_text_' . $lang->id]);
            }
        }

        Config::update_config($inputs);

        return redirect(route('admin.config', ['module' => $module]))->with('success', 'updated');
    }



    /**
     * Show the tools page.
     */
    public function tools()
    {
        if (!(Auth::user()->role == 'admin')) return redirect(route('admin'));

        return view('admin.index', [
            'view_file' => 'core.tools',
            'active_menu' => 'system',
            'active_submenu' => 'tools',
            'pagename' => 'Tools',
        ]);
    }


    /**
     * Tools action
     */
    public function tools_action(Request $request)
    {
        if (!(Auth::user()->role == 'admin')) return redirect(route('admin'));

        $action = $request->action;

        if ($action == 'sendTestEmail') {
            $email = $request->email;
            if (!$email)
                return redirect(route('admin.tools'));
            Mail::to($email)->send(new TestEmail());
            return redirect(route('admin.tools'))->with('success', 'test_email_sent');
        }

        return redirect(route('admin.tools'));
    }


    public function update_tables(Request $request)
    {

        Artisan::call("migrate");

        exit('Done');
    }
      
}
