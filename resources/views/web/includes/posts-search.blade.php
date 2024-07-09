@if ($config->tpl_posts_show_top_search_bar ?? null)
    <div class="style_posts">
        <section class="search_bar m-0 p-4">
            <div class="col-md-4 offset-md-4">
                <form methpd="get" action="{{ route('posts.search', ['lang' => getRouteLang()]) }}">
                    <input type="text" class="form-control form-control-lg" name="s" required placeholder="{{ __('Search') }}" value="{{ $s ?? null }}">
                </form>
            </div>
        </section>
    </div>
@endif
