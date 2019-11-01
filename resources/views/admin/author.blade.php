@extends('layouts.backend.app')

@section('title','Category')

@push('css')
  <!-- JQuery DataTable Css -->
     <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

     <div class="container-fluid">

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ALL AUTHORS
                                <span class="badge bg-blue">{{ $authors->count() }}</span>
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Posts</th>
                                            <th>Comments</th>
                                            <th>Favorite Posts</th>
                                            <th>Created_at</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>Id</th>
                                             <th>Name</th>
                                             <th>Posts</th>
                                             <th>Comments</th>
                                             <th>Favorite Posts</th>
                                             <th>Created_at</th>
                                             <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach ($authors as $key => $author)


                                        <tr>
                                          <td>{{$key + 1}}</td>
                                          <td>{{ $author->name }}</td>
                                          <td>{{ $author->posts_count }}</td>
                                          <td>{{ $author->comments_count }}</td>
                                          <td>{{ $author->favorite_posts_count }}</td>
                                          <td>{{ $author->created_at->toDateString() }}</td>

                                          <td>

                                               <button type="button" class="btn btn-danger" onclick="deleteAuthor({{ $author->id }})">
                                                    <i class="material-icons">delete</i>
                                               </button>

                                               <form id="delete-form-{{ $author->id }}" action="{{ route('admin.author.destroy',$author->id) }}" method="post" style="display:none;">
                                                    @csrf
                                                    @method("DELETE")

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
            <!-- #END# Exportable Table -->
        </div>


        @push('js')
             <!-- Jquery DataTable Plugin Js -->
           <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
           <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
           <script src="{{asset("assets/backend/js/pages/tables/jquery-datatable.js")}}"></script>
           <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.17.6/dist/sweetalert2.all.min.js"></script>

           {{-- Delete Tag --}}
           <script type="text/javascript">
              function deleteAuthor(id){

                const swalWithBootstrapButtons = Swal.mixin({
                   customClass: {
                   confirmButton: 'btn btn-success',
                   cancelButton: 'btn btn-danger'
                 },
                 buttonsStyling: false
               })

                    swalWithBootstrapButtons.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, delete it!',
                      cancelButtonText: 'No, cancel!',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {
                        event.preventDefault();
                        document.getElementById('delete-form-'+id).submit();
                      } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                      ) {
                        swalWithBootstrapButtons.fire(
                          'Cancelled',
                          'Your data is safe :)',
                          'error'
                        )
                      }
                    });

                        }

    </script>
        @endpush



@endsection
