@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Class List  </h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ url('admin/class/add') }}" class="btn btn-primary">Add New Class</a>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search Class </h3>
                            </div>
                            <form method="get" action="">
                                {{ csrf_field() }}
                                <div class="card-body">

                                    <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}"
                                            placeholder="Name">
                                        <div style="color: red">{{ $errors->first('name') }}</div>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input type="date" class="form-control" name="date" value="{{ Request::get('date') }}"
                                            placeholder="Email">
                                        <div style="color: red">{{ $errors->first('email') }}</div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <button class="btn btn-warning" style="margin-top: 32px;" type="submit">Search</button>
                                        <a href="{{ url('admin/class/list') }}" class="btn btn-info" style="margin-top: 32px;" >Clear</a>
                                    </div>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->
                    <!--/.col (right) -->
                </div>
                @include('layouts.massager')
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Class Details </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>
                                                    @if ($value->status == 0)
                                                        Active
                                                    @else
                                                        Inactive
                                                    @endif
                                                                                                  </td>
                                                <td>{{ $value->created_by_name }}</td>
                                                <td>{{ date('d-m-Y H:i A', strtotime($value->created_at) ) }}</td>
                                                <td>
                                                    <a href="{{ url('admin/class/edit/' . $value->id) }}"
                                                        class="btn btn-success"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="{{ url('admin/class/delete/' . $value->id) }}"
                                                        class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="padding: 10px ; float:right"> {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}</div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
