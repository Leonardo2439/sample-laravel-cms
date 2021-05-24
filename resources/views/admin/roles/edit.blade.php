<x-admin-master>
    @section('content')

    @if (session()->has('role-updated'))
        <div class="alert alert-success">
            {{ session('role-updated') }}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <h2>Edit Role: {{$role->name}}</h2>

            <form action="{{route('roles.update', $role)}}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$role->name}}">
                </div>

                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-lg-12">
            @if ($permissions->isNotEmpty())

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Attach</th>
                                    <th>Detach</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Options</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Detach</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach ($permissions as $k => $permission)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="" id=""
                                            {{ ( isset($role->permissions[$k])) && ($role->permissions[$k]->slug) == $permission->slug ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->slug }}</td>
                                    <td>
                                        <form action="{{ route('role.permission.attach', $role) }}" method="post">
                                            @csrf
                                            @method('put')

                                            <input type="hidden" name="permissionId" value="{{$permission->id}}">

                                            <button type="submit" class="btn btn-primary"
                                                {{ $role->permissions->contains($permission) ? 'disabled' : '' }}>
                                                Attach
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('role.permission.detach', $role) }}" method="post">
                                            @csrf
                                            @method('put')

                                            <input type="hidden" name="permissionId" value="{{$permission->id}}">

                                            <button type="submit" class="btn btn-danger"
                                                {{ !$role->permissions->contains($permission) ? 'disabled' : '' }}>
                                                Detach
                                            </button>
                                        </form> 
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>

    @endsection
</x-admin-master>