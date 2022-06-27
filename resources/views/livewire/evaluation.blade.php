<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">Evaluation Management&nbsp;&nbsp;<a href="javascript:void(0)"
                    class="btn  rounded-pill btn-icon btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#testmodal">
                    <span class=""><i class="fa-solid fa-plus"></i></span>
                </a></h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class=" mb-5">
                    <div class="col-6">
                        {{-- <label for="testname" class="form-label">Unique ID for Evaluation</label> --}}
                        <input type="text" wire:model="unique" placeholder="ENTER THE UNIQUE FILE NAME FOR UPLOAD EVALUATED FILE" class="form-control ">
                    </div>
                    <div class="col-6 my-3">
                        <button wire:click="validateCode()" class="btn btn-primary  text-dark btn-sm">Validate File</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            {{-- <th>Name</th> --}}
                            <th>Exam-Name</th>
                            <th>Test Name</th>
                            {{-- <th>Plan Type</th> --}}
                            <th>Submitted Date</th>
                            <th>Submitted File</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($datas) && !empty($datas))
                            @foreach ($datas as $data)
                                <tr>
                                    {{-- <td>{{ @$data->user->name }}</td> --}}
                                    <td>{{ @$data->test->course->exam->name }}</td>
                                    <td>{{ @$data->test->name }}</td>
                                    {{-- <td>{{ @$data->test->course->name }}</td> --}}
                                    <td>{{ @$data->created_at }}</td>
                                    <td> <button type="button" wire:click="downloadFile({{ $data->id }})"
                                            class="btn   btn-warning">Download File</button></td>
                                    {{-- <td>
                                        <select name="" id="" class="form-control" onchange=evaluatorchange(event) data-test="{{$data->id}}" >
                                            @if (isset($evaluators) && !empty($evaluators))
                                                <option value="">Select Evaluator</option>
                                                @foreach ($evaluators as $evaluator)
                                                    <option value="{{ $evaluator->id }}">{{ $evaluator->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td> --}}
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $data->status == 1 ? 'primary' : ($data->status == 0 ? 'info' : 'secondary') }}  me-1">{{ $data->status == 1 ? 'Evaluated' : ($data->status == 0 ? 'Submitted' : 'Under Evaluation') }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    Showing {{ $datas->firstItem() }} to {{ $datas->lastItem() }} of {{ $datas->total() }} entries
                    {{ $datas->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="testmodal" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-modal="true" role="dialog">
        <div class="modal-dialog ">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testmodalTitle">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="col col-12 mb-3">
                                <label for="testname" class="form-label">Upload File</label>
                                <input wire:model="eFile" type="file" class="form-control">
                                <div wire:loading wire:target="eFile">File Uploading...</div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button wire:loading.attr="disabled" type="button" class="btn btn-primary" wire:click="uploadFile()">Upload</button>
                </div>
            </form>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        function openAssignModal(params) {
            Livewire.emit('test', params);

        }

        function test(id) {

            Livewire.emit('test', id);
            $('#testmodal').modal('show');
        }

        function testview(id) {

            Livewire.emit('testview', id);
            $('#testviewmodal').modal('show');
        }

        function teststatus(e) {
            Livewire.emit('teststatus', e.target.value);
        }

        function testtype(e) {
            Livewire.emit('testtype', e.target.value);
        }

        function evaluatorchange(e) {
            Livewire.emit('evaluator', e.target.value);

        }

        function statuschange(e) {


            Livewire.emit('status', e.target.value);

        }

        function exam(e) {
            Livewire.emit('exam', e.target.value);
        }


        Livewire.on('added', function() {
            $('#coursemodal').modal('hide');
            toastr.success('Course Added');
            location.reload();
        })
        Livewire.on('evaluator-error', function() {
            toastr.error('Select Evaluator');
        })
        Livewire.on('status-error', function() {
            toastr.error('Select Status');
        })
        Livewire.on('update-status', function() {

            $('#testmodal').modal('show');
        })
        Livewire.on('updated', function() {

            $('#testmodal').modal('hide');
            toastr.success('Status Updated Successfully')
        })
        Livewire.on('null', function() {
            toastr.error('Require Unique ID for evaluation')
        })
        Livewire.on('invalid', function() {
            toastr.error('Invalid Unique ID.')
        })
        Livewire.on('invalid-file', function() {
            toastr.error('Invalid File Name.')
        })
        Livewire.on('no-file', function() {
            toastr.error('Please Upload File')
        })
        Livewire.on('success', function() {
            toastr.success('File Uploaded');
            $('#testmodal').modal('hide');
        })
        Livewire.on('already-updated', function() {
            toastr.error('File Already Updated.')
        })
        Livewire.on('ok', function() {
            toastr.success('Unique ID is validated and can upload file now.')
            $('#testmodal').modal('show');
        })
        Livewire.on('test-added', function() {
            $('#testmodal').modal('hide');
            toastr.success('Test Added');
            location.reload();
        })
    </script>
@endpush
