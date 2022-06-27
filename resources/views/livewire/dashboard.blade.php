<div>
    <div class="container-xxl flex-grow-1 container-p-y">



        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ @Auth::user()->name }} </h5>
                                <p class="mb-4">It's Nice to see you here again. Have a nice day!</p>

                                {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="/assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class=" col-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fa-solid fa-swatchbook rounded fa-2x"></i>
                                    </div>

                                </div>
                                <span class="fw-semibold d-block mb-1">Total Test Attempted</span>
                                <h3 class="card-title mb-2">{{ @$totalTest }}</h3>
                                {{-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +72.80%</small> --}}
                            </div>
                        </div>
                    </div>
                    <div class=" col-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="fa-solid fa-swatchbook rounded fa-2x"></i>

                                    </div>

                                </div>
                                <span>Today Test Attempted</span>
                                <h3 class="card-title text-nowrap mb-1">{{ @$todayTest }}</h3>
                                {{-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +28.42%</small> --}}
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->user_type == 1)
                        <div class=" col-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="fa-solid fa-swatchbook rounded fa-2x"></i>

                                        </div>

                                    </div>
                                    <span>Test Not Asigned</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ @$testNotAssigned }}</h3>
                                    {{-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +28.42%</small> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if (Auth::user()->user_type == 1)
                <div class="col-12">
                    <div class="row">
                        <div class=" col-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                                class="rounded">
                                        </div>

                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Purchase</span>
                                    <h3 class="card-title mb-2">{{ @$totalOrders }}</h3>
                                    {{-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +72.80%</small> --}}
                                </div>
                            </div>
                        </div>

                        <div class=" col-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                                class="rounded">
                                        </div>

                                    </div>
                                    <span class="fw-semibold d-block mb-1">Today Purchase</span>
                                    <h3 class="card-title mb-2">{{ @$todayOrders }}</h3>
                                    {{-- <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +72.80%</small> --}}
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            @endif

        </div>


    </div>
</div>
