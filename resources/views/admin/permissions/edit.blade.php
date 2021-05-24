<x-admin-master>
    @section('content')



    @if (session()->has('permission-updated'))
        <div class="alert alert-success">
            {{ session('permission-updated') }}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <h3>Edit: {{ $permission->name }}</h3>

            <form action="{{route('permissions.update', $permission)}}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$permission->name}}">
                </div>

                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    @endsection
</x-admin-master>