
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
        @include('/admin/partial/footer')
    </div>
  </main>

    <div id="modalMt1" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="formMt1"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalMt2" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="formMt2"></div>
            </div>
        </div>
    </div>

    <div id="modalMt3" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="formMt3"></div>
            </div>
        </div>
    </div>

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
              onToolbarPreparing: function(e){
                e.toolbarOptions.items.unshift(
                {
                  location: "before",
                  widget: "dxButton",
                  locateInMenu:"auto",
                  options: {
                    icon: "fa fa-plus",
                    type: "success",
                    text: "MT 1",
                    elementAttr: {"id": "btnMt1"}, 
                    onClick: function(e) {
                        $('#modalMt1').modal('show');
                        FormMt1(null);
                    }
                  }
                },
                {
                  location: "before",
                  widget: "dxButton",
                  locateInMenu:"auto",
                  options: {
                    icon: "fa fa-plus",
                    type: "success",
                    text: "MT 2",
                    elementAttr: {"id": "btnMt2"}, 
                  }
                },
                {
                  location: "before",
                  widget: "dxButton",
                  locateInMenu:"auto",
                  options: {
                    icon: "fa fa-plus",
                    type: "success",
                    text: "MT 3",
                    elementAttr: {"id": "btnMt3"}, 
                  }
                },)
              },
              onCellClick: function(e) {
                if(e.columnIndex===6){
                actionSheet.option('target', e.cellElement);
                actionSheet.option('visible', true);
                const actionSheetItems = [
                    { text: 'Edit',icon: 'edit',id:e.data.id},
                    { text: 'Delete',icon: 'trash',type: 'danger',id:e.data.id},
                ];
                actionSheet.option('items',actionSheetItems);

               }
          },
          }).dxDataGrid("instance");
      }

      function FormMt1(data) {
          $("#formMt1").dxForm({
            readOnly: false,
            formData: data,
            showColonAfterLabel: false,
            labelLocation: "top",
            showValidationSummary: true,
            colCount: 2,
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
    });
  </script>
</body>

</html>