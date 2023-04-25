@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="content">

          <!-- Start Content-->
          <div class="container-fluid">
              
              <!-- start page title -->
              <div class="row">
                  <div class="col-12">
                      <div class="page-title-box">
                          <div class="page-title-right">
                              <ol class="breadcrumb m-0">
                              <li class="breadcrumb-item active"> Edit Admin</li>
                              </ol>
                          </div>
                          <h4 class="page-title">Basic Elements</h4>
                      </div>
                  </div>
              </div>     
              <!-- end page title --> 

             
              <!-- Form row -->
              <div class="row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-body">
                              

                              <form id="myForm" method="post" action="{{route('admin.update')}}">
                                        @csrf

                                        <input type="hidden" name="id" value=" {{$adminuser ->id}}">

                                  <div class="row">
                                      <div class="col-md-6 mb-3">
                                          <label for="inputEmail4" class="form-label">User Name</label>
                                          <input type="text" name="surname" class="form-control" id="inputEmail4" value="{{$adminuser->surname}}" >
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="inputEmail4" class="form-label">Name</label>
                                          <input type="text" name="name" class="form-control" id="inputEmail4"  value="{{$adminuser->name}}">
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="inputEmail4" class="form-label">Email</label>
                                          <input type="email" name="email" class="form-control" id="inputEmail4" value="{{$adminuser->email}}" >
                                      </div>
                                      <div class="col-md-6 mb-3">
                                          <label for="inputEmail4" class="form-label">Phone</label>
                                          <input type="text" name="phone" class="form-control" id="inputEmail4" value="{{$adminuser->phone}}" >
                                      </div>
                                      
                                      
                                     
                                  </div>


                                

                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>

                              </form>

                          </div> <!-- end card-body -->
                      </div> <!-- end card-->
                  </div> <!-- end col -->
              </div>
              <!-- end row -->


             

              

            
              
          </div> <!-- container -->

      </div> <!-- content -->


      <script type="text/javascript">
          $(document).ready(function (){
              $('#myForm').validate({
                  rules: {
                      surname: {
                          required : true,
                      }, 
                              name: {
                              required : true,
                              },
                              email: {
                              required : true,
                              },
                              phone: {
                              required : true,
                              },
                              password: {
                              required : true,
                              },

                  },
                  messages :{
                      surnamae: {
                          required : 'Please Enter user Name',
                      },
                              name: {
                              required : 'Please Enter Name',
                              },
                              email: {
                              required : 'Please Enter Email',
                              },
                              phone: {
                              required : 'Please Enter Phone',
                              },
                              password: {
                              required : 'Please Enter Password',
                              },
                  },
                  errorElement : 'span', 
                  errorPlacement: function (error,element) {
                      error.addClass('invalid-feedback');
                      element.closest('.form-group').append(error);
                  },
                  highlight : function(element, errorClass, validClass){
                      $(element).addClass('is-invalid');
                  },
                  unhighlight : function(element, errorClass, validClass){
                      $(element).removeClass('is-invalid');
                  },
              });
          });
          
      </script>


@endsection
