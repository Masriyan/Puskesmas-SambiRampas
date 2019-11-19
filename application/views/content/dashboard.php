<!-- page content -->
<div class="right_col" role="main">

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Dashboard</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div id="echart_line" style="height:350px;"></div>

        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Data Kunjungan</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-inline">
            <div class="form-group">
              <label class="sr-only">Email</label>
              <p class="form-control-static">Masukkan No Pasien</p>
            </div>
            <div class="form-group mx-sm-3">
              <label for="inputPassword2" class="sr-only">No Pasien</label>
              <input type="text" class="form-control" id="inputNoPas" placeholder="No Pasien">
            </div>
            <button class="btn btn-success" type="button" style="margin-bottom:0px;" onclick="add_remed()"><i class="glyphicon glyphicon-plus"></i> Data Rekam Medis</button>
          </form>
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap myTable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">No Rekam Medis</th>
                <th style="text-align:center;">Keluhan</th>
                <th style="text-align:center;">Poli</th>
                <th style="text-align:center;">Tanggal Periksa</th>
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

<!-- MODAL BEGIN -->
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
                    <input type="hidden" name="noRm" value="">
                    <div class="form-body">

                      <div class="form-group">
                        <label class="control-label col-md-3">No Kartu Rekam Medis</label>
                        <div class="col-md-9 " id="noRm">
                          <!-- <input type="text" class="form-control" name="noRm" id="noRm" readonly="readonly"> -->
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
<div class="modal fade" id="modal_detail_remed" role="dialog">
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
                      <div class="col-md-12">
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
                            <div class="form-group">
                              <label class="col-md-4 control-label">Nama</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="namaDet">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">Poli</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="nmPol">*</p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-4 control-label">Keluhan</label>
                              <div class="col-md-8">
                                <p class="form-control-static" id="keluhDet">*</p>
                              </div>
                            </div>
                          </form>
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
<!-- MODAL END -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>

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
            "url": "<?php echo base_url('remed/ajax_list')?>",
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

  function detail_remed(id){
    // console.log(idRm);
    $.ajax({
      url: '<?= base_url()."remed/getDetRemed";?>',
      type: 'POST',
      dataType: 'json',
      data: "idDet="+id
    })
    .done(function(res) {
      // console.log(data[0].no_kartu_rekam_medis);
      $.ajax({
        url: "<?= base_url("pasien/getDetPasien")?>",
        type: "POST",
        dataType: "JSON",
        data: "idRm="+res[0].no_kartu_rekam_medis,
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            $('#noDetPas').html(data[i].no_pasien);
            $('#noDetRem').html(data[i].no_kartu_rekam_medis);
            $('#noDetKk').html(data[i].no_kk);
            $('#namaDet').html(data[i].nama_pasien);
          }
          $("#nmPol").html(res[0].nama_poli);
          $("#keluhDet").html(res[0].keluhan);
        }
      });

      $('.form-group').show();
      $('.text').hide();
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_detail_remed').modal('show'); // show bootstrap modal
      $('.modal-title').text('Detail Data Rekam Medis'); // Set Title to Bootstrap modal title
    })
    .fail(function() {
      console.log("error");
    });

  }

  function edit_remed($id) {
    save_method ="updateRm";
    $('#formAddRemed')[0].reset(); // reset form on modals
    $.ajax({
      url: '<?= base_url()."remed/getDetRemed";?>',
      type: 'POST',
      dataType: 'json',
      data: "idDet="+$id
    })
    .done(function(res) {
      // console.log(data[0].no_kartu_rekam_medis);
      $.ajax({
        url: "<?= base_url("pasien/getDetPasien")?>",
        type: "POST",
        dataType: "JSON",
        data: "idRm="+res[0].no_kartu_rekam_medis,
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
      $("input[name=noRm]").val(res[0].id_detail_remed);
      $("textarea[name=keluhan]").val(res[0].keluhan);
      $.ajax({
        url: "<?= base_url("jepol/detDataJePol")?>",
        type: "POST",
        data: "id="+res[0].id_poli,
        dataType: "json",
        success: function(data){
          $('#poli').html(data);
        }
      });
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_add_remed').modal('show'); // show bootstrap modal
      $('.modal-title').text('Edit Data Rekam Medis'); // Set Title to Bootstrap modal title
    })
    .fail(function() {
      console.log("error");
    });

  }

  function deleteRm(id) {
    save_method = "delete";
    $('input[name=idDel]').val(id);
    $('#modal_delete').modal('show');
  }

  function add_remed() {
    var idPsn = $("#inputNoPas").val();
    save_method = 'addRem';
    $('#formAddRemed')[0].reset(); // reset form on modals
    if (idPsn == "") {
      $("input[id=inputNoPas]").parent().removeClass('has-success');
      $("input[id=inputNoPas]").parent().fadeOut('fast').fadeIn().addClass('has-error');
      console.log("error a");
    }else {
      // var dt = parseInt(idPsn);
      if (/^[a-zA-Z()]+$/.test(idPsn)) {
        $("input[id=inputNoPas]").parent().removeClass('has-success');
        $("input[id=inputNoPas]").parent().fadeOut('fast').fadeIn().addClass('has-error');
        console.log("error b");
      }else {
        // $("input[id=inputNoPas]").parent().removeClass('has-error');
        // $("input[id=inputNoPas]").parent().fadeOut('fast').fadeIn().addClass('has-success');
        $.ajax({
          url: "<?= base_url("pasien/getDetDataPasien")?>",
          type: "POST",
          dataType: "JSON",
          data: "idPsn="+idPsn,
          success: function (data) {
            if (data.length > 0) {
              $("input[id=inputNoPas]").parent().removeClass('has-error');
              $("input[id=inputNoPas]").parent().fadeOut('fast').fadeIn().addClass('has-success');
              for (var i = 0; i < data.length; i++) {
                $('#noRm').html("<input type='text' class='form-control' value='"+data[i].no_kartu_rekam_medis+"' readonly></input>");
                $('#noPs').html("<input type='text' class='form-control' value='"+data[i].no_pasien+"' readonly></input>");
                $('#noKk').html("<input type='text' class='form-control' value='"+data[i].no_kk+"' readonly></input>");
                $('#namaAddRmPsmp').html("<input type='text' class='form-control' value='"+data[i].nama_pasien+"' readonly></input>");
                $('#np').html("<input type='text' class='form-control' value='"+data[i].nama_pembayaran+"' readonly></input>");
                $('#noTelp').html("<input type='text' class='form-control' value='"+data[i].no_telephon+"' readonly></input>");
                $('input[name=noRm]').val(data[i].no_kartu_rekam_medis);
              }
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
            }else {
              $("input[id=inputNoPas]").parent().removeClass('has-success');
              $("input[id=inputNoPas]").parent().fadeOut('fast').fadeIn().addClass('has-error');
               console.log("data tidak ditemukan, silahkan masukkan no Pasien.");
            }
          }
        });
      }
    }
  }

  function reload_table()
  {
      $('.myTable').DataTable({
          "bDestroy": true,
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.

          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "<?php echo base_url('remed/ajax_list')?>",
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

  function save(){
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      var dataForm;

      if(save_method == 'addRem') {
        url = "<?php echo base_url('remed/addDetailRemed')?>";
        dataForm = $('#formAddRemed').serialize();
      }else if (save_method == 'updateRm'){
        url = "<?php echo base_url('remed/updateRm')?>";
        dataForm = $('#formAddRemed').serialize();
      }else {
        url = "<?php echo base_url('remed/deleteRm')?>";
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
                  $("#formAddRemed")[0].reset();
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
