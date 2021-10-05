@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div style="height:100vh" class="d-flex justify-content-center align-items-center">
                    <a href="{{ route('student.index') }}" class="btn btn-success btn-lg">Student List</a> &nbsp;              
                    <a href="{{ route('customer.index') }}"  class="btn btn-primary btn-lg">Customer List</a>                
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
