<?php

namespace App\Models;

/*
 * Clevada: #1 Website Builder and Business Suite.
 *
 * Copyright (C) 2024  Chimilevschi Iosif Gabriel, https://clevada.com.
 *
 * LICENSE:
 * Clevada is licensed under the GNU General Public License v3.0
 * Permissions of this strong copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.
 *    
 * @copyright   Copyright (c) 2024, Chimilevschi Iosif Gabriel, https://clevada.com.
 * @license     https://opensource.org/licenses/GPL-3.0  GPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@clevada.com>
 */

use Illuminate\Database\Eloquent\Model;

class PostCateg extends Model
{
    protected $fillable = [
        'lang_id',
        'parent_id',
        'tree_ids',
        'title',
        'slug',
        'description',
        'active',
        'position',
        'meta_title',
        'meta_description',
        'icon',
        'count_items',
        'count_tree_items',
    ];

    protected $table = 'posts_categ';

    protected $appends = ['url'];


    public function posts()
    {
        return $this->hasMany(Post::class, 'categ_id')->where('status', 'published');
    }

    public function getUrlAttribute()
    {
        if ($this->lang_id == get_default_language()->id)
            $post_url = route('posts.categ', ['categ_slug' => $this->slug]);
        else {
            $lang = Language::where('id', $this->lang_id)->first();
            $post_url = route('posts.categ', ['categ_slug' => $this->slug, 'lang' => $lang->code]);
        }

        return $post_url;
    }
    
    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function children()
    {
        return $this->hasMany(PostCateg::class, 'parent_id')->orderBy('position')->orderBy('title');
    }


    public function childCategories()
    {
        return $this->hasMany(PostCateg::class, 'parent_id')->with('children')->orderBy('position')->orderBy('title');
    }


    public function active_children()
    {
        return $this->hasMany(PostCateg::class, 'parent_id')->where('active', 1)->orderBy('position')->orderBy('title');
    }


    public function active_childCategories()
    {
        return $this->hasMany(PostCateg::class, 'parent_id')->where('active', 1)->orderBy('position')->orderBy('title')->with('active_children');
    }


    public static function recount_categ_items($categ_id)
    {
        $count_posts = Post::where('categ_id', $categ_id)->count();

        $q = PostCateg::find($categ_id);
        if ($q) {
            $tree_ids = $q->tree_ids;
            $categ_tree_counter = 0;
            $array_tree = explode(',', $tree_ids);
            foreach ($array_tree as $tree_categ_id) {
                $tree_counter = Post::where('categ_id', $tree_categ_id)->count();
                $categ_tree_counter = $categ_tree_counter + $tree_counter;
            }
        }

        PostCateg::where('id', $categ_id)->update([
            'count_items' => $count_posts ?? 0,
            'count_tree_items' => $categ_tree_counter ?? 0,
        ]);

        return;
    }


    public static function recount_all_categs_items()
    {
        $categs = PostCateg::get();

        foreach ($categs as $categ) {
            $count_posts = Post::where('categ_id', $categ->id)->count();

            $q = PostCateg::find($categ->id);
            if ($q) {
                $tree_ids = $q->tree_ids;
                $categ_tree_counter = 0;

                $array_tree = explode(',', $tree_ids);
                foreach ($array_tree as $tree_categ_id) {
                    $tree_counter = Post::where('categ_id', $tree_categ_id)->count();
                    $categ_tree_counter = $categ_tree_counter + $tree_counter;
                }
            }

            PostCateg::where('id', $categ->id)->update([
                'count_items' => $count_posts ?? 0,
                'count_tree_items' => $categ_tree_counter ?? 0,
            ]);
        }

        return;
    }


    public static function regenerate_tree_ids()
    {
        $all_categories = PostCateg::get();
        foreach ($all_categories as $root) {

            $id = $root->id;

            $tree = array($id);

            $q = PostCateg::where('parent_id', $id)->first();

            if ($q) {
                $tree = array_unique(array_merge($tree, array($q->id)));

                $q2 = PostCateg::where('parent_id', $q->id)->orWhere('parent_id', $q->parent_id)->get();

                foreach ($q2 as $item) {
                    $tree = array_unique(array_merge($tree, array($item->id)));

                    $q3 = PostCateg::where('parent_id', $item->id)->orWhere('parent_id', $item->parent_id)->get();
                    foreach ($q3 as $item2) {
                        $tree = array_unique(array_merge($tree, array($item2->id)));

                        $q4 = PostCateg::where('parent_id', $item2->id)->orWhere('parent_id', $item2->parent_id)->get();
                        foreach ($q4 as $item3) {
                            $tree = array_unique(array_merge($tree, array($item3->id)));

                            $q5 = PostCateg::where('parent_id', $item3->id)->orWhere('parent_id', $item3->parent_id)->get();
                            foreach ($q5 as $item4) {
                                $tree = array_unique(array_merge($tree, array($item4->id)));

                                $q6 = PostCateg::where('parent_id', $item4->id)->orWhere('parent_id', $item4->parent_id)->get();
                                foreach ($q6 as $item5) {
                                    $tree = array_unique(array_merge($tree, array($item5->id)));
                                }
                            }
                        }
                    }
                }
            }

            $values = implode(",", $tree);

            PostCateg::where('id', $id)->update([
                'tree_ids' => $values ?? null,
            ]);
        } // end foreach        


        $inactive_categs = PostCateg::where('active', 0)->get();
        foreach ($inactive_categs as $categ) {
            $inactive_tree = PostCateg::find($categ->id);
            $inactive_tree_ids = $inactive_tree->tree_ids;

            $myArray = explode(',', $inactive_tree_ids);

            foreach ($myArray as $categ_id) {
                PostCateg::where('id', $categ_id)->update(['active' => 0]);
            }
        }

        return;
    }


    public static function regenerate_posts_url($categ_id)
    {
        $categ_posts = Post::where('categ_id', $categ_id)->get();
        foreach ($categ_posts as $post) {
            $url = Post::get_url($post->id);

            Post::where('id', $post->id)->update(['url' => $url]);
        }
        return;
    }

    public static function get_uncategorized_categ_id()
    {
        $categ = PostCateg::where('slug', 'uncategorized')->first();

        return $categ->id ?? null;
    }
}
