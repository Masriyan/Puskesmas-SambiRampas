<!-- page content -->
<div class="right_col" role="main">

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Jenis Pembayaran</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <button class="btn btn-success" onclick="add_jepem()"><i class="glyphicon glyphicon-plus"></i> Jenis Pembayaran</button>
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap myTable" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Jenis Pembayaran</th>
                <th>Action</th>
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

<script type="text/javascript">
  var save_method;
  var table;
  $(document).ready(function() {
    //dataTable
    table = $('.myTable').DataTable({
        // "bDestroy": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('jepem/ajax_list')?>",
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

  function add_jepem()
  {
      save_method = 'add';
      $('.form-group').show();
      $('.text').hide();
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Jenis Pembayaran'); // Set Title to Bootstrap modal title
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
              "url": "<?php echo base_url('jepem/ajax_list')?>",
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
      // console.log("ini ada looo + ");
  }

  function save()
  {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;

      if(save_method == 'add') {
        url = "<?php echo base_url('jepem/ajax_add')?>";
      } else if (save_method == 'update'){
        url = "<?php echo base_url('jepem/ajax_update')?>";
      }else {
        url = "<?php echo base_url('jepem/ajax_delete')?>";
      }

      // ajax adding data to database
      $.ajax({
          url : url,
          type: "POST",
          data: $('#form').serialize(),
          dataType: "JSON",
          success: function(data)
          {
            console.log(data);
              if(data.status) //if success close modal and reload ajax table
              {
                  $('#modal_form').modal('hide');
                  $('.form-group').show();
                  $('.text').hide();
                  reload_table();
              }
              else
              {
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

  function edit_jepem(id)
  {
    save_method = 'update';
    $('.form-group').show();
    $('.text').hide();
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('jepem/ajax_edit')?>",
        type: "POST",
        dataType: "JSON",
        data: "id="+id,
        success: function(data)
        {
          // console.log(data);
            $('input[name="id"]').val(data.id_pembayaran);
            $('input[name="nama"]').val(data.nama_pembayaran);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Jenis Pembayaran'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  } 

  function delete_jepem(id)
  {
      save_method = "delete";
      $('#form')[0].reset();
      $('input[name=id]').val(id);
      // $('input[name=nama]').setAttribute('type', 'hidden');
      $('.form-group').attr({
        style: 'display:none'
      });
      $('.modal-title').text('Delete Jenis Pembayaran');
      $('#text').attr({
        style: 'display:block'
      });
      $('#text').text("Apakah Anda Yakin Akan Menghapus Data Ini ?");
      $('#modal_form').modal('show');
  }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
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
                        <div class="text" id="text"></div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Jenis Pembayaran</label>
                            <div class="col-md-9">
                                <input name="nama" placeholder="Nama Jenis Pembayaran" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
