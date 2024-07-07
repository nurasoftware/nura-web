<?php
debug_backtrace() || die('Direct access not permitted');
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="addBlockLabel" aria-hidden="true" id="addBlock">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form method="post" action="{{ route('admin.posts.content.new', ['id' => $post->id]) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="addBlockLabel">{{ __('Add block content') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <p>{{ __('Click to add a content block') }}</p>

                    <div class="row">
                        @foreach (config('nura.posts_blocks') as $key => $type)
                            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6 col-12 mb-4">
                                <input type="radio" name="type" class="radio input-hidden" id="block_{{ $key }}" value="{{ $key }}" required />
                                <label for="block_{{ $key }}">
                                    <div class='text-center'>
                                        <div class="fs-1">{!! $type['icon'] !!}</div>
                                        <div class="mb-2">
                                            {{ $type['label'] }}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-text">{{ __('You can manage block content and settings after you att this block') }}</div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="module" value="posts">
                    <input type="hidden" name="content_id" value="{{ $post->id ?? null }}">
                    <button type="submit" class="btn btn-primary">{{ __('Add block') }}</button>
                </div>

            </form>

        </div>

    </div>

</div>
