<option value="{{ $categ->id }}">@for ($i = 1; $i < $loop->depth; $i++)---@endfor {{ $categ->title }} @if(count($languages)>1) ({{ $categ->language->name }}) @endif</option>

@if (count($categ->children) > 0)

	@foreach($categ->children as $categ)
	@include('admin.posts.loops.categories-add-select-loop', $categ)
	@endforeach

@endif