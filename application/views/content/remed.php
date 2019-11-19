<!-- page content -->
<div class="right_col" role="main">

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>REKAP MEDIS</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="alert alert-warning alert-dismissible" role="alert" style="background-color: #fff; color:#0c0202;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h2><strong>Perhatian !</strong></h2>
            <ol>
              <li><i class="btn btn-info glyphicon glyphicon-plus"></i> Simbol disambing digunakan untuk <strong>menambah rekap medis</strong> pasien.</li>
              <li><i class="btn btn-success glyphicon glyphicon-align-justify"></i> Simbol disamping digunakan untuk <strong>melihat detail</strong>
                 dari data pasien.</li>
              <li><i class="btn btn-warning glyphicon glyphicon-pencil"></i> Simbol disamping digunakan untuk <strong>mengubah</strong> data pasien.</li>
              <li><i class="btn btn-danger glyphicon glyphicon-trash"></i> Simbol disamping digunakan untuk <strong>menghapus</strong> data pasien.</li>
            </ol>
          </div>
          <button class="btn btn-success" onclick="add_pasien()"><i class="glyphicon glyphicon-plus"></i> Data Pasien</button>
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap myTable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">No Pasien</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">Pembayaran</th>
                <th style="text-align:center;">No Telephone</th>
                <th style="text-align:center;">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
  </div>
  </div>
</div>
<!-- /page content -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
<!-- <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script> -->
<!-- CkEditor -->
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/adapters/jquery.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
  var save_method;
  var table;
  $(document).ready(function() {
    table = $('.myTable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('pasien/ajax_list')?>",
            "type": "POST"
        },

        // Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
  });

  function reload_table(){
      $('.myTable').DataTable({
          "bDestroy": true,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.

          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "<?php echo base_url('pasien/ajax_list')?>",
              "type": "POST"
          },

          // Set column definition initialisation properties.
          "columnDefs": [
          {
              "targets": [ -1 ], //last column
              "orderable": false, //set not orderable
          },
          ],
      });
  }

  function add_pasien(){
    save_method = 'addPas';
    $('.form-group').show();
    $('.text').hide();
    $('#form')[0].reset(); // reset form on modals
    $.ajax({
      url:"<?= base_url('remed/randomNoPas')?>",
      type:"POST",
      success:function(data){
        $('input[name=noPas]').val(data);
      }
    });
    $.ajax({
      url:"<?= base_url('remed/randomNoRm')?>",
      type:"POST",
      success:function(data){
        $('input[name=noRm]').val(data);
      }
    });
    $.ajax({
      url: "<?= base_url("jepem/dataJePem")?>",
      type: "POST",
      dataType: "json",
      success: function(data){
        $('#jp').html(data);
        // console.log(data);
      }
    });
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_add_pasien').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Data Pasien'); // Set Title to Bootstrap modal title
  }

  function edit_pasien(id){
    save_method = 'editPas';
    $('.form-group').show();
    $('.text').hide();
    $('#form')[0].reset(); // reset form on modals
    $.ajax({
      url: "<?= base_url("pasien/getDetPasien")?>",
      type: "POST",
      data: "idRm="+id,
      dataType: "JSON",
      success: function(data){
        for (var i = 0; i < data.length; i++) {
          $('input[name=noPas]').val(data[i].no_pasien);
          $('input[name=noRm]').val(data[i].no_kartu_rekam_medis);
          $('input[name=nokk]').val(data[i].no_kk);
          $('input[name=nama]').val(data[i].nama_pasien);
          $('input[name=temLa]').val(data[i].tempat_lahir);
          $('input[name=tangLa]').val(data[i].tanggal_lahir);
          $('input[id=tangLa]').val(data[i].tanggal_lahir);

          // radio edit
          if (data[i].jenis_kelamin == "L") {
            $('#jkL').attr('checked', 'checked');
          }else {
            $('#jkP').attr('checked', 'checked');
          }
          // combo box set
          $.ajax({
            url: "<?= base_url("jepem/detDataJePem")?>",
            type: "POST",
            data: "id="+data[i].id_pembayaran,
            dataType: "json",
            success: function(data){
              $('#jp').html(data);
            }
          });

          $('input[name=noTelp]').val(data[i].no_telephon);
          $('textarea[name=alamat]').html(data[i].alamat);

        }
      }
    });
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_add_pasien').modal('show'); // show bootstrap modal
    $('.modal-title').text('Edit Data Pasien'); // Set Title to Bootstrap modal title
  }

  function deletePasRm(id){
    save_method = "delete";
    $('input[name=idDel]').val(id);
    $('#modal_delete').modal('show');
  }

  function detail_remed(idRm){
    // console.log(idRm);
    $.ajax({
      url:'<?= base_url()."pasien/getDetPasien"?>',
      data:'idRm='+idRm,
      dataType:'JSON',
      type:'POST',
      success:function(data){
        for (var i = 0; i < data.length; i++) {
          // console.log(data[i].alamat);
          $('#noDetPas').html(data[i].no_pasien);
          $('#noDetRem').html(data[i].no_kartu_rekam_medis);
          $('#noDetKk').html(data[i].no_kk);
          $('#namaDet').html(data[i].nama_pasien);
          $('#noDetHp').html(data[i].no_telephon);
          $('#pembDet').html(data[i].nama_pembayaran);
          $('#nameDet').html(data[i].nama_pasien);
          $('#ttlDet').html(data[i].tempat_lahir+", "+data[i].tanggal_lahir);
          $('#jkDet').html(data[i].jenis_kelamin);
          $('#alamatDet').html(data[i].alamat);
        }
      }
    });
    $.ajax({
      url: "<?= base_url("remed/detRemed")?>",
      data:"id="+idRm,
      type: "POST",
      dataType: "JSON",
      success: function(data){
        $('#table-content').html(data);
        // console.log(data);
      }
    });
    $('.form-group').show();
    $('.text').hide();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_detail_pasien').modal('show'); // show bootstrap modal
    $('.modal-title').text('Detail Data Rekam Medis Pasien'); // Set Title to Bootstrap modal title
  }

  function add_remed(idRm){
    save_method = 'addRem';
    $('#formAddRemed')[0].reset(); // reset form on modals
    $('input[name=noRm]').val(idRm);
    $.ajax({
      url: "<?= base_url("pasien/getDetPasien")?>",
      type: "POST",
      dataType: "JSON",
      data: "idRm="+idRm,
      success: function (data) {
        for (var i = 0; i < data.length; i++) {
          $('#noPs').html("<input type='text' class='form-control' value='"+data[i].no_pasien+"' readonly></input>");
          $('#noKk').html("<input type='text' class='form-control' value='"+data[i].no_kk+"' readonly></input>");
          $('#namaAddRmPsmp').html("<input type='text' class='form-control' value='"+data[i].nama_pasien+"' readonly></input>");
          $('#np').html("<input type='text' class='form-control' value='"+data[i].nama_pembayaran+"' readonly></input>");
          $('#noTelp').html("<input type='text' class='form-control' value='"+data[i].no_telephon+"' readonly></input>");
        }
      }
    });
    $.ajax({
      url: "<?= base_url("jepol/dataJePol")?>",
      type: "POST",
      dataType: "json",
      success: function(data){
        $('#poli').html(data);
      }
    });
    $('.form-group').show();
    $('.text').hide();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_add_remed').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Data Rekam Medis Pasien'); // Set Title to Bootstrap modal title
  }

  function save(){
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      var dataForm;

      if(save_method == 'addPas') {
        url = "<?php echo base_url('pasien/addPasien')?>";
        dataForm = $('#form').serialize();
      } else if(save_method == 'addRem') {
        url = "<?php echo base_url('remed/addDetailRemed')?>";
        dataForm = $('#formAddRemed').serialize();
      }else if (save_method == 'editPas'){
        url = "<?php echo base_url('pasien/updatePasien')?>";
        dataForm = $('#form').serialize();
      }else {
        url = "<?php echo base_url('remed/delete')?>";
        dataForm = $('#formDelete').serialize();
      }

      // ajax adding data to database
      console.log(dataForm,url);
      $.ajax({
          url : url,
          type: "POST",
          data: dataForm,
          dataType: "JSON",
          success: function(data)
          {
            // console.log(data);
              if(data.status) //if success close modal and reload ajax table
              {
                  $('#modal_add_remed').modal('hide');
                  $('#modal_add_pasien').modal('hide');
                  $('#modal_delete').modal('hide');
                  $('.form-group').show();
                  $('.text').hide();
                  reload_table();
              }else{
                  for (var i = 0; i < data.inputerror.length; i++)
                  {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable

          }
      });
  }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_add_pasien" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id" value="">
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">No Pasien</label>
                        <div class="col-md-9 ">
                          <input type="text" class="form-control" name="noPas" id="noPas" readonly="readonly" placeholder="No Pasien">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">No Kartu Rekam Medis</label>
                        <div class="col-md-9 ">
                          <input type="text" class="form-control" name="noRm" id="noRm" readonly="readonly" placeholder="No Kartu Rekam Medis">
                        </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">No Kartu Keluarga</label>
                          <div class="col-md-9">
                              <input name="nokk" id="nokk" placeholder="No Kartu Keluarga" class="form-control" type="text">
                              <span class="help-block"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Nama</label>
                          <div class="col-md-9">
                              <input name="nama" id="nama" placeholder="Nama Hak Akses" class="form-control" type="text">
                              <span class="help-block"></span>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Tempat, Tanggal Lahir</label>
                          <div class="col-md-9">
                              <div class="col-md-8" style="padding-left:0px;">
                                <input name="temLa" placeholder="Tempat Lahir" class="form-control" type="text">
                              </div>
                              <div class="col-md-4" style="padding-right:0px;">
                                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                    <input class="form-control tangLa" id="tangLa" size="16" type="text" value="" readonly placeholder="Tanggal Lahir">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <input type="hidden" id="dtp_input2" class="tangLa" value="2017-05-05" name="tangLa"/>
                              </div>
                          </div>

                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Kelamin</label>
                        <div class="col-md-9"  id="jeKel">
                          <div class="radio">
                            <label>
                              <input type="radio" name="jk" id="jkL" value="L">Laki- Laki
                            </label>
                            <label style="margin-left: 5%;">
                              <input type="radio" name="jk" id="jkP" value="P">Perempuan
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Jenis Pembayaran</label>
                        <div class="col-md-9 ">
                          <select class="form-control" id="jp" name="jp"></select>
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">No Telephone</label>
                        <div class="col-md-9">
                          <input name="noTelp" placeholder="No Telephone" class="form-control" type="text">
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Alamat</label>
                        <div class="col-md-9 ">
                          <textarea class="form-control" name="alamat" id="alamat" rows="5" placeholder="Alamat"></textarea>
                          <span class="help-block"></span>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary pull-left">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_add_remed" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="formAddRemed" class="form-horizontal">
                    <input type="hidden" name="id" value="">
                    <div class="form-body">

                      <div class="form-group">
                        <label class="control-label col-md-3">No Kartu Rekam Medis</label>
                        <div class="col-md-9 ">
                          <input type="text" class="form-control" name="noRm" id="noRm" readonly="readonly" placeholder="No Kartu Rekam Medis">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">No Pasien</label>
                        <div class="col-md-9" id="noPs"></div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">No Kartu Keluarga</label>
                          <div class="col-md-9" id="noKk"></div>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3">Nama</label>
                          <div class="col-md-9" id="namaAddRmPsmp"></div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Jenis Pembayaran</label>
                        <div class="col-md-9 " id="np"></div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3">No Telephone</label>
                        <div class="col-md-9" id="noTelp"></div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Keluhan</label>
                        <div class="col-md-9 ">
                          <textarea class="form-control" id="keluhan" name="keluhan" rows="5" placeholder="Keluhan"></textarea>
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Poli</label>
                        <div class="col-md-9 ">
                          <select class="form-control" id="poli" name="poli"></select>
                          <span class="help-block"></span>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary pull-left">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail_pasien" role="dialog">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                      <!-- <h1 class="text-center"><small><u>Detail Data</u></small></h1> -->
                      <div class="col-md-6">
                          <form class="form-horizontal">
                            <div class="form-group">
                              <label class="col-md-4 control-label">No Pasien</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="noDetPas">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">No Rekam Medis</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="noDetRem">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">No KK</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="noDetKk">*</p>
                              </div>
                            </div>
                          </form>
                      </div>
                      <div class="col-md-6">
                        <form class="form-horizontal">
                          <div class="form-group">
                            <label class="col-md-4 control-label">Nama</label>
                            <div class="col-md-8">
                              <p class="form-control-static" id="namaDet">*</p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">No Handphone</label>
                            <div class="col-md-8">
                              <p class="form-control-static" id="noDetHp">*</p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 control-label">Pembayaran</label>
                            <div class="col-md-8">
                              <p class="form-control-static" id="pembDet">*</p>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a data-toggle="tab" href="#home">Data Diri</a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#menu1">Rekam Medis</a>
                        </li>
                      </ul>

                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active"><br>
                          <form class="form-horizontal">
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Nama</label>
                              <div class="col-sm-10">
                                <p class="form-control-static" id="nameDet">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Tempat, Tanggal Lahir</label>
                              <div class="col-sm-10">
                                <p class="form-control-static" id="ttlDet">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Jenis Kelamin</label>
                              <div class="col-sm-10">
                                <p class="form-control-static" id="jkDet">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Alamat</label>
                              <div class="col-sm-10">
                                <p class="form-control-static" id="alamatDet">*</p>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                          <br>
                          <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Keluhan</th>
                                <th style="text-align:center;">Poli</th>
                                <th style="text-align:center;">Tanggal Periksa</th>
                              </tr>
                            </thead>
                            <tbody id="table-content">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Oke</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- modal Bootstrap -->
<div class="modal fade" id="modal_delete" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Delete</h3>
      </div>
      <div class="modal-body">
        <form id="formDelete">
          <input type="hidden" name="idDel" value="">
          <label for="" class="control-label">Apakah Anda Yakin Ingin Menghapus Data Ini ?</label>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary pull-left">Delete</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- modal Bootstrap -->
