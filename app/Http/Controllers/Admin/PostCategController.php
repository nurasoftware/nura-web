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

use App\Models\Post;
use App\Models\PostCateg;
use App\Models\Upload;
use App\Models\Language;
use App\Models\ThemeMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostCategController extends Controller
{

    /**
     * Display all resources
     */
    public function index(Request $request)
    {

        $search_lang_id = $request->search_lang_id;
        $search_terms = $request->search_terms;
        $count_categories = PostCateg::count();

        $categories = PostCateg::with('childCategories', 'language')->whereNull('parent_id')
            ->orderByDesc('posts_categ.active')
            ->orderBy('posts_categ.position')
            ->orderBy('posts_categ.title');

        if ($search_lang_id) $categories = $categories->where('lang_id', $search_lang_id);
        if ($search_terms) $categories = $categories->where('posts_categ.title', 'like', "%$search_terms%");

        $categories = $categories->paginate(50);
        
        return view('admin.index', [
            'view_file' => 'posts.categories',
            'active_menu' => 'posts',
            'menu_section' => 'categ',
            'categories' => $categories,
            'count_categories' => $count_categories,
            'search_terms' => $search_terms,
            'search_lang_id' => $search_lang_id,
        ]);
    }


    /**
     * Create new resource
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.posts.categ'))
                ->withErrors($validator)
                ->withInput();
        }

        $lang_id = $request->lang_id ?? Language::get_default_language()->id;

        // if parent, then get language from parent categ
        if ($request->parent_id ?? null) {
            $parent_categ = PostCateg::find($request->parent_id);
            $lang_id = $parent_categ->lang_id;
        }

        if ($request->slug) $slug = Str::slug($request->slug, '-');
        else $slug = Str::slug($request->title, '-');
        if (strlen($slug) < 3) return redirect(route('admin.posts.categ'))->with('error', 'length');

        if (PostCateg::where('slug', $slug)->where('lang_id', $lang_id)->exists()) return redirect(route('admin.posts.categ'))->with('error', 'duplicate');

        // position
        if (!($request->position ?? null)) {
            if (!$request->parent_id) $last_categ = PostCateg::whereNull('parent_id')->where('lang_id', $lang_id)->orderByDesc('position')->first();
            else $last_categ = PostCateg::where('parent_id', $request->parent_id)->where('lang_id', $lang_id)->orderByDesc('position')->first();
            $last_pos = $last_categ->position ?? 0;
            $next_pos = $last_pos + 1;
        } else $next_pos = $request->position;
        
        $categ = PostCateg::create([
            'lang_id' => $lang_id,
            'title' => $request->title,
            'parent_id' => $request->parent_id ?? null,
            'slug' => $slug,
            'description' => $request->description,
            'active' => $request->has('active') ? 1 : 0,
            'position' => $next_pos,
            'icon' => $request->icon,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,            
        ]);

        // process image        
        if ($request->hasFile('image')) {
            $image_db = Upload::StoreImage($request, 'image');
            PostCateg::where('id', $categ->id)->update(['image' => $image_db]);
        }

        PostCateg::regenerate_tree_ids();
        PostCateg::recount_categ_items($categ->id);

        return redirect($request->Url())->with('success', 'created');
    }


    /**
     * Update the specified resource     
     */
    public function update(Request $request)
    {

        // disable action in demo mode:
        if (config('app.demo_mode')) return redirect(route('admin'))->with('error', 'demo');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) return redirect(route('admin.posts.categ'))->withErrors($validator)->withInput();

        $lang_id = $request->lang_id ?? Language::get_default_language()->id;

        // if parent, then get language from parent categ
        if ($request->parent_id ?? null) {
            $parent_categ = PostCateg::find($request->parent_id);
            $lang_id = $parent_categ->lang_id;
        }

        if ($request->slug) $slug = Str::slug($request->slug, '-');
        else $slug = Str::slug($request->title, '-');
        if (strlen($slug) < 3) return redirect(route('admin.posts.categ'))->with('error', 'length');
        if ($request->slug == 'uncategorized') $slug = 'uncategorized';

        if (PostCateg::where('slug', $slug)->where('lang_id', $lang_id)->where('id', '!=', $request->id)->exists()) return redirect(route('admin.posts.categ'))->with('error', 'duplicate');

        // position
        if (!($request->position ?? null)) {
            if (!$request->parent_id) $last_categ = PostCateg::whereNull('parent_id')->where('lang_id', $lang_id)->where('id', '!=', $request->id)->orderByDesc('position')->first();
            else $last_categ = PostCateg::where('parent_id', $request->parent_id)->where('lang_id', $lang_id)->where('id', '!=', $request->id)->orderByDesc('position')->first();
            $last_pos = $last_categ->position ?? 0;
            $next_pos = $last_pos + 1;
        } else $next_pos = $request->position;

        PostCateg::where('id', $request->id)->update([
            'lang_id' => $lang_id,
            'title' => $request->title,
            'parent_id' => $request->parent_id ?? null,
            'slug' => $slug,
            'description' => $request->description,
            'active' => $request->has('active') ? 1 : 0,
            'position' => $next_pos,
            'icon' => $request->icon,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        $categ = PostCateg::find($request->id);
        PostCateg::where('parent_id', $categ->id)->update(['lang_id' => $lang_id]);
        Post::where('categ_id', $categ->id)->update(['lang_id' => $lang_id]);

        // process image        
        if ($request->hasFile('image')) {
            $image_db = Upload::storeImage($request, 'image');
            PostCateg::where('id', $request->id)->update(['image' => $image_db]);
        }

        PostCateg::regenerate_posts_url($request->id);
        PostCateg::regenerate_tree_ids();
        PostCateg::recount_all_categs_items();

        // regenerate menu links (if menu contains categories)
        ThemeMenu::generate_menu_links();

        return redirect(route('admin.posts.categ'))->with('success', 'updated');
    }


    /**
     * Remove the specified resource
     */
    public function destroy(Request $request)
    {
        // disable action in demo mode:
        if (config('app.demo_mode')) return redirect(route('admin'))->with('error', 'demo');

        $categ = PostCateg::find($request->id);
        if(! $categ) return redirect(route('admin.posts.categ'));

        Post::where('categ_id', $request->id)->update(['categ_id' => null]);
        PostCateg::where('id', $request->id)->delete();
        PostCateg::where('parent_id', $request->id)->delete();
        
        PostCateg::regenerate_tree_ids();
        PostCateg::recount_all_categs_items();

        return redirect(route('admin.posts.categ'))->with('success', 'deleted');
    }


    /**
     * Ajax sortable
     */
    public function sortable(Request $request)
    {

        $i = 1;

        $items = $request->all();

        foreach ($items['item'] as $key => $value) {

            $categ_lang_id = PostCateg::where('id', $value)->value('lang_id');

            PostCateg::where('id', $value)->where('lang_id', $categ_lang_id)->update([
                    'position' => $i,
                ]);

            $i++;
        }
    }
}
