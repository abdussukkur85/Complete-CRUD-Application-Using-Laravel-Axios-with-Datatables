@extends('layout.app')
@push('css')
<style>
    .left-col {
    float: left;
    width: 25%;
}
 
.center-col {
    float: left;
    width: 50%;
}
 
.right-col {
    float: left;
    width: 25%;
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/datatables.min.css"/>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4>All Customers</h4>
                        {{-- <a href="" class="btn btn-success">Create Student</a> --}}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCustomerModal">
                            Create Customer
                          </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="150" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>



    
  <!-- Modal -->
  <div class="modal fade" id="createCustomerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Create a New Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('customer.store') }}" method="post" class="adaCustomerForm">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" name="name" id="name" placeholder="Your Name">
                <span id="nameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" id="email" placeholder="Your Email">
                <span id="emailError" class="text-danger"></span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="customerSubmit">Create</button>
            </div>
        </form>
        </div>
        
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editCustomerModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" class="">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" name="name" id="e_name" placeholder="Your Name">
                <span id="e_nameError" class="text-danger"></span>
            </div>

            <div class="form-group">
                <input class="form-control" type="email" name="email" id="e_email" placeholder="Your Email">
                <span id="e_emailError" class="text-danger"></span>
            </div>
              <input type="hidden" name="id" id="e_id">

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="customerUpdateSubmit">Update</button>
            </div>
        </form>
        </div>
        
      </div>
    </div>
  </div>
@endsection

@push('script')

 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/datatables.min.js"></script>
    <script>

        $(document).ready(function() {
            var base_url = window.location.origin;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                $('.datatable').DataTable({
                    
                    autoWidth: false,
                    pageLength: 5,
                    "order": [[ 0, "desc" ]],
                    "dom": "<'row'<'col-sm-12 mb-3'B>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    
                    ajax: "{{ route('get-customers') }}",

                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
                    ],
                    
                });


            //store
            $(document).on('click', '#customerSubmit', function(e){
                e.preventDefault();
                let nameError = $('#nameError');
                let emailError = $('#emailError');

                nameError.text('');
                emailError.text('');

                axios.post("{{ route('customer.store') }}", {
                    name: $('#name').val(),
                    email: $('#email').val(),
                })
                .then(function (response) {
                    //getAllCustomer();
                    $('#name').val('');
                    $('#email').val('');
                
                    nameError.text('');
                    emailError.text('');
                    location.reload();
                    $('#createCustomerModal').modal('toggle')
                    Swal.fire({
                    icon: 'success',
                    title: 'Success...',
                    text: 'Data save Successfully!',
                    })
                })
                .catch(function (error) {
                console.log(error.response.data.errors);
                if(error){
                    if(error.response.data.errors.name){
                        $('#nameError').text(error.response.data.errors.name[0]);
                    }
                    if(error.response.data.errors.email){
                        $('#emailError').text(error.response.data.errors.email[0]);
                    }
                }
                    
                });
            });

            // Edit Customer
            $('body').on('click','#getEditCustomerData',function(){
                let e_nameError = $('#e_nameError');
                let e_emailError = $('#e_emailError');

                e_nameError.text('');
                e_emailError.text('');
                
                let id = $(this).data('id')
                let url = base_url + '/customer' + '/'  + id + '/edit'
                axios.get(url)
                    .then(function(res){
                        $('#e_name').val(res.data.name)
                        $('#e_email').val(res.data.email)
                        $('#e_id').val(res.data.id)
                    })
            })

            //update Customer
            $(document).on('click','#customerUpdateSubmit',function(e){
                    e.preventDefault()

                    let id = $('#e_id').val()
                    let data = {
                        id : id,
                        name : $('#e_name').val(),
                        email : $('#e_email').val(),
                    }
                    let path = base_url + '/customer' + '/'  + id
                    axios.put(path,data)
                    .then(function(res){
                        $('#editModal').modal('toggle')
                        location.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success...',
                            text: 'Data Update Successfully!',
                            })
                    })
                    .catch(function (error) {
                    if(error){
                        if(error.response.data.errors.name){
                            $('#e_nameError').text(error.response.data.errors.name[0]);
                        }
                        if(error.response.data.errors.email){
                            $('#e_emailError').text(error.response.data.errors.email[0]);
                        }
                    }
                        
                    });
                })

            //delete Customer
            $('body').on('click','#getDeleteId',function (e) {
                    e.preventDefault();
                    let id = $(this).data('id')
                    let del_url = base_url + '/customer/' + id
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success mx-2',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                        axios.delete(del_url).then(function(r){
                            location.reload();
                        swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                )
                    });
                    } else if (
                            /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your file is safe :)',
                            'error'
                        )
                    }
                })
            });


        });
    </script>
  @endpush