<section class="container pt-3">
    <div class="row">
        <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
            <div class="text-center pt-5">
                <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                    <img src="" id="uploadPreview" class="d-block rounded-circle" width="120" alt="">
                </div>
                <h2 class="h5 mb-1"></h2>
                <p class="mb-3 pb-3"></p>

                <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#projection-menu">
                    <i class="bx bxs-user-detail fs-xl me-2"></i>
                    Exam Menu
                    <i class="bx bx-chevron-down fs-lg ms-1"></i>
                </button>
                <div id="projection-menu" class="list-group list-group-flush collapse d-md-block">
                    <a href="javascript:;" data-bs-toggle="tab" role="tab" class=" list-group-item list-group-item-action d-flex align-items-center active">
                        <i class="bx bx-collection fs-xl opacity-60 me-2"></i>
                        Exam Dashboard
                    </a>

                    <!-- <a href="#mcq-tab" data-bs-toggle="tab" role="tab" class="list-group-item list-group-item-action d-flex align-items-center active">
                        <i class="bx bx-collection fs-xl opacity-60 me-2"></i>
                        MCQ
                    </a> -->
                </div>
            </div>
        </aside>

        <!-- Account details -->
        <div class="col-md-9 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0 ps-md-5">
            <div class="container">
                <!-- Collapse 1 -->
                <div class="tab-content">
                    <div class="card p-5 mt-5 rounded-3" id="downloadexcel" style="background-color:#cbcbd005;">
                        <div class="mb-3">
                            <h4 class="mb-2">Hey,Welcome to Finance Exam</h4>
                            <p class="text-dark">This examination delves into a multitude of essential concepts, ranging from Future Value, Time Value of Money (TVM), Internal Rate of Return (IRR), and XNPV, to Sumproduct calculations, Effective interest rates, Depreciation methods, and Cash Flow analysis.</p>
                            <hr>
                        </div>
                        <div>
                            <p>
                                <span class="h5">Step 1 :</span>
                                <span class="fs-6">
                                    Download Excel File <a href="" class="text-decoration-none" download="">Click here</a>
                                </span>
                            </p>
                            <p>
                                <span class="h5">Step 2 :</span>
                                <span class="fs-6"> Solve your downloaded excel file</span>
                            </p>
                            <p>
                                <span class="h5">Step 3 :</span>
                                <span class="fs-6">Upload solved file in the next step</span>
                            </p>
                            <p>
                                <span class="h5">Step 4 :</span>
                                <span class="fs-6">There will be various MCQ's based over solved excel file</span>
                            </p>
                        </div>
                        <div class="d-flex justify-content-end">

                            <a href="#assignment-tab" id="startQuiz" class="btn btn-primary btn-sm">Start Now</a>
                        </div>
                        <p class="text-danger text-end mt-4 fw-bold">* Passing criteria is 60% and 5 Attempts are there.</p>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>



<!-- <script src="https://cdn.nishtyainfotech.com/learnings/assets/js/theme.min.js"></script> -->

<script>
    document.getElementById('startQuiz').addEventListener('click', (e) => {
        document.getElementById('downloadexcel').classList.add('d-none');
        document.getElementById('assignment-tab').classList.add('show', 'active');
    });
</script>