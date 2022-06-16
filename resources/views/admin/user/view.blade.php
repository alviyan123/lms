
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
                  <h6>Menu User</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <div class="container">
                  <div id="gridUser"></div>                
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
      $("#btnUser").addClass('active bg-gradient-primary');
      function loadData() {
        $.ajax({
          url: "{{route('userData')}}",
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
    					Edit(value.itemData.id,"EDIT USER");
            }
            if (value.itemData.text=='Reset Password') {
              ResetPassword(value.itemData.id,"RESET PASSWORD USER");
            }
            if (value.itemData.text=='Delete') {
              Delete(value.itemData.id);
            }
          },
        }).dxActionSheet('instance');

        var gridUser = $("#gridUser").dxDataGrid({
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
                        caption:"Nama",
                        alignment: "left"
                    },
                    {
                        dataField: "username",
                        caption:"Username",
                        alignment: "left"
                    },
                    {
                        dataField: "phone",
                        caption:"No. HP",
                        alignment: "left"
                    },
                    {
                        dataField: "generation",
                        caption:"Angkatan",
                        alignment: "left"
                    },
                    {
                        dataField: "envoy",
                        caption:"Utusan",
                        alignment: "left"
                    },
                    {
                        dataField: "address",
                        caption:"Alamat",
                        alignment: "left"
                    },
                    {
                      dataField: "role",
                      caption: 'Role',
                      alignment: "center",
                      // width:200,	
                      cellTemplate: function (container, options) {
                        if(options.value=='SUPERADMIN'){
                          $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-warning text-white me-0">'+options.value+'</a>')
                                                  .appendTo(container); 
                        }else if(options.value=='PANITIA'){
                          $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-success text-white me-0">'+options.value+'</a>')
                                                  .appendTo(container); 
                        }else if(options.value=='DOSEN'){
                          $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-danger text-white me-0">'+options.value+'</a>')
                                                  .appendTo(container); 
                        }else{
                          $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-primary text-white me-0">'+options.value+'</a>')
                                                  .appendTo(container); 
                        }
                      }
                    },
              ],
              @if(Auth::user()->role == '1' || Auth::user()->role == '2')
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
                      elementAttr: {"id": "btnTambahUser"}, 
                        onClick: function(e) {
                          $("#headerEditForm").text("TAMBAH USER");
                          Edit(null,"Tambah Data User");
                        }
                    }
                  })
                },
              @endif
              onCellClick: function(e) {
                if(e.columnIndex===7){
                  actionSheet.option('target', e.cellElement);
                  actionSheet.option('visible', true);
                  if ({!!Auth::user()->role!!} == 3 || {!!Auth::user()->role!!} == 4) {
                    const actionSheetItems = [
                      { text: 'Edit',icon: 'edit',id:e.data.id},
                      { text: 'Reset Password',icon: 'key',id:e.data.id},
                    ];
                    actionSheet.option('items',actionSheetItems);
                  }else{
                    const actionSheetItems = [
                      { text: 'Edit',icon: 'edit',id:e.data.id},
                      { text: 'Reset Password',icon: 'key',id:e.data.id},
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
            url: "{{route('userEdit')}}",
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
            items: [
              {
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
                dataField: "name",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Nama"
                },
              },
              {
                dataField: "username",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Username"
                },
              },
              {
                dataField: "phone",
                editorType: "dxNumberBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "No. HP"
                },
              },
              {
                dataField: "generation",
                editorType: "dxNumberBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Angkatan"
                },
              },
              {
                dataField: "envoy",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Utusan"
                },
              },
              @if(Auth::user()->role == '1' || Auth::user()->role == '2')
                {
                  dataField: "role",
                  editorType: "dxSelectBox",
                  editorOptions: {
                    readOnly: false,
                    width: '100%',
                    searchEnabled: true,
                    dataSource: role,
                    displayExpr: "Name",
                    valueExpr: "ID",
                  },
                  label: {
                    text: "Role"
                  },
                },
              @endif
              {
                dataField: "address",
                editorType: "dxTextArea",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                },
                label: {
                  text: "Alamat"
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
            url: '{{ route("userSave") }}',
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

      function ResetPassword(id,title){
        const data = {"id":id};
        $("#headerEditForm").text(title);
        $("#formEdit").dxForm({
            readOnly: false,
            formData:data,
            showColonAfterLabel: false,
            labelLocation: "top",
            showValidationSummary: true,
            items: [
              {
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
                dataField: "password",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                  mode: 'password',  
                },
                label: {
                  text: "Password Baru"
                },
              },
              {
                dataField: "passwordConfirm",
                editorType: "dxTextBox",
                editorOptions: {
                  readOnly: false,
                  width: '100%',
                  mode: 'password',  
                },
                label: {
                  text: "Konfirmasi Password Baru"
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
                    useSubmitBehavior: true,
                    elementAttr: {
                        style: "float:right;"
                    }
                  },
              },
            ]
          }).dxForm("instance");
      };

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
                    url: '{{route('userDelete')}}',
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