<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Block;
use App\Models\BlockContent;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\TemplateMenu;
use App\Models\User;

class RecycleBinController extends Controller
{
    public function index()
    {
        $rbFormsCount = Contact::onlyTrashed()->count();
        $rbPagesCount = Page::onlyTrashed()->count();
        $rbAccountsCount = User::onlyTrashed()->count();

        return view('admin.index', [
            'view_file' => 'recycle-bin.index',
            'active_menu' => 'recycle_bin',
            'rbFormsCount' => $rbFormsCount ?? 0,
            'rbPagesCount' => $rbPagesCount ?? 0,
            'rbAccountsCount' => $rbAccountsCount ?? 0,
        ]);
    }


    public function module(Request $request)
    {
        $module = $request->module;
        if (!($module == 'contact' || $module == 'pages' || $module == 'accounts')) return redirect(route('admin.recycle_bin'));

        // DELETED ACCOUNTS
        if ($module == 'accounts') {
            $deletedItemsCount = User::onlyTrashed()->count();

            $search_terms = $request->search_terms;

            $items = User::onlyTrashed();

            if ($search_terms) $items = $items->where(function ($query) use ($search_terms) {
                $query->where('users.name', 'like', "%$search_terms%")
                    ->orWhere('users.email', 'like', "%$search_terms%");
            });

            $items = $items->orderByDesc('id')->paginate(25);
        }

        // DELETED CONTACT MESSAGES
        if ($module == 'contact') {
            $deletedItemsCount = Contact::onlyTrashed()->count();
            $search_terms = $request->search_terms;
            $search_status = $request->search_status;
            $search_replied = $request->search_replied;
            $search_important = $request->search_important;

            $items = Contact::onlyTrashed();

            if ($search_status == 'unread')
                $items = $items->whereNull('read_at');
            if ($search_status == 'read')
                $items = $items->whereNotNull('read_at');

            if ($search_replied == 'yes')
                $items = $items->whereNotNull('responded_at');
            if ($search_replied == 'no')
                $items = $items->whereNull('responded_at');

            if ($search_important == '1')
                $items = $items->where('is_important', 1);

            if ($search_terms) $items = $items->where(function ($query) use ($search_terms) {
                $query->where('name', 'like', "%$search_terms%")
                    ->orWhere('email', 'like', "%$search_terms%")
                    ->orWhere('subject', 'like', "%$search_terms%");
            });

            $items = $items->orderByDesc('id')->paginate(25);
        }


        // DELETED PAGES
        if ($module == 'pages') {
            $deletedItemsCount = Page::onlyTrashed()->count();

            $search_terms = $request->search_terms;

            $items = Page::with('author', 'parent', 'translations')->onlyTrashed();

            if ($search_terms) {
                $items = Page::whereHas('translations', function ($query) use ($search_terms) {
                    $query->where('title', 'like', "%$search_terms%");
                });
            }

            $items = $items->orderByDesc('id')->paginate(25);
        }


        return view('admin.index', [
            'view_file' => 'recycle-bin.' . $module,
            'active_menu' => 'recycle_bin',
            'deletedItemsCount' => $deletedItemsCount ?? 0,
            'items' => $items ?? null,

            // Search (for all modules):
            'search_terms' => $search_terms ?? null, //posts / pages
            'search_status' => $search_status ?? null,
            'search_replied' => $search_replied ?? null,
            'search_important' => $search_important ?? null,
        ]);
    }



    public function single_action(Request $request)
    {
        $module = $request->module;
        if (!($module == 'contact' || $module == 'pages' || $module == 'accounts')) return redirect(route('admin.recycle_bin'));

        // ACCOUNTS
        if ($module == 'accounts') {
            if ($request->action == 'delete') User::where('id', $request->id)->forceDelete();
            if ($request->action == 'restore') User::where('id', $request->id)->restore();
        }

        // CONTACT MESSAGES
        if ($module == 'contact') {
            if ($request->action == 'delete') Contact::where('id', $request->id)->forceDelete();
            if ($request->action == 'restore') Contact::where('id', $request->id)->restore();
        }

        // PAGES
        if ($module == 'pages') {
            if ($request->action == 'delete') {
                $page = Page::withTrashed()->where('id', $request->id)->first();
                if (!$page) return redirect(route('admin.recycle_bin'));

                // delete content blocks
                $blocks = Block::where('module', 'pages')->where('content_id', $request->id)->get();
                foreach ($blocks as $block) {
                    Block::where('id', $block->id)->delete();
                    BlockContent::where('block_id', $block->id)->delete();
                }

                Page::where('parent_id', $request->id)->update(['parent_id' => null]);
                TemplateMenu::where('type', 'page')->where('value', $request->id)->delete();
                Page::where('id', $request->id)->forceDelete();
                PageContent::where('page_id', $request->id)->delete();

                //DriveFile::deleteModuleItemFiles('pages', $request->id);

                // regenerate menu links for each language and store in cache config
                TemplateMenu::generate_menu_links();
            }
            if ($request->action == 'restore') Page::where('id', $request->id)->restore();
        }


        if (($request->return_to ?? null) == 'recycle_bin')
            return redirect(route('admin.recycle_bin.module', ['module' => $module]))->with('success', $request->action ?? null);
        elseif (($request->return_to ?? null) == 'contact')
            return redirect(route('admin.contact'))->with('success', $request->action ?? null);
        else return redirect(route('admin.recycle_bin'))->with('success', $request->action ?? null);
    }



    public function multiple_action(Request $request)
    {
        $module = $request->module;
        if (!($module == 'contact' || $module == 'pages' || $module == 'accounts')) return redirect(route('admin.recycle_bin'));

        // ACCOUNTS
        if ($module == 'accounts') {
            foreach ($request->items_checkbox as $item_id) {
                if ($request->action == 'multiple_delete') User::where('id', $item_id)->forceDelete();
                if ($request->action == 'multiple_restore') User::where('id', $item_id)->restore();
            }
        }

        // CONTACT MESSAGES
        if ($module == 'contact') {
            foreach ($request->items_checkbox as $item_id) {
                if ($request->action == 'multiple_delete') Contact::where('id', $item_id)->forceDelete();
                if ($request->action == 'multiple_restore') Contact::where('id', $item_id)->restore();
            }
        }

        // PAGES
        if ($module == 'pages') {
            foreach ($request->items_checkbox as $item_id) {
                if ($request->action == 'multiple_delete') {
                    $page = Page::withTrashed()->where('id', $item_id)->first();
                    if (!$page) return redirect(route('admin.recycle_bin'));

                    // delete content blocks
                    $blocks = Block::where('module', 'pages')->where('content_id', $item_id)->get();
                    foreach ($blocks as $block) {
                        Block::where('id', $block->id)->delete();
                        BlockContent::where('block_id', $block->id)->delete();
                    }

                    Page::where('parent_id', $item_id)->update(['parent_id' => null]);
                    TemplateMenu::where('type', 'page')->where('value', $item_id)->delete();
                    Page::where('id', $item_id)->forceDelete();
                    PageContent::where('page_id', $item_id)->delete();

                    //DriveFile::deleteModuleItemFiles('pages', $item_id);

                    // regenerate menu links for each language and store in cache config
                    TemplateMenu::generate_menu_links();
                }
                if ($request->action == 'multiple_restore') Page::where('id', $item_id)->update(['deleted_at' => null]);
            }
        }

        return redirect(route('admin.recycle_bin.module', ['module' => $module]))->with('success', $request->action ?? null);
    }
}
