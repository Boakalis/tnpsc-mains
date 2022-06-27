<div>
    <div class="">
        <div class="row">

            <h4 class="fw-bold py-3 mb-4 ">Change Password&nbsp;&nbsp;</h4>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- <form action=""> --}}
                <div class="row">

                    <div class="col col-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" wire:model="password" required id="password" class="form-control"
                            placeholder="Enter password ">
                        @error('password')
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @enderror
                    </div>
                    <div class="col col-12 mb-3">
                        <label for="password" class="form-label">Confirm Password</label>
                        <input type="password" wire:model="confirmPassword" required id="password" class="form-control"
                            placeholder="Enter password ">
                        @error('password')
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary" wire:click="update()">Update</button>
            {{-- </form> --}}
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function test(id) {

            Livewire.emit('test', id);
            $('#testmodal').modal('show');
        }
        Livewire.on('test-added', function() {
            // $('#testmodal').modal('hide');
            toastr.success('Test Added');
            // location.reload();
        })
        Livewire.on('required', function() {
            toastr.error('Please Provide All Data');
        })
        Livewire.on('invalid', function() {
            toastr.error('Password should be atleast 6 characters');
        })
        Livewire.on('mismatch', function() {
            toastr.error('Password and Confirm password should be same');
        })
        Livewire.on('updated', function() {
            toastr.success('Password Changed successfully');
        })
    </script>
@endpush
