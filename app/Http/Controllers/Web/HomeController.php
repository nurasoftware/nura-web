<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\ConfigLang;
use App\Models\Page;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Config::config()->website_disabled ?? null) {
                if (!Auth::user()) return redirect(route('login'));

                $role = Auth::user()->role ?? null;
                if ($role == 'admin') return redirect(route('admin.dashboard'));
                elseif ($role == 'internal') return redirect(route('internal.dashboard'));
                elseif ($role == 'user') return redirect(route('user'));
            }

            if ((Config::config()->website_maintenance_enabled ?? null)) {
                if (!(Auth::user()->role ?? null) == 'admin') return redirect(route('maintenance'));
            }

            return $next($request);
        });
    }


    /**
     * Homepage
     */
    public function index()
    {        
        $page = Page::with('active_language_content')->where('is_homepage', 1)->first();

        // update hits
        Page::where('id', $page->id)->increment('hits');

        return view('web.page', [
            'page' => $page,
            'module' => 'pages',
            'content_id' => $page->id,

            'meta_title' => $page->active_language_content->meta_title ?? (ConfigLang::config()->website_label ?? null) ?? $page->active_language_content->title ?? 'Home',
            'meta_description' => $page->active_language_content->meta_description ?? (ConfigLang::config()->website_label ?? null) ?? $page->active_language_content->title ?? 'Home',
        ]);
    }
};
