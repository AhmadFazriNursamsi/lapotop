<?php use App\Http\Controllers\HelpersController as Helpers; 

$haveaccessadd = Helpers::checkaccess('users', 'add');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="fa fa-users"></i>
            {{ __('Users') }} <?php if($haveaccessadd): ?> <a href="{{URL::to('/users/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add User</a> <?php endif; ?>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                   <div class="table-responsive">
                        <table id="userstable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="name" name="name"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="username" name="username"></td>
                                    <td><input type="text" class="form-control input-sm src_class_user" autocomplete="off" onkeyup="searcAjax(this)" placeholder="email" name="email"></td>
                                    <td>
                                        <select name="division" id="division" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                          <option value="">-- Division --</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="role" id="role" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                          <option value="">-- Role --</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control input-sm src_class_user" placeholder="mobile" autocomplete="off" onkeyup="searcAjax(this)" name="mobile"></td>
                                    <td>
                                        <select name="active" class="form-control input-sm src_class_user" onchange="searcAjax(this, 1)">
                                          <option value="">-- Status Active --</option>
                                          <option value="1">Active</option>
                                          <option value="0">Not Active</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th><input type="checkbox" class="checkall" name="checkall"></th>
                                    <th class="align-center">Name</th>
                                    <th class="align-center">Username</th>
                                    <th class="align-center">Email</th>
                                    <th class="align-center">Division</th>
                                    <th class="align-center">Role</th>
                                    <th class="align-center">Mobile</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                                
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th class="align-center">Name</th>
                                    <th class="align-center">Username</th>
                                    <th class="align-center">Email</th>
                                    <th class="align-center">Division</th>
                                    <th class="align-center">Role</th>
                                    <th class="align-center">Mobile</th>
                                    <th class="align-center">Active</th>
                                    <th class="align-center">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- view modal -->
<div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="viewUserTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <h6>
        <span class="btn-sm btn btn-success"><i class="fa fa-user me-2"></i> <span id="titleNameUser"></span></span>
        <span class="btn-sm btn btn-warning"><i class="fa fa-user-md me-2"></i> <span id="titleDivisionUser"></span></span>
      </h6>
    </div>

    <div class="modal-body">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Main Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">User Access</button>
                </li>

            </ul>

            <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <dl class="row mb-0" id="datauser-1"></dl>
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <dl class="row mb-0" id="datauser-2"></dl>
          </div>

      </div>
    </div>

    <div class="modal-footer">
      <button id="closeModalViewUser" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      @if ($haveaccessadd) :
        <a href="{{URL::to('/users/edit/')}}" data-attrref="{{URL::to('/users/edit/')}}" id="addvbtn" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit User</a>
      @endif

      @if ($haveaccessdelete) :
        <button onClick="deleteyesshow()" data-attid="" data-deleteval="1" id="deletevbtn" class="btn btn-danger btn-sm"></a>
        <button onClick="undeleteyesshow()" data-attid="" data-deleteval="0" id="undeletevbtn" class="btn btn-success btn-sm"></a>
      @endif
    </div>
    </div>
  </div>
</div>

@section('script')
<script type="text/javascript">
    var url = "{{ asset('/api/users/getdata') }}";
    function searcAjax(a, skip = 0){
        if($(a).val().length > global_length_src || skip == 1) {
            var getparam = getAllClassAndVal("src_class_user"); // helpers
            $('#userstable').DataTable().ajax.url(url+"?"+getparam).load();
        }
        else {
          $('#userstable').DataTable().ajax.url(url).load();
        }
    }

    $(document).ready(function(){
        var getndate = getNowdate(); // helpers
        $("#daterangepicker").val(getndate + ' - ' + getndate );
        $(".datepicker").val(getndate);
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            locale: {
              format: "DD/MM/YYYY"
            }
        });

        $("#daterangepicker").daterangepicker({
            timePicker: false,
            locale: {
              format: "DD/MM/YYYY"
            }
        });


        var table = $('#userstable').DataTable({
            ajax: url,
            columnDefs: [
                 {
                   'targets': 8,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<span class="btn btn-info btn-sm" onclick="showdetail('+full[8]+')">details</span>';
                   }
                }, {
                   'targets': 0,
                   'searchable':false,
                   'orderable':false,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                       return '<input type="checkbox" class="ckc" name="checkid['+full[8]+']" value="' + $('<div/>').text(data).html() + '">';
                   }
                }, {
                   'targets': 7,
                   'className': 'dt-body-center',
                   'render': function (data, type, full, meta){
                        var dlt = '';
                        <?php if(Auth::user()->id_role == 99) : ?>
                          if(full[9] == 1)
                            dlt = '<span class="btn btn-danger btn-sm">deleted</span>';
                        <?php endif; ?>
                        if(full[7] == 0)
                            return '<span class="btn btn-danger btn-sm">not active</span>' + dlt;
                        else 
                            return '<span class="btn btn-success btn-sm">active</span>' + dlt;
                   }
                }
            ],
            searching: false,
        }); 


        $("#closeModalViewUser").click(function(){
          $("#viewUser").modal('hide');
        });

        $('.checkall').change(function(){
            var cells = table.cells().nodes();
            $( cells ).find('.ckc:checkbox').prop('checked', $(this).is(':checked'));
        });

        appendDivisionOption();
        appendRoleOption();
        

    });

    function showdetail(idx){
      var addurl = $('#addvbtn').attr('data-attrref')+'/'+idx;
      $('#addvbtn').attr('href', addurl);
      $('#deletevbtn').attr('data-attid', idx);
      $('#deletevbtn').html('<i class="fa fa-trash"></i> Delete User');

      $('#undeletevbtn').attr('data-attid', idx);
      $('#undeletevbtn').html('<i class="fa fa-repeat"></i> Undelete User');

      $('#viewUser').modal('show');
      test = '@csrf';
      token = $(test).val();

      var url = "{{ asset('/api/users/getdatabyid') }}"+'/'+idx;
      $.ajax({
          url: url,
          type: "get",
          
          success: function (response) {
            var dhtml = '';
            var dhtml_ac = 'you don\'t have access';
            $.each(response.data[0], function(i, item) {
              if (item instanceof Object){
                  if (i === "uaccess") {
                      dhtml_ac = '';
                      const arrdata = [];
                      $.each(response.data[0].uaccess, function(ii, item2) {

                        var check = '<i class="fa fa-check-square" style="color: #0c9618"></i>';
                        if(item2.val_access == 0)
                          check = '<i class="fa fa-window-close" style="color: #fb46a1"></i>';

                        if(arrdata.includes(item2.name_access) == false) {
                            arrdata.push(item2.name_access);
                            dhtml_ac += '<dt class="col-sm-12" style="border: 1px solid #DDD; background: #b2d9ff; margin-top:15px;">'+item2.name_access+'</dt>';
                            dhtml_ac += '<span class="col-sm-3" style="float: left">'+item2.key_access+' : '+check+'</span>';
                        }
                          
                        else {
                            dhtml_ac += '<span class="col-sm-3" style="float: left">'+item2.key_access+' : '+check+'</span>';
                        }


                      });
                  }
              } else {
                  if(i != 'id' && i != 'email_verified_at' && i != 'join_date') {
                      if(i == 'name') $("#titleNameUser").html(item);
                      if(i == 'flag_delete' && item == 0) {
                        $("#deletevbtn").show();
                        $("#undeletevbtn").hide();
                        item = '<span id="activspan">-</span>';
                      } 
                      if(i == 'flag_delete' && item == 1) {
                        $("#deletevbtn").hide();
                        $("#undeletevbtn").show();
                        item = '<span id="activspan" style="color: #dc3545">deleted</span>';
                      }

                      if(i == 'active' && item == 1) {
                        item = '<span style="color: #198754">active</span>';
                      } 
                      if(i == 'active' && item == 0) {
                        item = '<span style="color: #dc3545">not active</span>';
                      }

                      if(i == 'id_division') {
                        i = 'division';
                        item = response.data[0].divisions.division_name;
                        $("#titleDivisionUser").html(item);
                      }

                      if(i == 'id_role') {
                        i = 'role';
                        item = response.data[0].roles.role_name;
                      }


                      dhtml += '<dt class="col-sm-4">'+i+'</dt>';
                      dhtml += '<dt class="col-sm-8">: '+item+'</dt>';
                  }
              }
            });
            $("#datauser-1").html(dhtml);
            $("#datauser-2").html(dhtml_ac);
          },
          error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
          }
      });

    }


    function appendDivisionOption(){
        // add division
        var url = "{{ asset('/api/getdivision') }}";
        $.ajax({
            url: url,
            type: "get",
            success: function (response) {
              $.each(response.data, function (i, item) {
                  $('#division').append($('<option>', { 
                      value: item.id_division,
                      text : item.division_name 
                  }));
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }

    function appendRoleOption(){
        // add division
        var url = "{{ asset('/api/getrole') }}";
        $.ajax({
            url: url,
            type: "get",
            success: function (response) {
              $.each(response.data, function (i, item) {
                  $('#role').append($('<option>', { 
                      value: item.id_role,
                      text : item.role_name 
                  }));
              });
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }

    function deleteyesshow(){
      $('#deletevbtn').hide();
      idx = $('#deletevbtn').attr('data-attid');
      test = '@csrf';
      token = $(test).val();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ asset('/users/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token
                    },
                    success: function (response) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Deleted',
                          html:'Your file has been <b>Deleted</b>'
                        });
                        var urlx = "{{ asset('/api/users/getdata') }}";
                        $('#userstable').DataTable().ajax.url(urlx).load();
                        $('#undeletevbtn').show();
                        $("#activspan").html('deleted');
                        $("#activspan").css('color', '#dc3545');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('something wrong');
                        console.log(textStatus, errorThrown);
                    }
                });

            } else {
              $('#deletevbtn').show();
            }
      })
    }

    function undeleteyesshow(){
      $('#undeletevbtn').hide();
      idx = $('#undeletevbtn').attr('data-attid');
      test = '@csrf';
      token = $(test).val();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, undelete it!'
      }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ asset('/users/delete') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id : idx,
                        _token: token,
                        undeleted : 1
                    },
                    success: function (response) {
                        Swal.fire({
                          icon: 'success',
                          title: 'Undeleted',
                          html:'Your file has been <b>Undeleted</b>'
                        });
                        var urlx = "{{ asset('/api/users/getdata') }}";
                        $('#userstable').DataTable().ajax.url(urlx).load();
                        $('#deletevbtn').show();
                        $("#activspan").html('-');
                        $("#activspan").css('color', '#198754');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

            } else {
              $('#undeletevbtn').show();
            }
      })
    }

    
</script>

@endsection    
</x-app-layout>


