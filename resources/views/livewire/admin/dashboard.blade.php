<div>

    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
          <div class="col-md-4">
            <img src="{{ auth()->user()->picture }}" alt="">
          </div>
          <div class="col-md-8">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
              Welcome back
              <div class="weight-600 font-30 text-blue">{{ auth()->user()->name }}</div>
            </h4>
            <p class="font-18 max-width-600">
                {{ auth()->user()->bio ? auth()->user()->bio : 'Empty!' }}
            </p>
          </div>
        </div>
    </div>

    <div class="row pb-10">

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">

            <div class="card-box height-100-p widget-style3">

                <div class="d-flex flex-wrap">

                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">75</div>
                        <div class="font-14 text-secondary weight-500">
                            Appointment
                        </div>
                    </div>

                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
                            <i class="icon-copy dw dw-calendar1"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">

                <div class="d-flex flex-wrap">

                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">124,551</div>
                        <div class="font-14 text-secondary weight-500">
                            Total Patient
                        </div>
                    </div>

                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
                        <span class="icon-copy ti-heart"></span>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">

        <div class="card-box height-100-p widget-style3">

            <div class="d-flex flex-wrap">

                <div class="widget-data">

                    <div class="weight-700 font-24 text-dark">400+</div>

                        <div class="font-14 text-secondary weight-500">
                            Total Doctor
                        </div>
                    </div>

                    <div class="widget-icon">
                        <div class="icon">
                            <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">

            <div class="card-box height-100-p widget-style3">

                <div class="d-flex flex-wrap">

                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">$50,000</div>
                        <div class="font-14 text-secondary weight-500">Earning</div>
                    </div>

                    <div class="widget-icon">
                        <div class="icon" data-color="#09cc06" style="color: rgb(9, 204, 6);">
                            <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    
</div>
