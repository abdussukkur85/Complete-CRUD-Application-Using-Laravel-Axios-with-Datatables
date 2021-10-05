@extends('layout.app')
@push('css')

  
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <h4>All Students</h4>
                        {{-- <a href="" class="btn btn-success">Create Student</a> --}}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createStudentModal">
                            Create Student
                          </button>
                    </div>

                    <div class="card-body">
                      <table class="table" id="dataTable">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                            <th>Email Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>

                        <tbody id="studentTable">
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


  
  <!-- Modal -->
  <div class="modal fade" id="createStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Create a New Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('student.store') }}" method="post" class="addStudentForm">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" name="first_name" id="firstName" placeholder="First Name">
                <span id="firstNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="last_name" id="lastName" placeholder="Last Name">
                <span id="lastNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="father_name" id="fatherName" placeholder="Father's Name">
                <span id="fatherNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="mother_name" id="motherName" placeholder="Mother's Name">
                <span id="motherNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" id="email" placeholder="Your Email">
                <span id="emailError" class="text-danger"></span>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="studentSubmit">Create</button>
            </div>
        </form>
        </div>
        
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Edit Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" class="">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" name="first_name" id="e_firstName" placeholder="First Name">
                <span id="e_firstNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="last_name" id="e_lastName" placeholder="Last Name">
                <span id="e_lastNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="father_name" id="e_fatherName" placeholder="Father's Name">
                <span id="e_fatherNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="mother_name" id="e_motherName" placeholder="Mother's Name">
                <span id="e_motherNameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email" id="e_email" placeholder="Your Email">
                <span id="e_emailError" class="text-danger"></span>
            </div>
              <input type="hidden" name="id" id="e_id">

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="studentUpdateSubmit">Update</button>
            </div>
        </form>
        </div>
        
      </div>
    </div>
  </div>

  

@endsection

@push('script')
    
    <script>
      var base_url = window.location.origin;

      //get all student
      function table_data_row(data) {
        var	rows = '';
        var i = 0;
        $.each( data, function( key, value ) {
            // value.id
            rows = rows + '<tr>';
            rows = rows + '<td>'+ ++i +'</td>';
            rows = rows + '<td>'+value.first_name +' '+ value.last_name +'</td>';
            rows = rows + '<td>'+value.father_name+'</td>';
            rows = rows + '<td>'+value.mother_name+'</td>';
            rows = rows + '<td>'+value.email+'</td>';
            rows = rows + '<td data-id="'+value.id+'" class="text-center">';
            rows = rows + '<a class="btn btn-sm btn-info text-light" id="editRow" data-id="'+value.id+'" data-toggle="modal" data-target="#editModal">Edit</a> ';
            rows = rows + '<a class="btn btn-sm btn-danger text-light"  id="deleteRow" data-id="'+value.id+'" >Delete</a> ';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });
        $("#studentTable").html(rows);
      }
      function getAllStudent(){
          axios.get("{{ route('getAllStudent') }}")
          .then(function(res){ 
            table_data_row(res.data);
            // $('#dataTable').DataTable();
          })

      }
      getAllStudent();

      //store
      $(document).on('click', '#studentSubmit', function(e){
        e.preventDefault();
        let firstNameError = $('#firstNameError');
        let lastNameError = $('#lastNameError');
        let fatherNameError = $('#fatherNameError');
        let motherNameError = $('#motherNameError');
        let emailError = $('#emailError');

        firstNameError.text('');
        lastNameError.text('');
        fatherNameError.text('');
        motherNameError.text('');
        emailError.text('');


        axios.post("{{ route('student.store') }}", {
            first_name: $('#firstName').val(),
            last_name: $('#lastName').val(),
            father_name: $('#fatherName').val(),
            mother_name: $('#motherName').val(),
            email: $('#email').val(),
        })
        .then(function (response) {
            //getAllData();
            $('#firstName').val('');
            $('#lastName').val('');
            $('#fatherName').val('');
            $('#motherName').val('');
            $('#email').val('');
           
            firstNameError.text('');
            lastNameError.text('');
            fatherNameError.text('');
            motherNameError.text('');
            emailError.text('');

            $('#createStudentModal').modal('toggle')
            getAllStudent();
            Swal.fire({
              icon: 'success',
              title: 'Success...',
              text: 'Data save Successfully!',
            })
        })
        .catch(function (error) {
          console.log(error.response.data.errors);
          if(error){
            if(error.response.data.errors.first_name){
                $('#firstNameError').text(error.response.data.errors.first_name[0]);
            }
            if(error.response.data.errors.last_name){
                $('#lastNameError').text(error.response.data.errors.last_name[0]);
            }
            if(error.response.data.errors.father_name){
                $('#fatherNameError').text(error.response.data.errors.father_name[0]);
            }
            if(error.response.data.errors.mother_name){
                $('#motherNameError').text(error.response.data.errors.mother_name[0]);
            }
            if(error.response.data.errors.email){
                $('#emailError').text(error.response.data.errors.email[0]);
            }
          }
            
        });
      });


    // Edit student
    $('body').on('click','#editRow',function(){
      let e_firstNameError = $('#e_firstNameError');
        let e_lastNameError = $('#e_lastNameError');
        let e_fatherNameError = $('#e_fatherNameError');
        let e_motherNameError = $('#e_motherNameError');
        let e_emailError = $('#e_emailError');

        e_firstNameError.text('');
        e_lastNameError.text('');
        e_fatherNameError.text('');
        e_motherNameError.text('');
        e_emailError.text('');
        
        let id = $(this).data('id')
        let url = base_url + '/student' + '/'  + id + '/edit'
        axios.get(url)
            .then(function(res){
                $('#e_firstName').val(res.data.first_name)
                $('#e_lastName').val(res.data.last_name)
                $('#e_fatherName').val(res.data.father_name)
                $('#e_motherName').val(res.data.mother_name)
                $('#e_email').val(res.data.email)
                $('#e_id').val(res.data.id)
            })
    })

    //update student
    $(document).on('click','#studentUpdateSubmit',function(e){
        e.preventDefault()

        let id = $('#e_id').val()
        let data = {
            id : id,
            first_name : $('#e_firstName').val(),
            last_name : $('#e_lastName').val(),
            father_name : $('#e_fatherName').val(),
            mother_name : $('#e_motherName').val(),
            email : $('#e_email').val(),
        }
        let path = base_url + '/student' + '/'  + id
        axios.put(path,data)
        .then(function(res){
            getAllStudent();
             $('#editModal').modal('toggle')
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: 'Data Update Successfully!',
                })
          })
          .catch(function (error) {
          if(error){
            if(error.response.data.errors.first_name){
                $('#e_firstNameError').text(error.response.data.errors.first_name[0]);
            }
            if(error.response.data.errors.last_name){
                $('#e_lastNameError').text(error.response.data.errors.last_name[0]);
            }
            if(error.response.data.errors.father_name){
                $('#e_fatherNameError').text(error.response.data.errors.father_name[0]);
            }
            if(error.response.data.errors.mother_name){
                $('#e_motherNameError').text(error.response.data.errors.mother_name[0]);
            }
            if(error.response.data.errors.email){
                $('#e_emailError').text(error.response.data.errors.email[0]);
            }
          }
            
        });
      })

    //delete Student
    $('body').on('click','#deleteRow',function (e) {
            e.preventDefault();
            let id = $(this).data('id')
            let del_url = base_url + '/student/' + id
            console.log(del_url);
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
                  getAllStudent();
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
    </script>
  @endpush