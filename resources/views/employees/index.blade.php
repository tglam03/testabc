@extends('master')

@section('title')
    List
@endsection
@section('content')
    <h1>List Employee
        <a href="{{ route('employees.create') }}" class="btn btn-info">Create</a>
    </h1>
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Is active</th>
                    <th scope="col">Image</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $employee)
                    <tr class="">
                        <td scope="row">{{ $employee->id }}</td>
                        <td scope="row">{{ $employee->name }}</td>
                        <td scope="row">{{ $employee->email }}</td>
                        <td scope="row">{{ $employee->phone }}</td>
                        <td scope="row">{{ $employee->address }}</td>
                        <td scope="row">
                            @if ($employee->is_active)
                                <span class="badge bg-primary">Active</span>
                            @else
                                <span class="badge bg-danger">NO Active</span>
                            @endif
                        </td>
                        <td>
                            <img src="{{ Storage::url($employee->image) }}" width="100px">
                        </td>
                        <td>{{ $employee->created_at }}</td>
                        <td>{{ $employee->updated_at }}</td>
                    </tr>
                @endforeach


            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
