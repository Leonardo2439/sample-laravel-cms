<x-admin-master>
    @section('content')
        
        <h2>User Profile for : {{ $user->name }}</h2>

        <div class="row">
            <div class="col-sm-6">
                <form action="{{route('user.profile.update', $user->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="mb-4">
                        <img height="50px" class="img-profile rounded-circle" src="{{$user->avatar}}">
                    </div>

                    <div class="form-group">
                        <input type="file" name="avatar" id="avatar">
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" name="username" id="username" 
                        class="form-control @error('username') is-invalid @enderror" 
                        value="{{$user->name}}">

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" >

                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>


        <div class="row my-4">
            <div class="col-sm-12">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
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
                                        <th>Attach</th>
                                        <th>Detach</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td><input type="checkbox" name="" id="" {{ $user->userHasRole($role->slug) ? 'checked' : '' }} ></td>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        <td>
                                            <form action="{{ route('user.role.attach', $user) }}" method="post">
                                                @csrf
                                                @method('put')

                                                <input type="hidden" name="roleId" value="{{$role->id}}">

                                                <button type="submit" 
                                                        class="btn btn-primary"
                                                        {{ $user->roles->contains($role) ? 'disabled' : '' }}
                                                        >
                                                            Attach
                                                </button>
                                            </form>

                                        </td>
                                        <td>
                                            <form action="{{ route('user.role.detach', $user) }}" method="post">
                                                @csrf
                                                @method('put')

                                                <input type="hidden" name="roleId" value="{{$role->id}}">

                                                <button type="submit" 
                                                        class="btn btn-danger"
                                                        {{ !$user->roles->contains($role) ? 'disabled' : '' }}
                                                
                                                >Detach</button>
                                            </form>
                                        
                                        </td>
                                    </tr>                            
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
</x-admin-master>