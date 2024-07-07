<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

<style>
    .tagify__tag {
        line-height: 1.2em !important;
    }
</style>

@include('admin.includes.trumbowyg-assets')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('New post') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (!$categories)
    <div class="alert alert-danger mt-3">
        {{ __('Warning. You can not add an post because there is not any categoriy added') }}. <a href="{{ route('admin.posts.categ') }}">{{ __('Manage categories') }}</a>
    </div>
@else
    <form action="{{ route('admin.posts.index') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-lg-8 col-md-7 col-sm-12">

                <div class="card">

                    <div class="card-header">

                        <div class="row">

                            <div class="col-12">
                                <h4 class="card-title">{{ __('New Post') }}</h4>
                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <div class="form-group">
                            <label>{{ __('Post title') }}</label>
                            <input class="form-control" name="title" type="text" required>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label>{{ __('Category') }}</label>
                                <select name="categ_id" class="form-select" required>
                                    <option value="">- {{ __('select') }} -</option>
                                    @foreach ($categories as $categ)
                                        @include('admin.posts.loops.categories-add-select-loop', $categ)
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Summary') }}</label>
                            <textarea rows="4" class="form-control" name="summary"></textarea>
                        </div>

                    </div>
                    <!-- end card-body -->

                </div>

            </div>


            <div class="col-lg-4 col-md-5 col-sm-12">

                <div class="card">

                    <div class="card-body">

                        <div class="form-group">
                            <label for="formFile" class="form-label">{{ __('Upload image') }} ({{ __('optional') }})</label>
                            <input class="form-control" type="file" id="formFile" name="image">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Tags') }}</label>
                            <input id="tags" name='tags' class='form-control' placeholder='{{ __('Write some tags') }}' value=''>
                        </div>                     

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="featured" id="checkbox_featured">
                            <label class="form-check-label" for="checkbox_featured">{{ __('Featured') }}</label>
                            <span class="form-text text-muted small">({{ __('Featured posts are displayed first') }})</span>
                        </div>

                        <div class="d-grid gap-2 my-3">
                            <a class="btn btn-light fw-bold" data-bs-toggle="collapse" href="#collapseSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('More settings') }} <i class="bi bi-chevron-down"></i>
                            </a>
                        </div>

                        <div class="collapse" id="collapseSettings">
                            <div class="form-group">
                                <label>{{ __('Custom Meta title') }}</label>
                                <input type="text" class="form-control" name="meta_title" aria-describedby="metaTitleHelp">
                                <small id="metaTitleHelp" class="form-text text-muted">
                                    {{ __('Leave empty to auto generate meta title based on post title') }}
                                </small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Custom Meta description') }}</label>
                                <input type="text" class="form-control" name="meta_description" aria-describedby="metaDescHelp">
                                <small id="metaDescHelp" class="form-text text-muted">
                                    {{ __('Leave empty to auto generate meta description based on post summary') }}
                                </small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Custom slug') }}</label>
                                <input type="text" class="form-control" name="slug" aria-describedby="slugHelp">
                                <small id="slugHelp" class="form-text text-muted">
                                    {{ __('Leave empty to auto generate slug based on post title') }}
                                </small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Search terms') }} ({{ __('separated by comma') }})</label>
                                <input type="text" class="form-control" name="search_terms" aria-describedby="searchHelp">
                                <small id="searchHelp" class="form-text text-muted">
                                    {{ __("Search terms don't appear on website but they are used to find post in search form") }}
                                    <br>
                                    <i class="bi bi-info-circle"></i> {{ __("Note: you don't need to add terms which are in the post title or tags") }}
                                </small>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-gear">{{ __('Save and add content') }}</button>

                        <div class="text-muted mt-3 small"><i class="bi bi-info-circle"></i> {{ __('Post will be saved as draft. You can publish the post after you add content blocks.') }}</div>


                    </div>

                </div>

            </div>

        </div>

    </form>

@endif

<script>
    $(document).ready(function() {

        var input = document.querySelector('#tags'),
            tagify = new Tagify(input, {
                whitelist: [{!! $all_tags ?? null !!}],                
                dropdown: {
                    maxItems: 30, // <- mixumum allowed rendered suggestions
                    classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0, // <- show suggestions on focus
                    closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                }
            })
    });
</script>
