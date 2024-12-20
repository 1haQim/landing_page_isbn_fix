<div class="row">
    <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12">
        <div class="custom-block bg-white shadow-lg">
            <div class="d-flex">
                <div>
                    <h5 class="mb-4">Dokumen atau Surat</h5>
                    <p class="mb-5">Unduh dokumen-surat secara online</p>
                </div>
                <span class="badge rounded-pill ms-auto" id="totalRowsSurat" style="background-color: #13547a;"></span>
            </div>

            <table id="doc_surat" class="display responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th><center>Judul </center></th>
                        <th><center>Deskripsi</center></th>
                        <th><center>Download</center></th>
                    </tr>
                </thead>
            </table>
                <!-- <img src="images/topics/undraw_Compose_music_re_wpiw.png" class="custom-block-image img-fluid" alt=""> -->
        </div>
    </div>
</div>

@push('scripts')
<!-- js data table BIP-->
    <script>
        $(document).ready(function() {
            var downloadBaseUrl = "{{ config('app.doc_path') }}";
            $('#doc_surat').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('surat.serverside_surat') }}", 
                    type: 'GET', 
                    data: function(d) {
                        // Calculate the current page and send it to the server
                        d.page = (d.start / d.length) + 1; // Current page (1-based)
                        d.pageSize = d.length; // Number of records per page
                    }
                },
                pageLength: 10, // Default number of records per page
                lengthMenu: [5, 10, 25, 50],
                columns: [
                    { data: 'TITLE', name: 'TITLE' },
                    { data: 'DESKRIPSI', name: 'DESKRIPSI' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            var docSts = row.LINK_DATA_DOC ?? '-';
                            var fullUrl = downloadBaseUrl + '/dokumen_surat/' + docSts;
                            return '<button class="form-control">' +
                                '<a class="nav-link click-scroll" href="' + fullUrl + '" target="_blank">Download</a>' +
                                '</button>';
                        },
                        orderable: false
                    }
                ],
                drawCallback: function(settings) {
                    document.getElementById('totalRowsSurat').innerHTML = settings._iRecordsTotal;
                }
            });
        });
    </script>
    <!-- end -->
@endpush