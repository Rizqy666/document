<!-- resources/views/modals/edit_document.blade.php -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocumentModalLabel">Edit Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client" class="form-label">Client</label>
                                <input type="text" class="form-control" id="client" name="client"
                                    value="{{ $document->client }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name"
                                    value="{{ $document->project_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="discipline" class="form-label">Discipline</label>
                                <input type="text" class="form-control" id="discipline" name="discipline"
                                    value="{{ $document->discipline }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="document_category" class="form-label">Document Category</label>
                                <input type="text" class="form-control" id="document_category"
                                    name="document_category" value="{{ $document->document_category }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="document_drawing" class="form-label">Document Drawing</label>
                                <input type="text" class="form-control" id="document_drawing" name="document_drawing"
                                    value="{{ $document->document_drawing }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pdf" class="form-label">PDF</label>
                                <input type="file" class="form-control" id="pdf" name="pdf"
                                    onchange="uploadFile()" accept="application/pdf">


                                @if ($document->pdf)
                                    <div class="mt-2" id="pdf-link">
                                        <span class="text-success">
                                            <a href="{{ asset('storage/' . $document->pdf) }}" target="_blank">Lihat
                                                PDF</a>
                                        </span>
                                    </div>
                                @else
                                    <div id="no-pdf-message">
                                        <p>No PDF available</p>
                                    </div>
                                @endif
                                                              <div class="progress" style="height: 20px; display: none;" id="progress-bar">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 0%;">0%</div>
                                </div>
                                <div id="upload-status" class="mt-2"
                                    style="display: none; color: green; font-weight: bold;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="document_title" class="form-label">Document Title</label>
                                <input type="text" class="form-control" id="document_title" name="document_title"
                                    value="{{ $document->document_title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="revision" class="form-label">Revision</label>
                                <input type="text" class="form-control" id="revision" name="revision"
                                    value="{{ $document->revision }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    value="{{ $document->status }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="revision_date" class="form-label">Revision Date</label>
                                <input type="date" class="form-control" id="revision_date" name="revision_date"
                                    value="{{ $document->revision_date }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update
                        Document</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function uploadFile() {
        var fileInput = document.getElementById('pdf');
        var formData = new FormData();
        formData.append('pdf', fileInput.files[0]);

        document.getElementById('progress-bar').style.display = 'block';
        var progressBar = document.querySelector('.progress-bar');
        var uploadStatus = document.getElementById('upload-status');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('documents.update', $document->id) }}',
            true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var percent = (e.loaded / e.total) * 100;
                progressBar.style.width = percent + '%';
                progressBar.innerText = Math.round(percent) + '%';
            }
        };


        xhr.onload = function() {
            if (xhr.status == 200) {
                uploadStatus.innerText = 'Upload selesai!';
                uploadStatus.style.display = 'block';
                document.getElementById('pdf-link').style.display = 'block';
                document.getElementById('no-pdf-message').style.display = 'none';
                document.getElementById('progress-bar').style.display = 'none';
            } else {
                uploadStatus.innerText = 'Upload gagal!';
                uploadStatus.style.display = 'block';
            }
        };

        xhr.send(formData);
    }
</script>
