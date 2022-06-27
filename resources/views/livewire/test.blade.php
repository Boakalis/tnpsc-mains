<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">Test Management&nbsp;&nbsp;<a href="javascript:void(0)"
                    class="btn  rounded-pill btn-icon btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#testmodal">
                    <span class=""><i class="fa-solid fa-plus"></i></span>
                </a></h4>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Exam-Name</th>
                            <th>Test Name</th>
                            <th>Plan Type</th>
                            <th>Submitted Date</th>
                            <th>Evaluator</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($datas) && !empty($datas))
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ @$data->user->name }}</td>
                                    <td>{{ @$data->test->course->exam->name }}</td>
                                    <td>{{ @$data->test->name }}</td>
                                    <td>{{ @$data->test->course->name }}</td>
                                    <td>{{ @$data->created_at }}</td>
                                    <td>{{ @$data->evaluator != null ? $data->evaluator->name : 'NA' }}</td>
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
                                    <td>
                                        {{-- <select name="" id="" class="form-control" onchange="statuschange(event)" data-testId="{{$data->id}}" >
                                            <option value="">Select Status</option>
                                            <option value="2">Assign</option>
                                            <option value="1">Evaluated</option>
                                        </select> --}}

                                        <button
                                            class="btn btn-{{ @$data->status == 1 ? 'secondary' : (@$data->status == 2 ? 'info' : 'success') }} "
                                            {{ @$data->status == 1 ? 'disabled' : '' }}
                                            onclick="openAssignModal({{ @$data->id }})">Assign/Update</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    Showing {{ $datas->firstItem() }} to {{ $datas->lastItem() }} of {{ $datas->total() }}
                    entries
                    {{ $datas->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="testmodal" wire:ignore.self data-bs-backdrop="static" tabindex="-1" aria-modal="true"
        role="dialog">
        <div class="modal-dialog ">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testmodalTitle">Update/Assign Test Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="col col-12 mb-3">
                                <label for="testname" class="form-label">Select Evaluator</label>
                                <select name="" id="" class="form-control" wire:model="evaluator_id"
                                    onchange=evaluatorchange(event) " >
                                      @if (isset($evaluators) && !empty($evaluators))
                                    <option value="">Select Evaluator</option>
                                    @foreach ($evaluators as $evaluator)
                                        <option value="{{ $evaluator->id }}">{{ $evaluator->name }}
                                        </option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('testname')
                                    <span class="text-danger">{{ $errors->first('testname') }}</span>
                                @enderror
                            </div>
                            <div class="col col-12 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="" id="" class="form-control" wire:model="status"
                                    onchange="statuschange(event)">
                                    <option value="">Select Status</option>
                                    <option value="2">Assign</option>
                                    {{-- <option value="1">Evaluated</option> --}}
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="save()">Save</button>
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
        Livewire.on('test-added', function() {
            $('#testmodal').modal('hide');
            toastr.success('Test Added');
            location.reload();
        })
    </script>
@endpush
