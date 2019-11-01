@extends('layouts.backend.app')

@section('title','Category')

@push('css')

@endpush

@section('content')

  <div class="container-fluid">


           <!-- Vertical Layout | With Floating Label -->
           <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="card">
                       <div class="header">
                           <h2>
                               Update Category
                           </h2>

                       </div>
                       <div class="body">
                           <form action="{{ route('admin.category.update',$category->id) }}" method="post" enctype="multipart/form-data">
                             @csrf
                             @method('PUT')
                               <div class="form-group form-float">
                                   <div class="form-line">
                                       <input type="text" id="name" class="form-control" name="name" value="{{ $category->name }}">

                                   </div>
                               </div>

                               <div class="form-group form-float">
                                   <div class="form-line">
                                       <input type="file" id="name" class="form-control" name="image">

                                   </div>
                               </div>

                               <a href="{{ route('admin.category.index') }}" class="btn btn-danger m-t-15 waves-effect"> BACK </a>
                               <button type="submit" class="btn btn-primary m-t-15 waves-effect"> Update </button>


                           </form>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Vertical Layout | With Floating Label -->




       </div>

@endsection

@push('js')

@endpush
