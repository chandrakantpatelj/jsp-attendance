<form action="{{ isset($employee->id) ? route('employee.update', $employee->id) : route('employee.store') }}"
    method="POST">
    @csrf
    @if(isset($employee->id))
    @method('PUT')
    <!-- Update method for existing employee -->
    @else
    @method('POST')
    <!-- Create method for new employee -->
    @endif

    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name', $employee->name ?? '') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email', $employee->email ?? '') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                autocomplete="new-password">
        </div>
    </div>

    <div class="row mb-3">
        <label for="role_id" class="col-md-4 col-form-label text-md-end">{{ __('Select role') }}</label>

        <div class="col-md-6">
            <select name="role_id" id="role_id" class="form-control" required>
                <option value="">Select Role</option>
                <option value="1" {{ (old('role_id', $employee->role_id ?? '') == 1) ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ (old('role_id', $employee->role_id ?? '') == 2) ? 'selected' : '' }}>Employee
                </option>
            </select>
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($employee->id) ? __('Update') : __('Register') }}
            </button>
        </div>
    </div>
</form>