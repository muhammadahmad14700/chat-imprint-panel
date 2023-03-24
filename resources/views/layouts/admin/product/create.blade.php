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
                        <h4 class="page-title">Add New Product</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Products Add</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="row">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
           
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
                <div class="row">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Select Category:</strong>
                                    <select class="form-control" name="category_id">
                                        <option value="">Please Select Option</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Product SKU Code:</strong>
                                    <input type="text" name="sku_code" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Detail:</strong>
                                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection