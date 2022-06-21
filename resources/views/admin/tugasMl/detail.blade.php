
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
                    <h5>TUGAS</h5><hr>
                    {!!$result->soal!!}<hr>
                    <h5>JAWABAN</h5><hr>
                    @if($action == 'isiJawaban')
                    <form id='formIsiJawaban'>
                        <input type="hidden" name='id' value="{{$result->id}}">
                        <textarea id="inputSoal" name="jawaban">{!!$result->jawaban!!}</textarea>
                        <button type="submit" name="button" class="btn btn-success">SIMPAN</button>
                    </form>
                    @endif

                    @if($action == 'isiNilai')
                    {!!$result->jawaban!!}<hr>
                    <form id='formIsiNilai'>
                        <input type="hidden" name='id' value="{{$result->id}}">
                        <div class="input-group input-group-outline mb-4">
                          <label class="form-label">INPUT NILAI SKALA 1-4</label>
                          <input type="text" name="value" id="value" class="form-control">
                        </div>
                        <button type="submit" name="button" class="btn btn-success">SIMPAN</button>
                    </form>
                    @endif
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

      $('#formIsiJawaban').submit(function (e) { 
        e.preventDefault();
        var form = $('#formIsiJawaban')[0];
        var formData = new FormData(form);
        loadPanel.show();

        $.ajax({
        type: 'POST',
        headers: {  
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{ route("tugasMlJawaban") }}',
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

      $('#formIsiNilai').submit(function (e) { 
        e.preventDefault();
        var form = $('#formIsiNilai')[0];
        var formData = new FormData(form);
        loadPanel.show();

        $.ajax({
        type: 'POST',
        headers: {  
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '{{ route("tugasMlNilai") }}',
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
    });
  </script> 