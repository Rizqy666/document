<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Dashboard')); ?></div>

                    <div class="card-body">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addDocumentModal"><i class="fa fa-plus"></i> Tambah Document</button>
                        </div>
                        <div class="table-responsive">
                            <table id="documentsTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Project Name</th>
                                        <th>Discipline</th>
                                        <th>Document Category</th>
                                        <th>Document Drawing</th>
                                        <th>Document Title</th>
                                        <th>Revision</th>
                                        <th>Status</th>
                                        <th>Revision Date</th>
                                        <th>PDF</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($document->client); ?></td>
                                            <td><?php echo e($document->project_name); ?></td>
                                            <td><?php echo e($document->discipline); ?></td>
                                            <td><?php echo e($document->document_category); ?></td>
                                            <td><?php echo e($document->document_drawing); ?></td>
                                            <td><?php echo e($document->document_title); ?></td>
                                            <td><?php echo e($document->revision); ?></td>
                                            <td><?php echo e($document->status); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($document->revision_date)->format('d F Y')); ?></td>
                                            <td><a href="<?php echo e(asset('storage/' . $document->pdf)); ?>" target="_blank">View
                                                    PDF</a>
                                            </td>
                                            <td>
                                                <div class="btn-group gap-2">
                                                    <a href="#" class="btn btn-sm btn-primary rounded"
                                                        data-bs-toggle="modal" data-bs-target="#editDocumentModal">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="<?php echo e(route('documents.destroy', $document->id)); ?>"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-danger rounded"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('modals.add_document', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('modals.edit_document', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://kit.fontawesome.com/92449afa91.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#documentsTable').DataTable({
                "responsive": true

            });
        });

        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo e(session('success')); ?>'
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo e(session('error')); ?>'
            });
        <?php endif; ?>

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\document\resources\views/home.blade.php ENDPATH**/ ?>