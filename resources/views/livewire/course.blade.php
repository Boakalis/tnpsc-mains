<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">Plan Management&nbsp;&nbsp;<a href="javascript:void(0)"
                    class="btn  rounded-pill btn-icon btn-outline-primary" onclick="clearTextArea()"
                    wire:click="resetdata()" data-bs-toggle="modal" data-bs-target="#coursemodal">
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
                            <th>Price</th>
                            <th>Plan Type</th>
                            <th>Uploaded Schedule</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (isset($datas) && !empty($datas))
                            @foreach ($datas as $data)
                                <tr>
                                    <td><strong>{{ Str::limit($data->name, 20) }}</strong></td>
                                    <td>{{ $data->exam->name }}</td>
                                    <td>{{ $data->price }}</td>
                                    <td><span
                                            class="badge bg-label-{{ $data->type == 1 ? 'success' : 'primary' }}  me-1">{{ $data->type == 1 ? 'PAID' : 'FREE' }}
                                        </span></td>
                                    <td> <button type="button" wire:click="downloadSchedule({{ $data->id }})"
                                            class="btn  rounded-pill btn-warning">Download Schedule</button></td>

                                    <td><span
                                            class="badge bg-label-{{ $data->status == 1 ? 'primary' : 'danger' }}  me-1">{{ $data->status == 1 ? 'Active' : 'Inactive' }}
                                        </span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="test({{ $data->id }})"
                                                    href="javascript:void(0);"><i class="fas fa-plus me-1"></i> Manage
                                                    Content</a>
                                                {{-- <a class="dropdown-item" wire:click="copyCourse({{ $data->id }})"
                                                    href="javascript:void(0);"><i class="fas fa-copy me-1"></i> Copy
                                                    Course</a> --}}
                                                <a class="dropdown-item" wire:click="editCourse({{ $data->id }})"
                                                    href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                {{-- <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="bx bx-trash me-1"></i> Delete</a> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade " id="coursemodal" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coursemodalTitle">Add/Edit Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-12 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" wire:model="name" id="name" class="form-control"
                                placeholder="Enter Name">
                            @error('name')
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @enderror
                        </div>

                        {{-- <div class="col col-12 mb-3">
                            <label for="name" class="form-label">Description</label>
                            <textarea name="" class="form-select" placeholder="Plan Description and Benefits" wire:model="description" id=""
                                cols="30" rows="10"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @enderror
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col mb-0">
                            <label for="exam" class="form-label">Select Exam</label>
                            <select class="form-select" id="exam" wire:model="examId" onclick="exam(e)">
                                <option value="">Select Exam</option>
                                @if (isset($exams) && !empty($exams))
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('exam_id')
                                <span class="text-danger">{{ $errors->first('examId') }}</span>
                            @enderror
                        </div>
                        <div class="col col-12 my-3">
                            <label for="days" class="form-label">Upload Schedule</label>
                            <input type="file" wire:model="days" id="days" class="form-control">
                            @error('days')
                                <span class="text-danger">{{ $errors->first('days') }}</span>
                            @enderror
                        </div>
                        <div class="col col-12 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" wire:model="price" id="price" class="form-control"
                                placeholder="Enter price">
                            @error('price')
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="type" class="form-label">Copy Content From:</label>
                            <select class="form-select" id="copyContent" wire:model="copyCourseId">
                                <option value="0">None</option>
                                @if (isset($contents) && !empty($contents))
                                    @foreach ($contents as $content)
                                        <option value="{{ $content->id }}">{{ $content->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @enderror
                        </div>
                        <div class="col mb-0">
                            <label for="type" class="form-label">Plan Type</label>
                            <select class="form-select" id="type" wire:model="type" onclick="type(e)">
                                <option value="1">Paid</option>
                                <option value="0">Free</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @enderror
                        </div>
                        <div class="col col-12 mb-3" wire:ignore.self>

                            <label for="description" class="form-label">Benefits</label>
                            <textarea class="form-control required" wire:model="description" name="description" id="description">{{ @$description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @enderror
                        </div>
                        <div class="col mb-0">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" wire:model="status" onclick="status(e)">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade " id="testmodal" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-fullscreen ">
            <form class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title text-center" id="testmodalTitle"> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="container" style="overflow-x: auto;height:100vh;">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>{{ @$testdata->name }}</h3>
                                        @if (isset($tests) && $tests->count() > 0)
                                            @foreach ($tests as $test)
                                                <div class="card p-0">
                                                    <div class="card-body ">
                                                        <div class="row">
                                                            <span class="col-12 ">{{ $test->name }}</span>
                                                            <span class="col-6 ">
                                                                Limit:{{ !empty($test->limit) ? $test->limit : 'NA' }}
                                                            </span>
                                                            <span class=" col-6 ">Type: <span
                                                                    class="badge bg-label-{{ $test->type == 1 ? 'success' : 'primary' }}">{{ $test->type == 1 ? 'Paid' : 'Free' }}</span>
                                                            </span>
                                                            <p class="col-6">Status: <span
                                                                    class="badge bg-label-{{ $test->status == 1 ? 'success' : ($test->status == 2 ? 'info' : 'danger') }}">{{ $test->status == 1 ? 'Active' : ($test->status == 2 ? 'Dummy Test' : 'Inactive') }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer mt-0 pt-0">
                                                        @if (isset($test->file) && !empty($test->file))
                                                            <button type="button"
                                                                wire:click="downloadFile({{ $test->id }})"
                                                                class="btn  rounded-pill btn-warning">PDF</button>
                                                        @endif
                                                        @if (isset($test->videolink) && !empty($test->videolink))
                                                            <a target="blank" href="https://{{ @$test->videolink }}"
                                                                class="btn rounded-pill btn-secondary">Video</a>
                                                        @endif
                                                        <a href="javascript:void(0)"
                                                            wire:click="editTest({{ $test->id }})"
                                                            class="btn rounded-pill btn-primary">Edit</a>
                                                        <button type="button"
                                                            wire:click="deleteTest({{ $test->id }})"
                                                            class="btn rounded-pill btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <center>No Tests Found</center>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-uppercase">Video Section</h5>
                                        @if (isset($videos) && $videos->count() > 0)
                                            @foreach ($videos as $video)
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <span>{{ $video->name }}</span>
                                                        <p class="p-0 m-0">
                                                            Link:{{ $video->videolink }}</p>
                                                        <p class="p-0 m-0">Type: <span
                                                                class="badge bg-label-{{ $video->type == 1 ? 'success' : 'primary' }}">{{ $video->type == 1 ? 'Paid' : 'Free' }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button"
                                                            wire:click="downloadFile({{ $video->id }})"
                                                            class="btn rounded-pill btn-warning">Download</button>
                                                        <a href="javascript:void(0)"
                                                            wire:click="editTest({{ $video->id }})"
                                                            class="btn rounded-pill btn-primary">Edit</a>
                                                        <button type="button"
                                                            wire:click="deleteTest({{ $video->id }})"
                                                            class="btn rounded-pill btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <center>No Videos Found</center>
                                        @endif
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-uppercase">Manage Test/Video Content</h5>
                            <div class="row">
                                <div class="col col-6 mb-3">
                                    <label for="testname" class="form-label">Name</label>
                                    <input type="text" wire:model="testname" id="testname" class="form-control"
                                        placeholder="Enter Test Name">
                                    @error('testname')
                                        <span class="text-danger">{{ $errors->first('testname') }}</span>
                                    @enderror
                                </div>
                                <div class="col col-6 mb-3 test {{ $videotype == 1 ? 'd-none' : '' }} ">
                                    <label for="limit" class="form-label  ">Limit</label>
                                    <input type="text" wire:model="limit" id="limit" class="form-control"
                                        placeholder="Enter Limit">
                                    <span style="font-size: 10px;">Provide Limit for Test if Any , Otherwise kindly
                                        ignore
                                        it</span>
                                    @error('limit')
                                        <span class="text-danger">{{ $errors->first('limit') }}</span>
                                    @enderror
                                </div>
                                <div class="col col-12 test mb-3 {{ $videotype == 1 ? 'd-none' : '' }} ">
                                    <label for="file" class="form-label">Upload Question</label>
                                    <input type="file" wire:model="file" id="file" class="form-control">
                                    <div wire:loading wire:target="file">File Uploading...</div>
                                    @error('file')
                                        <span class="text-danger">{{ $errors->first('file') }}</span>
                                    @enderror
                                </div>
                                <div class="col col-12  mb-3  ">
                                    <label for="link" class="form-label">Video Link</label>
                                    <input type="text" wire:model="link" id="link" class="form-control"
                                        placeholder="Enter link">
                                    @error('link')
                                        <span class="text-danger">{{ $errors->first('link') }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="col col-12  mb-3  ">
                                    <label for="date" class="form-label">Unlock Date</label>
                                    <input type="date" wire:model="unlockTime" id="date" class="form-control"
                                        placeholder="">
                                    @error('date')
                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="col mb-3  col-6">
                                    <label for="videotype" class="form-label">Is Video Type</label>
                                    <select class="form-select" id="videotype" wire:model="videotype"
                                        onclick="videotype(e)">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                    @error('videotype')
                                        <span class="text-danger">{{ $errors->first('videotype') }}</span>
                                    @enderror
                                </div> --}}
                                <div class="col mb-3  col-6">
                                    <label for="testtype" class="form-label">Type</label>
                                    <select class="form-select" id="testtype" wire:model="testtype"
                                        onclick="testtype(e)">
                                        <option value="1">Paid</option>
                                        <option value="0">Free</option>
                                    </select>
                                    @error('testtype')
                                        <span class="text-danger">{{ $errors->first('testtype') }}</span>
                                    @enderror
                                </div>
                                <div class="col mb-3 col-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" wire:model="teststatus"
                                        onchange="teststatus(event)">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                        <option value="2">Dummy</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="testsave()">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade " id="testviewmodal" wire:ignore.self data-bs-backdrop="static" tabindex="-1"
        aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testmodalTitle">Add Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>asd</li>
                        <li>asd</li>
                        <li>asd</li>
                        <li>asd</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="savetest()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function test(id) {

            Livewire.emit('test', id);
            $('#testmodal').modal('show');
        }

        function videotype(e) {

            Livewire.emit('videotype', e.target.value);

        }

        function clearTextArea() {
            $('#description').val('')
        }

        function testview(id) {

            Livewire.emit('testview', id);
            $('#testviewmodal').modal('show');
        }

        function teststatus(event) {
            Livewire.emit('teststatus', event.target.value);
        }

        function testtype(e) {
            console.log(e.target.value)
            Livewire.emit('testtype', e.target.value);
        }

        function status(e) {
            Livewire.emit('status', e.target.value);
        }

        function type(e) {
            Livewire.emit('type', e.target.value);
        }

        function exam(e) {
            Livewire.emit('exam', e.target.value);
        }


        Livewire.on('added', function() {
            $('#coursemodal').modal('hide');
            toastr.success('Plan Added');
            location.reload();
        })
        Livewire.on('edit-course', function() {
            $('#coursemodal').modal('show');
        })
        Livewire.on('test-added', function() {
            // $('#testmodal').modal('hide');
            toastr.success('Test Added');
            // location.reload();
        })
        Livewire.on('test-updated', function() {
            // $('#testmodal').modal('hide');
            toastr.success('Test Updated');
            // location.reload();
        })
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
        // ClassicEditor
        //     .create(document.querySelector('#description'))
        //     .then(editor => {
        //         editor.model.document.on('change:data', () => {
        //             @this.set('description', editor.getData());
        //         })
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });
        var textarea = "";
        Livewire.on('initializeCkEditor', function() {
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        // @this.set('description', editor.getData());
                        textarea = editor.getData();
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        });

        function save() {

            Livewire.emit('textAreaAdd', textarea)
        }
    </script>
@endpush
