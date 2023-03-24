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
                        <h4 class="page-title">Products List</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Products List</li>
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
                        <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>SKU Code</th>
                            <th>Details</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku_code }}</td>
                            <td>{{ $product->detail }}</td>
                            <td>
                                <!--<a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>-->
                                <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
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
    {!! $products->links() !!}

@endsection