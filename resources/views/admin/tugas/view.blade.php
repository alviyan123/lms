
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
                  <h6>Menu Tugas</h6>
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
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
              <div class="card-header pb-0">
                <h6 id="headerEditForm"></h6>
              </div>
              <div class="card-body p-3">
                <form id="formEdit"></form>
                <form id="formNilai"></form>
                <form id="formPostTest"></form>
              </div>
            </div>
        </div>
      </div>
        @include('/admin/partial/footer')
    </div>
  </main>
  
  <div id="modalJawaban" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Jawaban</h5>
        </div>
        <div class="modal-body">
          <h5>Setelah Akfititas pembelajaran tadi, apa yang ANDA FIKIRKAN dan bagaimana PERASAAN ANDA ?</h5>
          <p id='jwb1'></p>
          <h5>Dari Aktivitas pembelajaran tadi, PELAJARAN APA YANG ANDA DAPATKAN ?</h5>
          <p id='jwb2'></p>
          <h5>Dari pengetahuan yang anda dapatkan, APA YANG AKAN ANDA LAKUKAN?</h5>
          <p id='jwb3'></p>
        </div>

      </div>
    </div>
  </div>
    @include('/admin/partial/mainly')
  <!--   Core JS Files   -->
  @include('/admin/partial/script')
  <script type="application/javascript">
    $(document).ready(function() {
      $("#btnTugas").addClass('active bg-gradient-primary');
      function loadData() {
        $.ajax({
          url: "{{route('tugasData')}}",
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
            if(value.itemData.text=='Upload Tugas'){
    					Upload(value.itemData.id,"UPLOAD TUGAS");
            }
            if (value.itemData.text=='Input Nilai') {
              InputNilai(value.itemData.id,value.itemData.name,value.itemData.name_siswa,"Input Nilai");
            }
            if(value.itemData.text=='Isi Post Test'){
    					InputPostTest(value.itemData.id,"Input Post Test");
            }
            if(value.itemData.text=='Lihat Jawaban'){
              
              $.ajax({
                url: "{{route('jawabEdit')}}",
                dataType: "json",
                type: 'GET',
                data:{id:value.itemData.id},
                success: function(result) {
                  $("#jwb1").empty();
                  $("#jwb2").empty();
                  $("#jwb3").empty();


                  $("#jwb1").text(result.jawaban_1);
                  $("#jwb2").text(result.jawaban_2);
                  $("#jwb3").text(result.jawaban_3);

                  $('#modalJawaban').modal('show');
                },
                error: function(e) {
                },
              });
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
                    enabled:false,
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
                        dataField: "name_siswa",
                        caption:"Nama Mahasiswa/i",
                        alignment: "left"
                    },
                    {
                        dataField: "name",
                        caption:"Nama Matkul",
                        alignment: "left"
                    },
                    // {
                    //     dataField: "teach_date_from",
                    //     caption:"Jadwal",
                    //     editorType: "dxDateBox",
                    //     editorOptions: {
                    //         type: "date",
                    //         displayFormat:'dd-MM-yyyy',
                    //         readOnly: false,
                    //         width: '100%',
                    //     },
                    //     label: {
                    //     text: "Jadwal Kuliah"
                    //     },
                    // },
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
                    {
                        dataField: "weekend_to",
                        caption:"Minggu Ke",
                        alignment: "left"
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
                          if(options.value=='BELUM UPLOAD TUGAS'){
                            $('<div/>').html('<a style="padding:5px;"class="btn btn-danger text-white me-0">'+options.value+'</a>')
                                                    .appendTo(container); 
                          }else if(options.value=='TELAT UPLOAD DAN SEDANG DIVALIDASI'){
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-warning text-white me-0">'+options.value+'</a>')
                                                    .appendTo(container); 
                          }else if(options.value=='SEDANG DIVALIDASI'){
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-success text-white me-0">'+options.value+'</a>')
                                                    .appendTo(container); 
                          }else if(options.value=='SUDAH UPLOAD TUGAS'){
                            $('<div/>').html('<a href="#" style="padding:5px;"class="btn btn-primary text-white me-0">'+options.value+'</a>')
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
                    {
                        dataField: "patch_upload",
                        caption:"patch",
                        alignment: "left",
                        cellTemplate: function (container, options) {
                          if (options.value != null) {
                            $('<div/>').html('<a href={{route('tugasDownload')}}?id='+options.data.id+' style="padding:5px;"class="btn btn-outline-info">Download Tugas</a>')
                                                    .appendTo(container); 
                          }

                        }
                    },
              ],
              // onToolbarPreparing: function(e){
              //   e.toolbarOptions.items.unshift(
              //   {
              //     location: "before",
              //     widget: "dxButton",
              //     locateInMenu:"auto",
              //     options: {
              //       icon: "fa fa-plus",
              //       type: "success",
              //       text: "Upload Tugas",
              //       elementAttr: {"id": "btnUploadTugas"}, 
              //         onClick: function(e) {
              //           UploadPerWeek("Upload Tugas");
              //         }
              //     }
              //   })
              // },
              onCellClick: function(e) {
                @if(Auth::user()->role != 4)
                  var valueIndex = 8
                @else
                  var valueIndex = 7
                @endif
                if(e.columnIndex===valueIndex){
                  console.log(e.data);
                  actionSheet.option('target', e.cellElement);
                  actionSheet.option('visible', true);
                  if ({!!Auth::user()->role!!} == 1 || {!!Auth::user()->role!!} == 2) {
                    if (e.data.is_refleksi == 1) {
                      const actionSheetItems = [
                        { text: 'Upload Tugas',icon: 'upload',id:e.data.id},
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }else{
                      const actionSheetItems = [
                        { text: 'Isi Post Test',icon: 'upload',id:e.data.id},
                        { text: 'Lihat Jawaban',icon: 'activefolder',id:e.data.id},
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }
                  }else if({!!Auth::user()->role!!} == 3){
                    if (e.data.is_refleksi == 1) {
                      const actionSheetItems = [
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }else{
                      const actionSheetItems = [
                        { text: 'Lihat Jawaban',icon: 'activefolder',id:e.data.id},
                        { text: 'Input Nilai',icon: 'check',id:e.data.id,name_siswa:e.data.name_siswa,name:e.data.name},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }
                  }else{
                    if (e.data.is_refleksi == 1) {
                      const actionSheetItems = [
                        { text: 'Upload Tugas',icon: 'upload',id:e.data.id},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }else{
                      const actionSheetItems = [
                        { text: 'Isi Post Test',icon: 'upload',id:e.data.id},
                      ];
                      actionSheet.option('items',actionSheetItems);
                    }
                  }
               }
          },
          }).dxDataGrid("instance");

          function Upload(id,title){
            const data = {"id":id};
            $("#headerEditForm").text(title);
            $("#formNilai").hide();
            $("#formPostTest").hide();
            $("#formEdit").show();
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
                      dataField: "patch_upload",
                      editorType: "dxFileUploader",
                      width: '100%',
                      label: {
                          text: "Upload Tugas",
                          visible: true
                      },
                      editorOptions: {
                        labelText: "",
                        width: '100%',
                        allowedFileExtensions: [".docx", ".doc",".pdf"],
                        uploadMode: "useForm",
                        selectButtonText: "Upload File .pdf / .doc /.docx",
                        elementAttr: {
                            class: "file-upload",
                        },
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
          
          // var sts_weekend = [
          //   {"ID":"1","Name":"Pertama" },
          //   {"ID":"2","Name":"Kedua" },
          //   {"ID":"3","Name":"Ketiga" },
          //   {"ID":"4","Name":"Keempat" },
          //   {"ID":"5","Name":"Kelima" },
          //   {"ID":"6","Name":"Keenam" },
          //   {"ID":"7","Name":"Ketujuh" },
          //   {"ID":"8","Name":"Kedelapan" },
          //   {"ID":"9","Name":"Kesembilan" },
          //   {"ID":"10","Name":"Kesepuluh" },
          //   {"ID":"11","Name":"Kesebelas" },
          //   {"ID":"12","Name":"Kedua belas" },
          //   {"ID":"13","Name":"ketiga belas" },
          //   {"ID":"14","Name":"Keempat belas" },
          //   {"ID":"15","Name":"Kelima belas" },
          //   {"ID":"16","Name":"Keenam belas" },
          // ];
          // function UploadPerWeek(title){
          //   $("#headerEditForm").text(title);
          //   $("#formNilai").hide();
          //   $("#formEdit").show();
          //   var user_id = {{Auth::user()->id}};
          //   $("#formEdit").dxForm({
          //       readOnly: false,
          //       formData:data,
          //       showColonAfterLabel: false,
          //       labelLocation: "top",
          //       showValidationSummary: true,
          //       items: [
          //         {
          //           dataField: "weekend_to",
          //           editorType: "dxSelectBox",
          //           editorOptions: {
          //               readOnly: false,
          //               width: '100%',
          //               searchEnabled: true,
          //               dataSource: sts_weekend,
          //               displayExpr: "Name",
          //               valueExpr: "ID",
          //           },
          //           label: {
          //             text: "Tugas Minggu Ke "
          //           },
          //         },
          //         @if(Auth::user()->role == 4)
          //         {
          //           colSpan:2,
          //           dataField: "user_id",
          //           editorType: "dxSelectBox",
          //           editorOptions: {
          //               value:user_id,
          //               readOnly: true,
          //               width: '100%',
          //               searchEnabled: true,
          //               dataSource: Pku.ParameterLookup("User", "User"),
          //               displayExpr: "Name",
          //               valueExpr: "ID",
          //           },
          //           label: {
          //               text: "User"
          //           },
          //         },
          //         @else
          //         {
          //           colSpan:2,
          //           dataField: "user_id",
          //           editorType: "dxSelectBox",
          //           editorOptions: {
          //               readOnly: false,
          //               width: '100%',
          //               searchEnabled: true,
          //               dataSource: Pku.ParameterLookup("User", "User"),
          //               displayExpr: "Name",
          //               valueExpr: "ID",
          //           },
          //           label: {
          //               text: "User"
          //           },
          //         },
          //         @endif
          //         {
          //             dataField: "patch_upload",
          //             editorType: "dxFileUploader",
          //             width: '100%',
          //             label: {
          //                 text: "Upload Tugas",
          //                 visible: true
          //             },
          //             editorOptions: {
          //               labelText: "",
          //               width: '100%',
          //               allowedFileExtensions: [".docx", ".doc",".pdf"],
          //               uploadMode: "useForm",
          //               selectButtonText: "Upload File .pdf / .doc /.docx",
          //               elementAttr: {
          //                   class: "file-upload",
          //               },
          //             },
          //         },
          //         {
          //             editorType: "dxButton",
          //             label: {
          //               text: "SIMPAN",
          //               visible: false
          //             },
          //             editorOptions: {
          //               text: "SIMPAN",
          //               type: "success",
          //               icon: 'save',
          //               useSubmitBehavior: true,
          //               elementAttr: {
          //                   style: "float:right;"
          //               }
          //             },
          //         },
          //       ]
          //     }).dxForm("instance");
          // };

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
                url: '{{ route("tugasUpload") }}',
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

          function InputNilai(id,name,name_siswa,title){
            const data = {
                "id":id,
                "name":name,
                "name_siswa":name_siswa
              };
            $("#formEdit").hide();
            $("#formPostTest").hide();
            $("#formNilai").show();
            $("#headerEditForm").text(title);
            $("#formNilai").dxForm({
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
                    dataField: "name",
                    editorType: "dxTextBox",
                    editorOptions: {
                      readOnly: true,
                      width: '100%',
                    },
                    label: {
                      text: "Nama Mata Kuliah"
                    },
                  },
                  {
                    dataField: "name_siswa",
                    editorType: "dxTextBox",
                    editorOptions: {
                      readOnly: true,
                      width: '100%',
                    },
                    label: {
                      text: "Nama Siswa"
                    },
                  },
                  {
                    dataField: "value",
                    editorType: "dxTextBox",
                    editorOptions: {
                      readOnly: false,
                      width: '100%', 
                    },
                    label: {
                      text: "Nilai"
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
          }

          $("#formNilai").submit(function(e){
              e.preventDefault();

              var form = $('#formNilai')[0];
              var formData = new FormData(form);
              loadPanel.show();

              $.ajax({
                type: 'POST',
                headers: {  
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("tugasNilai") }}',
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

          function InputPostTest(id,title){

            $.ajax({
                url: "{{route('jawabEdit')}}",
                dataType: "json",
                type: 'GET',
                data:{id:id},
                success: function(result) {
                  LoadForm(result);
                },
                error: function(e) {
                },
            });
            function LoadForm(data) {
              $("#formEdit").hide();
            $("#formNilai").hide();
            $("#formPostTest").show();
            $("#headerEditForm").text(title);
            $("#formPostTest").dxForm({
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
                    dataField: "jawaban_1",
                    editorType: "dxTextArea",
                    editorOptions: {
                      height:150,
                      readOnly: false,
                      width: '100%',
                    },
                    label: {
                      text: "Setelah Akfititas pembelajaran tadi, apa yang ANDA FIKIRKAN dan bagaimana PERASAAN ANDA ?"
                    },
                  },
                  {
                    dataField: "jawaban_2",
                    editorType: "dxTextArea",
                    editorOptions: {
                      height:150,
                      readOnly: false,
                      width: '100%',
                    },
                    label: {
                      text: "Dari Aktivitas pembelajaran tadi, PELAJARAN APA YANG ANDA DAPATKAN ?"
                    },
                  },
                  {
                    dataField: "jawaban_3",
                    editorType: "dxTextArea",
                    editorOptions: {
                      height:150,
                      readOnly: false,
                      width: '100%', 
                    },
                    label: {
                      text: "Dari pengetahuan yang anda dapatkan, APA YANG AKAN ANDA LAKUKAN?"
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
            }
          }

          $("#formPostTest").submit(function(e){
              e.preventDefault();

              var form = $('#formPostTest')[0];
              var formData = new FormData(form);
              loadPanel.show();

              $.ajax({
                type: 'POST',
                headers: {  
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("tugasInput") }}',
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
      }
    });
  </script>
</body>

</html>