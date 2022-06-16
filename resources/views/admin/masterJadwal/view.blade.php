
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
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Menu Master Jadwal</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <div class="container">
                  <div id="gridMasterJadwal"></div>                
                </div>
                <div id="action-sheet"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
              <div class="card-header pb-0">
                <h6 id="headerEditForm"></h6>
              </div>
              <div class="card-body p-3">
                <form id="formEdit"></form>
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
      $("#btnMasterJadwal").addClass('active bg-gradient-primary');
      function loadData() {
        $.ajax({
          url: "{{route('jadwalData')}}",
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
    					Edit(value.itemData.id,"Edit Jadwal");
            }
            if(value.itemData.text=='Delete'){
              Delete(value.itemData.id);
            }
            if(value.itemData.text=='Generate') {
              Generate(value.itemData.id);
            }
          },
        }).dxActionSheet('instance');

        var gridJadwal = $("#gridMasterJadwal").dxDataGrid({
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
                      // width:50,
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
                        caption:"Nama Matkul",
                        alignment: "left",
                    },
                    {
                        dataField: "dosen_name",
                        caption:"Dosen",
                        alignment: "left",
                    },
                    {
                        dataField: "teach_date_from",
                        caption:"Dari",
                        dataType: 'datetime',
                        format: "dd/MM/yyyy HH:mm",
                        alignment: "left"
                    },
                    {
                        dataField: "teach_date_to",
                        caption:"Sampai",
                        dataType: 'datetime',
                        format: "dd/MM/yyyy HH:mm",
                        alignment: "left",
                    },
                    {
                        dataField: "deadline_date",
                        dataType: 'datetime',
                        caption:"Deadline Tugas",
                        format: "dd/MM/yyyy HH:mm",
                        alignment: "left",
                    },
                    {
                      dataField: "generated",
                      caption: 'Status',
                      alignment: "center",
                      // width:200,	
                      cellTemplate: function (container, options) {
                        if(options.value=='0'){
                          $('<div/>').html('<a style="padding:5px;"class="btn btn-warning text-white me-0">BELUM GENERATE</a>')
                                                  .appendTo(container); 
                        }else if(options.value=='1'){
                          $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-success text-white me-0">SUDAH GENERATE</a>')
                                                  .appendTo(container); 
                        }
                      }
                    },
              ],
              onToolbarPreparing: function(e){
                e.toolbarOptions.items.unshift(
                {
                  location: "before",
                  widget: "dxButton",
                  locateInMenu:"auto",
                  options: {
                    icon: "fa fa-plus",
                    type: "success",
                    text: "Tambah Data",
                    elementAttr: {"id": "btnTambahJadwal"}, 
                      onClick: function(e) {
                        $("#headerEditForm").text("TAMBAH JADWAL KULIAH");
                        Edit(null,"Tambah Data Jadwal Kuliah");
                      }
                  }
                })
              },
              onCellClick: function(e) {
                if(e.columnIndex===6){
                  actionSheet.option('target', e.cellElement);
                  actionSheet.option('visible', true);
                  if (e.data.generated == 0) {
                    const actionSheetItems = [
                        { text: 'Edit',icon: 'edit',id:e.data.id},
                        { text: 'Generate',icon: 'refresh',id:e.data.id},
                        { text: 'Delete',icon: 'trash',type: 'danger',id:e.data.id},
                    ];
                    actionSheet.option('items',actionSheetItems);
                  } else {
                    const actionSheetItems = [
                        { text: 'Edit',icon: 'edit',id:e.data.id},
                        { text: 'Delete',icon: 'trash',type: 'danger',id:e.data.id},
                    ];
                    actionSheet.option('items',actionSheetItems);
                  }

               }
          },
          }).dxDataGrid("instance");
      }

      function Edit(id,title){
        $("#headerEditForm").text(title);
        $.ajax({
            url: "{{route('jadwalEdit')}}",
            dataType: "json",
            type: 'GET',
            data:{id:id},
            success: function(result) {
              LoadForm(result);
            },
            error: function(e) {
            },
        });

        const role = [
            {ID: 2,Name: 'Panitia'},
            {ID: 3,Name: 'Dosen'},
            {ID: 4,Name: 'Peserta'},
        ];

        function LoadForm(data) {
          $("#formEdit").dxForm({
            readOnly: false,
            formData: data,
            showColonAfterLabel: false,
            labelLocation: "top",
            showValidationSummary: true,
            colCount: 2,
            items: [
              {
                colSpan:2,
                dataField: "id",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: true,
                  width: '100%',
                },
                label: {
                  text: "ID"
                },
              },
              {
                colSpan:2,
                dataField: "public_id",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: true,
                  width: '100%',
                },
                label: {
                  text: "Public ID"
                },
              },
              {
                colSpan:2,
                dataField: "name",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Nama Mata Kuliah"
                },
              },
              {
                colSpan:2,
                dataField: "teach_date_from",
                editorType: "dxDateBox",
                editorOptions: {
                    type: "datetime",
                    displayFormat: 'dd-MM-yyyy HH:mm',
                    readOnly: false,
                    width: '100%',
                },
                label: {
                  text: "Dari"
                },
              },
              {
                colSpan:2,
                dataField: "teach_date_to",
                editorType: "dxDateBox",
                editorOptions: {
                    type: "datetime",
                    displayFormat: 'dd-MM-yyyy HH:mm',
                    readOnly: false,
                    width: '100%',
                },
                label: {
                  text: "Sampai"
                },
              },
              {
                colSpan:2,
                dataField: "deadline_date",
                editorType: "dxDateBox",
                editorOptions: {
                    type: "datetime",
                    displayFormat: 'dd-MM-yyyy HH:mm',
                    readOnly: false,
                    width: '100%',
                },
                label: {
                  text: "Deadline Tugas"
                },
              },
              {
                colSpan:2,
                dataField: "dosen_id",
                editorType: "dxSelectBox",
                editorOptions: {
                    readOnly: false,
                    width: '100%',
                    searchEnabled: true,
                    dataSource: Pku.ParameterLookup("Dosen", "Dosen"),
                    displayExpr: "Name",
                    valueExpr: "ID",
                },
                label: {
                    text: "Dosen"
                },
              },
              @if(Auth::user()->role == 1)
              {
                colSpan:2,
                dataField: "is_display",
                editorType: "dxNumberBox",
                editorOptions: {
                  visible: true,
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Display"
                },
              },
              @endif
              {
                colSpan:2,
                dataField: "weekend_to",
                editorType: "dxNumberBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Minggu Ke"
                },
              },
              {
                  editorType: "dxButton",
                  label: {
                    text: "SIMPAN",
                    visible: false
                  },
                  editorOptions: {
                    text: "SIMPAN",
                    type: "success",
                    icon: 'save',
                    height: '100%',
                    useSubmitBehavior: true,
                    elementAttr: {
                        style: "float:right;"
                    }
                  },
              },

            ]
          }).dxForm("instance");
        };
      }

      $("#formEdit").submit(function(e){
          e.preventDefault();

          var form = $('#formEdit')[0];
          var formData = new FormData(form);
          loadPanel.show();

          $.ajax({
            type: 'POST',
            headers: {  
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route("jadwalSave") }}',
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
                  loadData();
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

      function Delete(id) {
        swal({
            title: "Delete",
            text: "Anda yakin Menghapus Data Ini ?",
            icon: "warning",
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
                    url: '{{route('jadwalDelete')}}',
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
                    url: '{{route('jadwalGenerate')}}',
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