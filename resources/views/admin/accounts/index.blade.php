@if ($openmodal == 1)
    <script>
        $(document).ready(function() {
            $('#create-account').modal('show');
        });
    </script>
@endif

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Registered users') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12 col-sm-5 col-md-6 order-md-1 order-first">
                <div class="card-title">
                    {{ __('Accounts') }} ({{ $accounts->total() ?? 0 }})
                </div>

                @if (($config->registration_disabled ?? null) || ($config->registration_verify_email_disabled ?? null))
                    <span class="fw-bold text-danger ms-3">
                        <i class="bi bi-exclamation-triangle"></i>
                        @if ($config->registration_disabled ?? null)
                            {{ __('Registration is disabled') }}
                        @endif
                        @if ($config->registration_verify_email_disabled ?? null)
                            {{ __('Email verification for registration is disabled') }}
                        @endif
                    </span>

                    <a href="{{ route('admin.config', ['module' => 'registration']) }}">[{{ __('Change') }}]</a>
                    </span>
                @endif
            </div>


            <div class="col-12 col-sm-7 col-md-6 order-md-2 order-last">
                <div class="float-end">
                    <div class="dropdown float-end ms-3">
                        <button class="btn btn-secondary  dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="min-width: 200px;">
                            <li><a class="dropdown-item" href="{{ route('admin.config', ['module' => 'registration']) }}">{{ __('Registration') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.recycle_bin.module', ['module' => 'accounts']) }}">{{ __('Deleted accounts') }}</a></li>
                        </ul>
                    </div>

                    <div class="float-end">
                        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#create-account"><i class="bi bi-plus-circle"></i> {{ __('Create account') }}</a>
                    </div>


                    @include('admin.accounts.modals.create-account')

                </div>
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

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'created')
                    {{ __('Created') }}
                @endif
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
                @if ($message == 'deleted')
                    {{ __('Deleted') }}
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

        <section>
            <form action="{{ route('admin.accounts.index') }}" method="get" class="row row-cols-lg-auto g-3 align-items-center">

                <div class="col-12">
                    <input type="text" name="search_terms" placeholder="Search user" class="form-control @if ($search_terms) is-valid @endif" value="{{ $search_terms ?? null }}" />
                </div>

                <div class="col-12">
                    <select name="search_role" class="form-select @if ($search_role) is-valid @endif">
                        <option selected="selected" value="">- {{ __('Any role') }} -</option>
                        <option @if ($search_role == 'internal') selected @endif value="internal"> {{ __('Internal') }}</option>
                        <option @if ($search_role == 'admin') selected @endif value="admin"> {{ __('Administrator') }}</option>
                    </select>
                </div>

                <div class="col-12">
                    <select name="search_email_verified" class="form-select @if ($search_email_verified) is-valid @endif">
                        <option selected="selected" value="">- {{ __('Any email status') }} -</option>
                        <option @if ($search_email_verified == 'yes') selected @endif value="yes"> {{ __('Email verified accounts') }}</option>
                        <option @if ($search_email_verified == 'no') selected @endif value="no"> {{ __('Email not verified accounts') }}</option>
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-secondary me-2" type="submit"><i class="bi bi-check2"></i> {{ __('Apply') }}</button>
                    <a title="{{ __('Reset') }}" class="btn btn-light" href="{{ route('admin.accounts.index') }}"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>

            </form>
        </section>

        <div class="mb-3"></div>

        <div class="table-responsive-md">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>{{ __('Details') }}</th>
                        <th width="180">{{ __('Role') }}</th>
                        <th width="160">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($accounts as $account)
                        <tr>
                            <td>
                                @if (!$account->email_verified_at)
                                    <span class="float-end ms-2 badge bg-warning">{{ __('Email not verified') }}</span>
                                @endif

                                <span class="float-start me-3"><img style="max-width:80px; height:auto;" class="img-fluid rounded" src="{{ avatar($account->id) }}" /></span>

                                @php
                                    if ($account->last_activity_at) {
                                        $last_activity_minutes = round(abs(strtotime(now()) - strtotime($account->last_activity_at)) / 60, 2);
                                    }
                                @endphp

                                <div class="fw-bold mb-2 fs-5">
                                    <a href="{{ route('admin.accounts.show', ['id' => $account->id]) }}">{{ $account->name }}</a>
                                    @if ($account->last_activity_at && $last_activity_minutes < 10)
                                        <i title="Online" class="bi bi-circle-fill text-success fs-6"></i>
                                    @endif
                                </div>

                                {{ $account->email }}
                                <div class="small text-muted">
                                    {{ __('ID') }}: {{ strtoupper($account->id) }} |
                                    {{ __('Registered') }}: {{ date_locale($account->created_at, 'datetime') }} |
                                    {{ __('Last activity') }}: @if ($account->last_activity_at)
                                        {{ date_locale($account->last_activity_at, 'datetime') }}
                                    @else
                                        <span class="text-danger">{{ __('never') }}</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @include('admin.includes.account-role-switch', ['role' => $account->role])
                            </td>

                            <td>
                                <div class="d-grid gap-2">

                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.accounts.show', ['id' => $account->id]) }}">{{ __('Manage user') }}</a>

                                    @if (Auth::user()->id != $account->id)
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $account->id }}" class="btn btn-danger btn-sm">{{ __('Delete') }}</a>
                                        <div class="modal fade confirm-{{ $account->id }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ConfirmDeleteLabel">{{ __('Confirm delete') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ __('Are you sure you want to delete this account?') }}
                                                        <div class="mt-3 text-info">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                            {!! __('Note: <b>Account details and activity are not removed from database</b>. You can recover this accout from deleted accounts page. Account holder can not login into a deleted account.') !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('admin.accounts.show', ['id' => $account->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button type="submit" class="btn btn-danger">{{ __('Yes. Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{ $accounts->appends(['search_terms' => $search_terms, 'search_email_verified' => $search_email_verified, 'search_role' => $search_role])->links() }}

    </div>

</div>
