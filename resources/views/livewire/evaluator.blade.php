<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">Evaluator Management&nbsp;&nbsp;<a href="javascript:void(0)" wire:click="resetdata()" class="btn  rounded-pill btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#evaluatorModal" >
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
                      <th>Description</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                      @if (isset($datas) && !empty($datas))
                        @foreach ($datas as $data)
                        <tr>
                            <td><strong>{{$data->name}}</strong></td>
                            <td>{{$data->description}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->email}}</td>

                            <td><span class="badge bg-label-{{$data->status ==1 ?'primary' :'danger'}}  me-1">{{$data->status ==1 ?'Active' :'Inactive'}} </span></td>
                            <td>
                              <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" wire:click="edit({{$data->id}})" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                  {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> --}}
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
    <div class="modal fade " id="evaluatorModal" wire:ignore.self data-bs-backdrop="static" tabindex="-1"  aria-modal="true" role="dialog">
        <div class="modal-dialog">
          <form class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="evaluatorModalTitle">Add/Edit Evaluator</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col col-12 mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" wire:model="name" id="name" class="form-control" placeholder="Enter Name">
                  @error('name')
                    <span class="text-danger">{{$errors->first('name')}}</span>
                  @enderror
                </div>
                <div class="col col-12 mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="number" wire:model="phone" id="phone" class="form-control" placeholder="Enter Phone Number">
                  @error('phone')
                    <span class="text-danger">{{$errors->first('phone')}}</span>
                  @enderror
                </div>
                <div class="col col-12 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" wire:model="email" id="email" class="form-control" placeholder="Enter Email Address">
                  @error('email')
                    <span class="text-danger">{{$errors->first('email')}}</span>
                  @enderror
                </div>
                <div class="col col-12 mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" wire:model="password" id="password" class="form-control" placeholder="Enter password ">
                  @error('password')
                    <span class="text-danger">{{$errors->first('password')}}</span>
                  @enderror
                </div>
                <div class="col mb-3 col-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea name="" wire:model="description" class="form-control" id="" cols="20" rows="5"></textarea>
                  @error('description')
                    <span class="text-danger">{{$errors->first('description')}}</span>
                  @enderror
                </div>
              </div>
              <div class="row g-2">
                <div class="col mb-0">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" wire:model="status" onclick="select(e)">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
                  @error('status')
                    <span class="text-danger">{{$errors->first('status')}}</span>
                  @enderror
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
        function select(e) {
            Livewire.emit('select',e.target.value);
        }


        Livewire.on('added',function(){
            $('#evaluatorModal').modal('hide');
            toastr.success('Success');
        })
        Livewire.on('edit-data',function(){
            $('#evaluatorModal').modal('show');

        })

    </script>
@endpush
