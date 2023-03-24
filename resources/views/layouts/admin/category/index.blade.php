@extends('layouts.admin.app')
@section('title', 'Page Title')
@section('sidebar')
@section('content')
    <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
             <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Categories List</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Categories List</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
			<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @if ($message = Session::get('success'))
                    <div class="row">
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                @endif
                @if ($message = Session::get('errormsg'))
                    <div class="row">
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->detail }}</td>
                            <td>
                                <!--<a class="btn btn-info" href="{{ route('categories.show',$category->id) }}">Show</a>-->
                                <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>
                                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    {!! $categories->links() !!}
   
@endsection
<!--
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
-->