<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">User Management</h4>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class=" mb-5">
                    <div class="row">
                        <div class="col-4">
                            {{-- <label for="testname" class="form-label">Unique ID for Evaluation</label> --}}
                            <input type="text" wire:model="email" placeholder="Enter Email Address"
                                class="form-control ">
                        </div>
                        <div class="col-4">
                            {{-- <label for="testname" class="form-label">Unique ID for Evaluation</label> --}}
                            <select class="form-control" name="" onchange="examValue(event)" wire:model="examId" id="">
                                <option value="">Select Exam</option>
                                @if (isset($exams) & !empty($exams))
                                    @foreach ($exams as $exam)
                                        <option value="{{@$exam->id}}">{{@$exam->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-4">
                            {{-- <label for="testname" class="form-label">Unique ID for Evaluation</label> --}}
                            <select class="form-control" wire:model="planId" name="" onchange="planValue(event)" id="">
                                <option value="">Select Plan</option>
                                @if (isset($plans) & !empty($plans))
                                @foreach ($plans as $plan)
                                    <option value="{{@$plan->id}}">{{@$plan->name}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-6 my-3">
                        <button wire:click="addOrder()" class="btn btn-primary  text-dark btn-sm">Add Course</button>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($datas) && !empty($datas))
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ @$data->name }}</td>
                                    <td>{{ @$data->email }}</td>
                                    <td>
                                        <button wire:click="view({{ @$data->id }})"
                                            class="btn btn-primary  me-1">View </button>
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
                    {{-- <h5 class="modal-title text-center" id="testmodalTitle">User Data's</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="col col-12 mb-3">
                                <label for="testname" class="form-label">Name</label>
                                <p>{{ @$userData->name }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col col-12 mb-3">
                                <label for="testname" class="form-label">Email</label>
                                <p>{{ @$userData->email }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="col col-12 mb-3">
                                <label for="testname" class="form-label">Phone</label>
                                <p>{{ @$userData->phone }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            @if (@$userData->address_1 != null)
                                <div class="col col-12 mb-3">
                                    <label for="testname" class="form-label">Communication Details:</label>
                                    <p class="py-0 my-0">{{ @$userData->address_1 }},</p>
                                    <p class="py-0 my-0">{{ @$userData->address_2 ? $userData->address_2 : 'NA' }},</p>
                                    <p class="py-0 my-0">
                                        {{ @$userData->city }},{{ @$userData->state }}-{{ @$userData->pincode }}</p>
                                    <p class="py-0 my-0">
                                        LandMark:{{ @$userData->landmark ? $userData->landmark : 'NA' }}</p>
                                </div>
                            @else
                                <p>Address Not yet provided</p>
                            @endif
                        </div>

                    </div>

                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="save()">Save</button>
                </div> --}}
            </form>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        function examValue(event) {
            Livewire.emit('examValue', event.target.value);
        }
        function planValue(event) {
            Livewire.emit('planValue', event.target.value);
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
        Livewire.on('validation', function() {
            toastr.error('Provide Proper Datas');
        })
        Livewire.on('already-purchased', function() {
            toastr.error('Already Purchased');
        })
        Livewire.on('no', function() {
            toastr.error('No user found with provided mail address');
        })
        Livewire.on('created', function() {
            toastr.success('Order Created Successfully');
        })
        Livewire.on('view-data', function() {

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
