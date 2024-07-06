@include('admin.includes.trumbowyg-assets')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pages.show', ['id' => $page->id]) }}">
                            @if ($page->is_homepage == 0)
                                {{ $page->content->title }}
                            @else
                                {{ __('Homepage') }}
                            @endif
                        </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Page content') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">
        <div class="row">

            <div class="col-12 mb-3">
                @include('admin.pages.includes.menu-page')
            </div>

            <div class="col-12">
                @if ($page->active == 1)
                    <div class="float-end ms-2">
                        @if (count($languages) > 1)
                            <div class="dropdown">
                                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-box-arrow-up-right"></i> {{ __('Preview page') }}
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach ($languages as $preview_lang)
                                        @if ($page->is_homepage == 1)
                                            <li><a class="dropdown-item" target="_blank" href="{{ route('home') }}">{{ $preview_lang->name }}</a></li>
                                        @else
                                            <li><a class="dropdown-item" target="_blank" href="{{ page($page->id, $preview_lang->id)->url }}">{{ $preview_lang->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a target="_blank" href="{{ page($page->id)->url }}" class="btn btn-light"><i class="bi bi-box-arrow-up-right"></i> {{ __('Preview page') }}</a>
                        @endif
                    </div>
                @endif

                @if ($page->deleted_at)
                    <div class="text-danger fw-bold mb-2">
                        {{ __('This item is in the Trash.') }}
                    </div>
                @endif

                @if ($page->active == 0)
                    <div class="fw-bold text-danger mt-1 mb-2">
                        <i class="bi bi-exclamation-circle"></i> {{ __('Page is not published.') }}
                    </div>

                    @can('update', $page)
                        <div class="form-check form-switch mt-2" id="publishSwitchDiv">
                            <input class="form-check-input" type="checkbox" role="switch" id="publishSwitch">
                            <label class="form-check-label" for="publishSwitch">{{ __('Publish page') }}</label>
                        </div>

                        <div class="fw-bold text-success" id="updatedResult"></div>

                        <script>
                            function onToggle() {
                                $('#publishSwitchDiv :checkbox').change(function() {
                                    if (this.checked) {
                                        updateStatus(1);
                                    } else {
                                        updateStatus(0);
                                    }
                                });
                            }

                            function updateStatus(status_val) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('admin.pages.ajaxPublishSwitch', ['id' => $page->id]) }}",
                                    data: {
                                        toggle_update: true,
                                        status: status_val
                                    },
                                    success: function(result) {
                                        console.log(result);
                                        document.getElementById("updatedResult").innerText = "{{ __('Page published') }}" + result;
                                    }
                                });
                            }

                            $(document).ready(function() {
                                onToggle(); //Update when toggled
                            });
                        </script>
                    @endcan
                @endif


                <div class="card-title">{{ __('Update content') }} - @if ($page->is_homepage)
                        {{ __('Home page') }}
                    @else
                        {{ $page->content->title ?? null }}
                    @endif
                </div>

                @if (($config->tpl_home_content_source ?? null) == 'last_posts')
                    <div class="text-danger fw-bold"><i class="bi bi-info-circle"></i> {{ 'Warning. Home page content is set to "List of the last posts". You must set to "Manually build home page with blocks".' }} <a
                            href="{{ route('admin.config', ['module' => 'general']) }}">{{ __('Change') }}</a></div>
                @endif


                <div class="form-text">{{ __('Click on "Add blocs" to add content blocks (text, images, columns, ...)') }}</div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'duplicate')
                    {{ __('Error. Page with this slug already exists') }}
                @endif
                @if ($message == 'length2')
                    {{ __('Error. Page slug must be minimum 3 characters') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'created')
                    {{ __('Created') }}
                @endif
                @if ($message == 'deleted')
                    {{ __('Deleted') }}
                @endif
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
            </div>
        @endif

        <div class="row">

            <div class="col-12">
                <div class="builder-col sortable" id="sortable_top">
                    @if (!$page->deleted_at)
                        @can('update', $page)
                            <div class="mb-4 text-center">
                                <a class="btn btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#addBlock"><i class="bi bi-plus-circle"></i>
                                    {{ __('Add content block') }}</a>
                            </div>
                        @endcan
                    @endif

                    @foreach (content_blocks('pages', $page->id, $show_hidden = 1) as $block)
                        <div class="builder-block movable" id="item-{{ $block->id }}">
                            <div class="float-end ms-2">

                                @if ($block->hide == 1)
                                    <div class="badge bg-danger fs-6 me-2">{{ __('Hidden') }}</div>
                                @endif

                                <a href="{{ route('admin.blocks.show', ['id' => $block->id]) }}" class="btn btn-primary">{{ __('Manage content') }}</a>

                                @if (!$page->deleted_at)
                                    @can('update', $page)
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $block->id }}" class="btn btn-outline-danger ms-2"><i class="bi bi-trash"></i></a>
                                        <div class="modal fade confirm-{{ $block->id }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ConfirmDeleteLabel">{{ __('Confirm delete') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ __('Are you sure you want to remove this block from this page? Block content will be deleted also.') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('admin.pages.content.delete', ['id' => $page->id, 'block_id' => $block->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button type="submit" class="btn btn-danger">{{ __('Yes. Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                @endif
                            </div>

                            @if ($block->label)
                                <div class="listing">{{ $block->label }}</div>
                            @endif

                            <b>
                                @include('admin.includes.block_type_label', ['type' => $block->type])
                            </b>

                            <div class="small text-muted">
                                ID: {{ $block->id }}. @if ($block->updated_at)
                                    {{ __('Updated at') }}: {{ date_locale($block->updated_at, 'datetime') }}
                                @endif
                            </div>

                            @if ($block->type == 'editor')
                                <div class="line-clamp-4 mt-1 small">{!! substr(strip_tags($block->content->content), 0, 1000) !!}</div>
                            @endif

                            @if ($block->type == 'text')
                                @if ($block->content ?? null)
                                    <div class="mt-1 small">
                                        @php $content_array = unserialize($block->content->content) @endphp
                                        @if ($content_array['title'] ?? null)
                                            <b>{{ $content_array['title'] }}</b></small>
                                        @endif
                                        @if ($content_array['subtitle'] ?? null)
                                            <br><b>{{ $content_array['subtitle'] }}</b></small>
                                        @endif
                                        @if ($content_array['content'] ?? null)
                                            <div class="line-clamp-4 mt-1">{{ $content_array['content'] }}</div>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            @if ($block->type == 'image')
                                @if ($block->content ?? null)
                                    <div class="mt-1 small">
                                        @php $content_array = unserialize($block->content->content) @endphp
                                        @if ($content_array['image'] ?? null)
                                            <img class="img-fluid" style="max-height: 100px;" src="{{ thumb($content_array['image']) }}">
                                        @endif
                                        @if ($content_array['caption'] ?? null)
                                            <br><b>{{ $content_array['caption'] }}</b>
                                        @endif
                                        @if ($content_array['url'] ?? null)
                                            <div class="mt-1"><a target="_blank" href="{{ $content_array['url'] }}">{{ $content_array['url'] }}</div>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            @if ($block->type == 'gallery')
                                @if ($block->content ?? null)
                                    <div class="mt-1 small">
                                        @php $contents_array = unserialize($block->content->content) @endphp
                                        @foreach ($contents_array as $content_array)
                                            @if ($content_array['image'] ?? null)
                                                <img class="img-fluid me-2" style="max-height: 100px;" src="{{ thumb($content_array['image']) }}">
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        @include('admin.includes.modal-add-content-block', ['content_id' => $page->id])

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#sortable_top").sortable({
                    axis: 'y',
                    opacity: 0.8,
                    revert: true,

                    update: function(event, ui) {
                        var data = $(this).sortable('serialize');
                        $.ajax({
                            data: data,
                            type: 'POST',
                            url: "{{ route('admin.pages.sortable', ['id' => $page->id]) }}",
                        });
                    }
                });
                $("#sortable_top").disableSelection();

            });
        </script>


    </div>
    <!-- end card-body -->

</div>
