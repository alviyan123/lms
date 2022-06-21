
<!DOCTYPE html>
<html lang="en">
    @include('/admin/partial/head')  
<body class="g-sidenav-show  bg-gray-200">
    @include('/admin/partial/aside')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('/admin/partial/navbar')
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Menu Master Micro Learning</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <div class="container">
                  <div id="gridMasterMicroTeach"></div>                
                </div>
                <div id="action-sheet"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>INPUT MICROLEARNING</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <div class="container">
                  <form id="formMt">
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                        <div class="dx-field">
                          <div class="dx-field-label">ID</div>
                          <div class="dx-field-value">
                            <div id="id_micro_learning"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-3">
                        <div class="dx-field">
                          <div class="dx-field-label">Name</div>
                          <div class="dx-field-value">
                            <div id="name_micro_learning"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-3">
                        <div class="dx-field">
                          <div class="dx-field-label">Dari</div>
                          <div class="dx-field-value">
                            <div id="teach_date_from"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-3">
                        <div class="dx-field">
                          <div class="dx-field-label">Sampai</div>
                          <div class="dx-field-value">
                            <div id="teach_date_to"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 mb-3">
                        <div class="dx-field">
                          <div class="dx-field-label">Dead Line</div>
                          <div class="dx-field-value">
                            <div id="deadline_date"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <textarea id="inputSoal" name="soal"></textarea>
                    <button type="submit" class="btn btn-success">SIMPAN</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        @include('/admin/partial/footer')
    </div>
  </main>

    @include('/admin/partial/mainly')
  <!--   Core JS Files   -->
  @include('/admin/partial/script')
  <script type="application/javascript">
    $(document).ready(function() {
      $("#btnMasterML").addClass('active bg-gradient-primary');
      function loadData() {
        $.ajax({
          url: "{{route('microLearningData')}}",
          dataType: "json",
          type: 'GET',
          success: function(result) {
            LoadGrid(result);
          },
          error: function(e) {
          },
        });
      }
      loadData();

      function LoadGrid(data) {
        const actionSheet = $('#action-sheet').dxActionSheet({
          title: 'Action',
          usePopover: true,
          width:"300px",
          onItemClick(value) {
            if(value.itemData.text=='Edit'){
    					Edit(value.itemData.id,"Edit");
            }
            if(value.itemData.text=='Delete'){
              Delete(value.itemData.id);
            }
            if(value.itemData.text=='Generate') {
              Generate(value.itemData.id);
            }
          },
        }).dxActionSheet('instance');

        var gridMicroTeach = $("#gridMasterMicroTeach").dxDataGrid({
              dataSource: {
                  store: data
              },
              loadPanel: {
                  enabled: false
              },
                searchPanel: {
                    visible: true
              },
                columnHidingEnabled: false,
                showColumnLines: true,
                showRowLines: true,
                showBorders: true,
                columnResizingMode: "nextColumn",
                columnAutoWidth: true,
                columnMinWidth: 50,
                height: 530,
                remoteOperations: {
                  paging: true,
                    filtering: true,
                    sorting: true,
                },
                paging: {
                  enabled: true,
                    pageSize: 15,
                },
                pager: {
                  visible: true,
                    showPageSizeSelector: true,
                    allowedPageSizes: [15, 30, 50],
                    showInfo: true,
              showNavigationButtons: true,
                },
                allowColumnReordering: true,
                rowAlternationEnabled: true,
                "export":{
                    enabled:false,
                    fileName:"Data User"
                },
                filterRow: {
                    visible: true,
                    applyFilter: "auto"
                },
                headerFilter: {
                    visible: true
                },
                editing: {
                    allowAdding: false,
                    allowUpdating: false,
                    allowDeleting: false
                },
                columns: [
                    {
                      caption:"Action",
                      width:100,
                      alignment: "center",
                      fixed:true,
                      fixedPosition:"right",
                      allowEditing: false,
                          cellTemplate: function (container, options) {
                                $('<div/>').html('<a><i type="button" class="fa fa-list"></i></a>')
                                          .appendTo(container);   
                            
                      }
                    },
                    {
                        dataField: "name",
                        caption:"NAMA",
                        alignment: "left",
                    },
              ],
              onCellClick: function(e) {
                if(e.columnIndex===1){
                actionSheet.option('target', e.cellElement);
                actionSheet.option('visible', true);
                const actionSheetItems = [
                    { text: 'Edit',icon: 'edit',id:e.data.id},
                    { text: 'Delete',icon: 'trash',type: 'danger',id:e.data.id},
                    { text: 'Generate',icon: 'refresh',id:e.data.id},
                ];
                actionSheet.option('items',actionSheetItems);

               }
          },
          }).dxDataGrid("instance");
      }

      tinymce.init({
        selector: '#inputSoal',
        plugins: [
          'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
          'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
          'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
      });

      $('#teach_date_from').dxDateBox({
        type: 'datetime',
        displayFormat: 'yyyy-MM-ddTHH:mm:ss',
      }).dxDateBox("instance");
      $('#teach_date_to').dxDateBox({
        type: 'datetime',
        displayFormat: 'yyyy-MM-ddTHH:mm:ss',
      }).dxDateBox("instance");
      $('#deadline_date').dxDateBox({
        type: 'datetime',
        displayFormat: 'yyyy-MM-ddTHH:mm:ss',
      }).dxDateBox("instance");
      $('#id_micro_learning').dxTextBox({
        placeholder: 'ID Micro Learning...',
        readOnly: true,
      }).dxTextBox("instance");
      $('#name_micro_learning').dxTextBox({
        placeholder: 'Name ML',
        readOnly: false,
      }).dxTextBox("instance");
      


      $("#formMt").submit(function (e) { 
        e.preventDefault();
        var form = $('#formMt')[0];
        var formData = new FormData(form);
        formData.append('teach_date_from',$('#teach_date_from').dxDateBox("instance").option('text'));
        formData.append('teach_date_to',$('#teach_date_to').dxDateBox("instance").option('text'));
        formData.append('deadline_date',$('#deadline_date').dxDateBox("instance").option('text'));
        formData.append('id_micro_learning',$('#id_micro_learning').dxTextBox("instance").option('value'));
        formData.append('name',$('#name_micro_learning').dxTextBox("instance").option('value'));


        loadPanel.show();

        $.ajax({
          type: 'POST',
          headers: {  
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{{ route("microLearningSave") }}',
          enctype: 'multipart/form-data',
          cache: false,
          contentType: false,
          processData: false,
          data:formData,
          success: function (res)
          {
              loadPanel.hide();
              if (res.success == true) {
                Pku.WindowNotif( "OK" ,  res.message,  'success' );
                // loadData();
                return false;
              }else{
                Pku.WindowNotif ( "Oops" ,  res.message,  'error' );
                return false; 
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              loadPanel.hide();
              Pku.WindowNotif ( "Oops" ,  jqXHR.responseText,  'error' );
              return false;
          }
        }).done(function (data) {
              loadPanel.hide();
        });
      });

      function Generate(id) {
        swal({
            title: "Generate",
            text: "Anda yakin Generate Data Ini ?",
            icon: "info",
            buttons: [
                "TIDAK",
                "YA"
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'POST',
                    headers: {  
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('microLearningGenerate')}}',
                    data: {"id":id},
                    dataType: "json",
                    success: function (data) {
                        if (data.success == true) {
                          Pku.WindowNotif( "OK" ,  data.message,  'success' );
                          loadData();
                        }else {
                          Pku.WindowNotif ( "Oops" ,  data.message,  'error' );
                        }
                        return false;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                      Pku.WindowNotif ( "Oops" ,  jqXHR.responseText,  'error' );
                        return false;
                    }
                });                                    
            }
        });
      }
    });
  </script>
</body>

</html>