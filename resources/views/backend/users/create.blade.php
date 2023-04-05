@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Add User</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Name</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">Email</label>
                    <input id="inputEmail" type="text" name="email_address" value="{{ old('email_address') }}" placeholder="Enter email"
                        class="form-control">
                    @error('email_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-form-label">Password</label>
                    <input id="inputPassword" type="password" name="password" value="{{ old('password') }}" placeholder="Enter password"
                        class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address" class="col-form-label">Address</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Enter address" class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="col-form-label">Phone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Image</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <input type="file" name="image" disabled />
                        </span>
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-----Select Role-----</option>
                        <option>Admin</option>
                        <option>User</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
