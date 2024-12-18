<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('documents.store')); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client" class="form-label">Client</label>
                                <input type="text" class="form-control" id="client" name="client" required>
                            </div>
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="discipline" class="form-label">Discipline</label>
                                <input type="text" class="form-control" id="discipline" name="discipline" required>
                            </div>
                            <div class="mb-3">
                                <label for="document_category" class="form-label">Document Category</label>
                                <input type="text" class="form-control" id="document_category"
                                    name="document_category" required>
                            </div>
                            <div class="mb-3">
                                <label for="document_drawing" class="form-label">Document Drawing</label>
                                <input type="text" class="form-control" id="document_drawing" name="document_drawing"
                                    required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pdf" class="form-label">PDF</label>
                                <input type="file" class="form-control" id="pdf" name="pdf" required>

                                <!-- Progress Bar -->
                                <div class="progress" style="height: 20px; display: none;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 0%;">0%</div>
                                </div>

                                <!-- Upload Status -->
                                <div id="upload-status" class="mt-2"
                                    style="display: none; color: green; font-weight: bold;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="document_title" class="form-label">Document Title</label>
                                <input type="text" class="form-control" id="document_title" name="document_title"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="revision" class="form-label">Revision</label>
                                <input type="text" class="form-control" id="revision" name="revision" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" required>
                            </div>
                            <div class="mb-3">
                                <label for="revision_date" class="form-label">Revision Date</label>
                                <input type="date" class="form-control" id="revision_date" name="revision_date"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan
                        Document</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const inputElement = document.getElementById('pdf');
    const progressBar = document.querySelector('.progress');
    const progressBarInner = document.querySelector('.progress-bar');
    const uploadStatus = document.getElementById('upload-status');

    inputElement.addEventListener('change', (e) => {
        const file = e.target.files[0];

        if (file) {
            const formData = new FormData();
            formData.append('pdf', file);

            // Tampilkan progress bar dan reset ke awal
            progressBar.style.display = 'block';
            progressBarInner.style.width = '0%';
            progressBarInner.classList.remove('bg-success'); // Reset warna
            progressBarInner.classList.add('bg-primary');
            progressBarInner.textContent = '0%';
            uploadStatus.style.display = 'none';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo e(route('documents.upload')); ?>'); // Pastikan route sudah benar

            // Update progress bar
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBarInner.style.width = `${percent}%`;
                    progressBarInner.textContent = `${percent}%`;
                }
            });

            // Sembunyikan progress bar jika selesai
            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText); // Parse JSON response

                    if (response.success) {
                        progressBar.style.display = 'none'; // Sembunyikan progress bar
                        progressBarInner.classList.remove('bg-primary');
                        progressBarInner.classList.add('bg-success');
                        progressBarInner.textContent = '100%'; // Update ke 100%
                        uploadStatus.style.display = 'block';
                        uploadStatus.style.color = 'green';
                        uploadStatus.textContent = response.message || 'File uploaded successfully!';
                    } else {
                        progressBar.style.display = 'none';
                        uploadStatus.style.display = 'block';
                        uploadStatus.style.color = 'red';
                        uploadStatus.textContent = response.message || 'File upload failed!';
                    }
                } else {
                    progressBar.style.display = 'none';
                    uploadStatus.style.display = 'block';
                    uploadStatus.style.color = 'red';
                    uploadStatus.textContent = 'File upload failed!';
                }
            });

            xhr.send(formData);
        } else {
            // Sembunyikan progress bar jika tidak ada file
            progressBar.style.display = 'none';
            uploadStatus.style.display = 'none';
        }
    });
</script>
<?php /**PATH C:\laragon\www\document\resources\views/modals/add_document.blade.php ENDPATH**/ ?>