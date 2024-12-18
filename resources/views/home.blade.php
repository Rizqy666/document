@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

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
                                    @foreach ($documents as $document)
                                        <tr>
                                            <td>{{ $document->client }}</td>
                                            <td>{{ $document->project_name }}</td>
                                            <td>{{ $document->discipline }}</td>
                                            <td>{{ $document->document_category }}</td>
                                            <td>{{ $document->document_drawing }}</td>
                                            <td>{{ $document->document_title }}</td>
                                            <td>{{ $document->revision }}</td>
                                            <td>{{ $document->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($document->revision_date)->format('d F Y') }}</td>
                                            <td><a href="{{ asset('storage/' . $document->pdf) }}" target="_blank">View
                                                    PDF</a>
                                            </td>
                                            <td>
                                                <div class="btn-group gap-2">
                                                    <a href="#" class="btn btn-sm btn-primary rounded"
                                                        data-bs-toggle="modal" data-bs-target="#editDocumentModal">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('documents.destroy', $document->id) }}"
                                                        method="POST" style="display:inline;" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.add_document')
    @include('modals.edit_document')
@endsection
@push('javascript')
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

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}'
            });
        @endif

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
@endpush
