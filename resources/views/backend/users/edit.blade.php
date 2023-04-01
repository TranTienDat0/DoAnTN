@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Edit User</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Name</label>
                    <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                        value="{{ $user->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">Address</label>
                    <input id="inputEmail" type="text" name="address" placeholder="Enter email"
                        value="{{ $user->address }}" class="form-control">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhone" class="col-form-label">Phone</label>
                    <input id="inputPhone" type="text" name="phone" placeholder="Enter phone"
                        value="{{ $user->phone }}" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @php
                    $roles = DB::table('users')
                        ->select('role')
                        ->where('id', $user->id)
                        ->get();
                @endphp
                <div class="form-group">
                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-----Select Role-----</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->role }}" {{ $role->role == '1' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="{{ $role->role }}" {{ $role->role == '0' ? 'selected' : '' }}>User
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
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
