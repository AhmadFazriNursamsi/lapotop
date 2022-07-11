<?php use App\Http\Controllers\HelpersController as Helpers;

$haveaccessadd = Helpers::checkaccess('listPaket', 'add');
$haveaccessadd = Helpers::checkaccess('listPaket', 'delete');
$haveaccessdelete = Helpers::checkaccess('users', 'delete');

?>
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<style>
    .animate-charcter
{
   text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #231557 0%,
    #44107a 29%,
    #ff1361 67%,
    #fff800 100%
  );
  background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  font-family: 'Times New Roman', Times, serif;
  color: #fff;
  background-clip: text;
  text-fill-color: transparent;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 2s linear infinite;
  display: inline-block;
      font-size: 30px;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}

</style>
@endsection
{{-- <title>{{ $datas['title'] }}</title> --}}
{{-- {{ dd($datas) }} --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hetf2"><i class="bi bi-box2-fill"></i>
            {{ __('List Paket') }} <?php if($haveaccessadd): ?> <button type="button" class="btn btn-success btn-sm" id="buttonaddPaket"> <i class="bi bi-box2-fill"></i> Add Paket</button><?php endif; ?>
        </h2>
    </x-slot>
                                                    {{-- HEADER --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="table-responsive">
                        <button type="button" class="btn btn-danger del">Hapus</button>
                        <table id="PaketTable"
                            class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                            <thead>
                         
                                  <th>No</th>
                                  <th class="align-center">Nama Paket</th>
                                    
                                    <th class="align-center">Action</th>
                                </tr>
                            </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th class="align-center">Nama Paket</th>
                                        
                                        <th class="align-center">Action</th>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>                             
                                                                    <!-- MODAL add -->
    <div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modaladdTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-lg-start">
                    <h4><i class="icoon"></i></h4>
                    <h4><i class="titlemodal"></i> </h4>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form id="paketform">
                                @csrf
                                <dl class="row mb-0">
                                <dt class="col-sm-4">Nama Paket</dt>
                                <dd class="col-sm-8">: <input type="text" name="nama_paket" id="nama_paket" class="form-group nama_paket">
                                <dt class="col-sm-4"></dt>
                                <dd class="col-sm-8">: <input type="text" name="search" id="paketid" class="form-group paketid"><button type="button" class="btn-primary"><i class="bi bi-search"></i></button>
                                <div id="paket_lisy" class="paket_lisy"></div>
                                <input type="hidden" name="user_group" id="user_group">
                                <div class="d-flex justify-content-end">
                                    <div class="control-group after-add-more">
                                    
                                        <div class="copy control-group"></div>
                                    </div>
                                </div></dd>
                                <input type="hidden" name="id" id="id_name">
                                </dl>
                            

                                <div class="option-table">

                                    <table id="listgudangtable" class="table text-start table-striped align-middle table-bordered table-hover mb-0">
                                        <thead>
                                          <tr>
                                              <th>No</th>
                                              {{-- <th class="align-center">Gambar</th> --}}
                                              <th class="align-center">Nama Product</th>
                                            <th class="align-center">Satuan</th>
                                            <th class="align-center">Alias</th>
                                            <th class="align-center">Jumlah</th>
                                            <th>Delete</th>
                                        </tr>
                                        
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th class="align-center">Nama Product</th>
                                            <th class="align-center">Satuan</th>
                                              {{-- <th class="align-center">Gambar</th> --}}
                                              <th class="align-center">Alias</th>
                                              <th class="align-center">Jumlah</th>
                                            <th>Delete</th>
                                            
                                            
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                                
                                
                                <div class="modal-footer">
                                    <button id="closeModalmodaladd" type="button" class="btn btn-secondary closeModalmodaladd btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit" id="save" class="btn btn-success btn-sm">Save</button>
                                </div>
                            </form>
                        </div>               
                    </div>
                </div>
            </div>
        </div>
    </div>

                                                                    <!-- MODAL VIEW -->
    <div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="modaladdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-lg-start">
                <h4><i class="icoon"></i></h4>
                <h4 class=" ms-2 modal-title"><i class="titlemodal"></i></h4>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                       <center><i><b class="animate-charcter mb-3" id="paket_id"></b></center> </i>
                       
                        <dl class="row ">
                                
                            <dt class="alias_gudang col-sm-4">Produk </dt>
                            <dd class="alias_gudang col-sm-8">: <span id="product_id"></span></dd>          
                            {{-- <dt class="show_status col-sm-4">Satuan</dt>
                            <dd class="show_status col-sm-8">: <span id="satuan_id"></span> --}}
                            <dt class="show_status col-sm-4">Jumlah</dt>
                            <dd class="show_status col-sm-8">: <span id="jumlah_id"></span>
                        </dl>   
                        
                    </div>               
                </div>
            </div>
            <div class="modal-footer">
                <button id="closeModalmodaladd" type="button" class="btn closeModalmodaladd btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" id="editt" class="btn btn-success btn-sm" data-id="" onclick="editshow(this)">Edit</button>
            </div>
        </div>
    </div>
</div>
        
    {{-- </div> --}}

   
    {{-- <div class="modal-dialog modal-lg modal_view">...</div>                                                     --}}
    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script type="text/javascript">
            /////////////////////////////////////////////   GetData Table ///////////////////////////////////////////
            var url = "{{ asset('/api/paket/getdata') }}";
            function searcAjax(a, skip = 0) {
                if ($(a).val().length > global_length_src || skip == 1) {
                    var getparam = getAllClassAndVal("src_class_user"); // helpers
                    $('#PaketTable').DataTable().ajax.url(url + "?" + getparam).load();
                }else{
                    $('#PaketTable').DataTable().ajax.url(url).load();
                }
            }
            $(document).ready(function() {
                var getndate = getNowdate(); // helpers
                var table = $('#PaketTable').DataTable({
                    ajax: url,
                    columnDefs: [{
                            'targets': 2,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                                return '<span class="btn btn-info btn-sm" onclick="showdetail(' + full[2] + ')">details</span>';
                            }
                        },

                        
                    ],

                });

                var getndate = getNowdate(); // helpers
                var tabl2 = $('#listgudangtable').DataTable({

                    // ajax:url,
                    columnDefs: [
                        {
                            'targets': 4,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                                return ' <div class="form-group row"><div class="col-xs-2"> <input type="number" name="jumlah" id="jumlah" class="form-group form-control jumlah"></div></div>';
                            }
                        },
                        {
                            'targets': 5,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function(data, type, full, meta) {
                                return '<span class="btn btn-danger deletee btn-sm" onclick="kurangininput(' + full[5] + ')"><i class="bi bi-trash-fill"></i></span>';
                            }
                        },

                        
                    ],
                    searching: false

                });

                $( "#paketform" ).submit(function(e) {
            // var id = ("#id_name").val();
           var id = $('#editt').attr('data-id');

            var url= "{{ asset('/paket/store') }}" ;
            if(id != '')
            var url= "{{ asset('/paket/update') }}/" + id ;


            e.preventDefault();
            var form = $('#paketform');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        dataType: 'JSON',
                        success: function (response) {
                            data = response.data;
                            if(data == 'success') {
                                Swal.fire({
                                    title: 'Selamat!',
                                    text: "Data Berhasil Disimpan",
                                    icon: 'success'
                            
                                });
                                $('#modaladd').modal('hide');
                                reloaddata();
                            }
                            else {
                                $.each(response.errors, function(key, value){
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: value,
                                    icon: 'error'
                                });
                            });
                                
                            }

                            $('#user_group').hide();
                            $('.copy').html("");
                            $(".after-add-more").html("");
                            $(".option-table").val("");
                    
                            
                        },

                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                });  

            });

            $("#buttonaddPaket").on('click', function () { 
                $('#modaladd').modal('show');
                $(".titlemodal").html(' Add Paket')
                $('.icoon').html('<i class="bi bi-plus-circle-fill"></i>');
                $("#paketid").val("");
                $('.paket_lisy').html("");
                $('#user_group').hide();
                $('.copy').html("");
                $(".odd").html("");
               $("#nama_paket").val("");
               $(".option-table").hide("");
           
                $(".control-group after-add-more").html("");

             })

            //  function search() { 

    $('#paketid').keyup(function(){  
        var path = "{{ route('autocomplete') }}";
        var query = $(this).val();  
       
        if(query != '')  
        {  
            $.ajax({  
                url: path,  
                method:"GET",  
                data:{query:query},  
                success:function(data) {  
                    htmls1 = '<select class="list-unstyled form-control form-group col-sm-8" id="id_user" name="selectproduct" onchange="table(this)">';
                        // console.log(htmls1);
                        $.each(data, function (k, i) { 
                            htmls1 += "<option value=\""+i.id+"\">"+i.nama+"</option>";  
                            // console.log(k,i);
                        });
                    htmls1 += '<option value="" selected>-- Select option --</option></select>';
                    htmls1 += '</select>'
                    $('.paket_lisy').html(htmls1);  
                }  
            });  
            }
            
    }
    );  
            
                    /////////////////////////////////      Modal SHOW DETAIL       //////////////////////////////////////
    function showdetail(id) {
        $("#modal_view").modal('show');
        $("#modaladd").modal('hide');
        $(".titlemodal").html(" View Paket");
        $(".icoon").html('<i class="bi bi-card-list"></i>');
        var j= "pcs"
        var url = "{{ asset('/paket/detail') }}/" + id;
            $.ajax({
                    url: url,
                    type: "get",
                    success: function(response) {
                        var tampung= "";
                        var tampung2= "";
                        data = response.data;
                        $.each(data.detail_paket, function (i, k) { 
                            tampung = tampung + k.nama + ", ";
                            
                            // console.log(k.nama);
                            $("#product_id").html(tampung);
                         })
                        // console.log(data.detail_paket);
                        $.each(data.detail_paket, function (i, v) { 
                            // console.log(i,v.jumlah);edituoiuiou
                            tampung2 = tampung2 + v.jumlah + ", ";
                            $("#jumlah_id").html(tampung2);
                         })
                        
                        $("#paket_id").html(data.nama_paket);
                        // $.each(data, function (i,v) { 
                        //     console.log(i,v);
                        //     tampung = tampung + k.nama + ", ";
                        //  })
                        // console.log(data.products);
                        // // $("#satuan_id").html(data.satuan);
                        // var tampungUser = "";


                        
                        // $.each(JSON.parse(data.jumlah), function (k, i) { 
                        //     console.log(i);
                        //     $.each(i, function(l,m){
                        //         tampungUser = tampungUser + m + ", ";
                        //         console.log(l,m);
                        //       
                        //     })
                        // })
                        $('#modal_view').modal('hide');
                    }
                }); 
                $("#id_name").val(id);
                  $('#editt').attr('data-id', id);
              
                
            }
                // $(".closeModalmodaladd").click(function() {
                //     $("#modaladd").modal('hide');
                // });
                $(".closeModalmodaladd").click(function() {
                    $("#modal_view").modal('hide');
                });

    function table(a) { 
        id = $(a).val();
        $(".option-table").show();
        var hidden = $("#user_group").val();
        var tampung = hidden + ', ' + id;
        nama = $( "#id_user option:selected" ).text();
        const pattern = new RegExp('(' + id + ')', 'gm');
        let m;

        if(m = pattern.exec(hidden) == null) {
            $("#user_group").val(tampung);}

        var url = "{{ asset('/api/tableproduct/getdata') }}/" + id;
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {

                    var htmlinput = '<tr class="" id="row-'+response.data[0][5]+'">\
                    <td class="sorting_1">'+response.data[0][0]+'</td>\
                    <td>'+response.data[0][1]+'</td>\
                    <td>'+response.data[0][2]+'</td>\
                    <td>'+response.data[0][3]+'</td>\
                    <td class="  dt-body-center">\
                        <div class="form-group row">\
                            <div class="col-xs-2"><input type="number" name="jumlah[\'id\']['+response.data[0][5]+']" id="jumlah-'+response.data[0][5]+'" class="form-group form-control jumlah"></div>\
                        </div>\
                    </td>\
                    <td class="  dt-body-center"><span class="btn btn-danger deletee btn-sm" onclick="kurangininput('+response.data[0][5]+')"><i class="bi bi-trash-fill"></i></span></td>\
                     </tr>';
                    var table3 = document.querySelector("#listgudangtable tbody");
                    // if(table3.innerHTML == '<tr class="odd"></tr>') {
                    //     table3.innerHTML = '';
                    // }
                    const regex = new RegExp('(row-' + id + ')', 'gm');
                    let m;
                    

                    if(regex.exec(table3.innerHTML) == null)
                        table3.innerHTML = table3.innerHTML + htmlinput;
                    else {
                        Swal.fire({
                            icon: 'danger',
                            title: 'Warning',
                            html:'Data <b>Sudah ada</b>'
                        });
                    }
            }
        });
    }

             

    function kurangininput(a) { 
        var tampung = $("#user_group").val();
        tampung = tampung.replace(", "+a, "");
        $("#user_group").val(tampung);
        var rowid = '#row-'+a;
        var table = $('#listgudangtable').DataTable();
        // console.log(a);
        // $('.deletee').on( 'click', 'tbody tr', function () {
        //     table.row( a ).remove();
        // } );\ 
       $('#listgudangtable tbody').on( 'click', 'tr', function () {
            table
                .row('#'+a+'')
                .remove()
                .draw(false);
        } );

        Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                html:'Data Berhasil <b>Dihapus</b>'
            });
}
    $(document).ready(function () {
        var ttt = $('#PaketTable').DataTable();
    
        $('#PaketTable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                ttt.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    
        $('.del').click(function () {
            ttt.row('.selected').remove().draw(false);
        });
    });


    // $('#listgudangtable tbody').on('click', 'tr', function () {
    //     if ($(this).hasClass('selected')) {
    //         $(this).removeClass('selected');
    //     } else {
    //         table.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
    //     }
    // });
 
    // $('.deletee').click(function () {
    //     table.row('.selected').remove().draw(false);
    //     Swal.fire({
    //             icon: 'success',
    //             title: 'Berhasil',
    //             html:'Data Berhasil <b>Dihapus</b>'
    //         });
            
    // });
     
      
    function editshow(id) {
        id = $(id).val();
        idx = $('#editt').attr('data-id');

        $('#modaladd').modal('show');
        $("#modal_view").modal('hide');
        $(".tutuptable").hide();
        $(".titlemodal").html(' Edit Paket')
        $('.icoon').html('<i class="bi bi-pencil-square"></i>');
        $("#paketid").val("");
        $('.paket_lisy').html("");
        $('#user_group').hide();
        $(".option-table").show("");
        $('.copy').html("");
        $(".control-group after-add-more").html("");
        var id = $("#id_name").val();

        var url = "{{ asset('/paket/edit') }}/" + idx;
                $.ajax({
                    url: url,
                    type: "GET",
                        success: function(response) {
                            data = response.data

                                var tampungUser = inHtml= "";

                                $.each(data.products, function(k, item){
                                    // console.log(k,item.id);

                                    tampungUser = tampungUser + ", " + item.id;
                                    $("#user_group").val(tampungUser)
                                });
                                



                            var coba =  $("#jumlah").val(data.jumlah);
                            // $('.jumlah').val('Jane');
                            // console.log(coba);
                            // console.log(data.jumlah);

                            $("#nama_paket").val(data.list_paket[0].nama_paket);
                            // $("#jumlah").val(data.jumlah);
                         
                            // $('#id_user option[value="'+data.products[0].id+'"]').prop('selected', true);
                            // $(".odd").val("fa");
                        }});

                        var urltable = "{{ asset('/api/tableproduct/edit') }}/" + idx;
                        $('#listgudangtable').DataTable().ajax.url(urltable).load();


    }

    function reloaddata() {
        var url = "{{ asset('/api/paket/getdata') }}";
        $('#PaketTable').DataTable().ajax.url(url).load();
    }
    function reloaddatadelete() {
        id = $(a).val();
        var url = "{{ asset('/api/tableproduct/getdata') }}/" + id;
        $('#listgudangtable').DataTable().ajax.url(url).load();
    }
        </script>
    @endsection
</x-app-layout>

