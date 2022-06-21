
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
                  <h6>Menu Tugas Micro Learning</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <div class="container">
                  <div id="gridTugas"></div>   
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
    @include('/admin/partial/mainly')
  <!--   Core JS Files   -->
  @include('/admin/partial/script')
  <script type="application/javascript">
    $(document).ready(function() {
      function loadData() {
        $.ajax({
          url: "{{route('tugasMlData')}}",
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
            if(value.itemData.text=='Isi Jawaban'){
                var url = '{{route("tugasMlDetail",["isiJawaban",":id"])}}';
                url = url.replace(':id',value.itemData.id);
                window.location.href=url;
            }
            if(value.itemData.text=='Input Nilai'){
                var url = '{{route("tugasMlDetail",["isiNilai",":id"])}}';
                url = url.replace(':id',value.itemData.id);
                window.location.href=url;
            }
          },
        }).dxActionSheet('instance');

        var gridTugas = $("#gridTugas").dxDataGrid({
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
                    enabled:true,
                    fileName:"Data Tugas"
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
                        caption:"Nama Mahasiswa/i",
                        alignment: "left"
                    },
                    {
                        dataField: "name_jadwal",
                        caption:"Nama Matkul",
                        alignment: "left"
                    },
                    {
                        dataField: "name_mentor",
                        caption:"Nama Mentor",
                        alignment: "left"
                    },
                    {
                        dataField: "deadline_date",
                        editorType: "dxDateBox",
                        caption:"Deadline Tugas",
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
                    @if(Auth::user()->role != 4)
                    {
                        dataField: "value",
                        caption:"Nilai Matkul",
                        alignment: "left"
                    },
                    @endif
                    {
                        dataField: "uploaded",
                        caption:"Status",
                        alignment: "left",
                        cellTemplate: function (container, options) {
                          if(options.value=='0'){
                            $('<div/>').html('<a style="padding:5px;"class="btn btn-danger text-white me-0">BELUM DIJAWAB</a>')
                                                    .appendTo(container); 
                          }else if(options.value=='1'){
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-success text-white me-0">SUDAH DIJAWAB</a>')
                                                    .appendTo(container); 
                          }else{
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-warning text-white me-0">TELAT DIJAWAB</a>')
                                                    .appendTo(container); 
                          }
                        }
                    },
                    {
                        dataField: "is_value",
                        caption:"Status",
                        alignment: "left",
                        cellTemplate: function (container, options) {
                          if(options.value=='0'){
                            $('<div/>').html('<a style="padding:5px;"class="btn btn-danger text-white me-0">BELUM DINILAI</a>')
                                                    .appendTo(container); 
                          }else{
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-success text-white me-0">SUDAH DINILAI</a>')
                                                    .appendTo(container); 
                          }
                        }
                    },
              ],
              onCellClick: function(e) {
                console.log(e.columnIndex)
                @if(Auth::user()->role != 4)
                  var valueIndex = 7
                @else
                  var valueIndex = 6
                @endif
                if(e.columnIndex===valueIndex){
                  actionSheet.option('target', e.cellElement);
                  actionSheet.option('visible', true);
                  if ({!!Auth::user()->role!!} == 1 || {!!Auth::user()->role!!} == 2) {
                    const actionSheetItems = [
                        { text: 'Isi Jawaban',icon: 'upload',id:e.data.id},
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                    ];
                    actionSheet.option('items',actionSheetItems);
                  }else if({!!Auth::user()->role!!} == 3){
                    const actionSheetItems = [
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                      ];
                    actionSheet.option('items',actionSheetItems);
                  }else{
                    const actionSheetItems = [
                        { text: 'Isi Jawaban',icon: 'upload',id:e.data.id},
                    ];
                    actionSheet.option('items',actionSheetItems);
                  }
               }
          },
          }).dxDataGrid("instance");
      }
    });
  </script>