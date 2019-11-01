@extends('layouts.backend.app')

@section('title','TagList')

@push('css')
  <!-- JQuery DataTable Css -->
     <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

     <div class="container-fluid">
            <div class="block-header">
                <h2>
                    <a href="{{ route('admin.tag.create') }}" class="btn btn-primary waves-effect">
                         <i class="material-icons">add</i> <span>Add New Tag</span>
                         </a>
                </h2>
            </div>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                All Tag
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Created_at</th>
                                            <th>Updated_at</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>Id</th>
                                          <th>Name</th>
                                          <th>Created_at</th>
                                          <th>Updated_at</th>
                                          <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach ($tags as $key => $tag)


                                        <tr>
                                          <td>{{$key + 1}}</td>
                                          <td>{{ $tag->name }}</th>
                                          <th>{{ $tag->created_at }}</td>
                                          <td>{{ $tag->updated_at }}</td>
                                          <td>
                                               <a href="{{ route('admin.tag.edit',$tag->id) }}" class="btn btn-info">
                                                    <i class="material-icons">edit</i>
                                               </a>
                                               <button type="button" class="btn btn-danger" onclick="deleteTag({{ $tag->id }})">
                                                    <i class="material-icons">delete</i>
                                               </button>

                                               <form id="delete-form-{{ $tag->id }}" action="{{ route('admin.tag.destroy',$tag->id) }}" method="post" style="display:none;">
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
              function deleteTag(id){

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
