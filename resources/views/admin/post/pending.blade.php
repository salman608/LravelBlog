@extends('layouts.backend.app')

@section('title','Post')

@push('css')
  <!-- JQuery DataTable Css -->
     <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')

     <div class="container-fluid">
            <div class="block-header">
                <h2>
                    <a href="{{ route('admin.post.create') }}" class="btn btn-primary waves-effect">
                         <i class="material-icons">add</i> <span>Add New Post</span>
                         </a>
                </h2>
            </div>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ALL POST
                                <span class="badge bg-red">{{ $posts->count() }}</span>
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th> <i class="material-icons">visibility</i> </th>
                                            <th>Approve</th>
                                            <th>Status</th>
                                            <th>Created_at</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>Id</th>
                                             <th>Title</th>
                                             <th>Author</th>
                                             <th> <i class="material-icons">visibility</i> </th>
                                             <th>Approve</th>
                                             <th>Status</th>
                                             <th>Created_at</th>
                                             <th>Action</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach ($posts as $key => $post)


                                        <tr>
                                          <td>{{$key + 1}}</td>
                                          <td>{{ str_limit($post->title,'10') }}</td>
                                          <td>{{ $post->user->name }}</td>
                                          <td>{{ $post->view_count }}</td>
                                          <td>
                                               @if ($post->is_approved==true)
                                                    <span class="badge bg-blue" >Approved</span>
                                               @else
                                                      <span class="badge bg-pink" >pending</span>
                                               @endif
                                          </td>

                                          <td>
                                               @if ($post->status==true)
                                                    <span class="badge bg-blue" >publish</span>
                                               @else
                                                      <span class="badge bg-pink" >pending</span>
                                               @endif
                                          </td>
                                          <th>{{ $post->created_at }}</td>

                                          <td>

                                               @if ($post->is_approved==false)
                                     <button type="button" class="btn btn-success  waves-effect" onclick="approvePost({{ $post->id }})" >
                                        <i class="material-icons">done</i>
                                        
                                      </button>

                                      <form  action="{{ route('admin.post.approve',$post->id) }}" method="post" id="approval-form" style="display:none;">
                                        @csrf
                                        @method('PUT')

                                      </form>

                                    @endif

                                               <a href="{{ route('admin.post.show',$post->id) }}" class="btn btn-info">
                                                    <i class="material-icons">visibility</i>
                                               </a>

                                               <a href="{{ route('admin.post.edit',$post->id) }}" class="btn btn-info">
                                                    <i class="material-icons">edit</i>
                                               </a>

                                               <button type="button" class="btn btn-danger" onclick="deletepost({{ $post->id }})">
                                                    <i class="material-icons">delete</i>
                                               </button>



                                               <form id="delete-form-{{ $post->id }}" action="{{ route('admin.post.destroy',$post->id) }}" method="post" style="display:none;">
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
              function deletepost(id){

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



          function approvePost(id){

            const swalWithBootstrapButtons = Swal.mixin({
               customClass: {
               confirmButton: 'btn btn-success',
               cancelButton: 'btn btn-danger'
             },
             buttonsStyling: false
           })

                swalWithBootstrapButtons.fire({
                  title: 'Are you sure?',
                  text: "You want approve this Post!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, Approve it!',
                  cancelButtonText: 'No, cancel!',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    event.preventDefault();
                    document.getElementById('approval-form').submit();
                  } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                  ) {
                    swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'The post is pending :)',
                      'error'
                    )
                  }
                });

                    }

    </script>
        @endpush



@endsection
