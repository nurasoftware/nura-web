<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.accounts.index') }}">{{ __('Accounts') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Update account') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-header">
        <h4 class="card-title">{{ $account->name }}</h4>
    </div>

    <div class="card-body">

        @include('admin.accounts.includes.menu-account')
        <div class="mb-3"></div>

        @if ($account->deleted_at)
            <div class='alert alert-danger mt-3'>{{ __('This account is deleted') }}. <a href="{{ route('admin.recycle_bin.module', ['module' => 'accounts']) }} ">{{ __('View deleted accounts') }}</a></div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'duplicate')
                    {{ __('Error. This email exist') }}
                @endif
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-12">
                @if ($account->avatar)
                    <span class="float-start me-2"><img style="max-height:120px; width:auto;" src="{{ asset('uploads/avatars/' . $account->avatar) }}" /></span>
                @endif
                {{ __('ID') }}: {{ strtoupper($account->id) }} <br>
                {{ __('Registered') }}: {{ date_locale($account->created_at, 'datetime') }} <br>
                {{ __('Last activity') }}: @if ($account->last_activity_at)
                    {{ date_locale($account->last_activity_at, 'datetime') }}
                @else
                    {{ __('never') }}
                @endif
            </div>
        </div>

        <form action="{{ route('admin.accounts.show', ['id' => $account->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>{{ __('Full name') }}</label>
                        <input class="form-control" name="name" type="text" required value="{{ $account->name }}" />
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input class="form-control" name="email" type="email" required value="{{ $account->email }}" />
                    </div>
                </div>

                @if (Auth::user()->id != $account->id)
                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label>{{ __('Role') }}</label>
                            <select name="role" class="form-select" required>
                                <option value="">- {{ __('select') }} -</option>
                                <option @if ($account->role == 'internal') selected @endif value="internal">{{ __('Internal') }}</option>
                                <option @if ($account->role == 'admin') selected @endif value="admin">{{ __('Administrator') }}</option>
                            </select>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="role" value="{{ $account->role }}">
                @endif

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label>{{ __('Change password') }} ({{ __('optional') }})</label>
                        <input class="form-control" name="password" type="password" />
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="formFile" class="form-label">{{ __('Avatar image') }} ({{ __('optional') }})</label>
                        <input class="form-control" type="file" id="formFile" name="avatar">
                    </div>
                </div>

                @if (Auth::user()->id != $account->id)
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="customSwitch2" name="email_verified_at" @if ($account->email_verified_at) checked @endif>
                                <label class="form-check-label" for="customSwitch2">{{ __('Email verified') }}</label>
                            </div>
                            <div class="text-muted small">{{ __('If not checked, user will be prompted to verify email address.') }}</div>
                        </div>
                    </div>
                @endif

            </div>

            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

        </form>

    </div>
    <!-- end card-body -->

</div>
