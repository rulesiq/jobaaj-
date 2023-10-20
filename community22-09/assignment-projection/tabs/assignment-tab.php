<div class="tab-pane fade " id="assignment-tab" role="tabpanel">
    <h1 class="h2 pt-xl-1 mb-4 pb-2 border-bottom" style="color:#3e4265;">Upload Your Solved Excel File<span class="text-primary"> Here</span></h1>
    <div class="mb-4 card card-body">
        <form id="fileuploadform">
            <div class="row">
                <!-- <div class="col-md-6 mb-2">
                    <label for="assignmentName" class="form-label fs-base">File Name</label>
                    <input id="assignmentName" class="form-control" type="text" name="assignmentName" placeholder="Assignment Name" />
                </div> -->
                <div class="col-md-6 mb-2">
                    <label for="fileupload" class="form-label fs-base">Upload Excel</label>
                    <input id="fileupload" class="form-control" type="file" name="fileupload" accept=".xlsx,.xls" required />
                </div>
            </div>
            <div class="text-end">
                <button id="upload-button" class="btn btn-primary btn-sm" type="submit"> Upload </button>
            </div>
        </form>
    </div>
    <!-- <h1 class="h5 pt-xl-1 mb-4 pb-2 border-bottom" style="color:#3e4265;">All <span class="text-primary">Assignments</span></h1> -->

    <!-- <div class="table-responsive assignmentTable d-none">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Assignment</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="assignmentBody"></tbody>
            </table>
        </div> -->
    <!-- <div class="fuzzy-loading">
            <div class="card border-0 shadow mb-3" aria-hidden="true">
                <div class="card-body">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder placeholder-sm col-7 me-2"></span>
                        <span class="placeholder placeholder-sm col-4"></span>
                        <span class="placeholder placeholder-sm col-4 me-2"></span>
                        <span class="placeholder placeholder-sm col-6"></span>
                        <span class="placeholder placeholder-sm col-8"></span>
                    </p>
                    <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-6 placeholder-wave"> </a>
                </div>
            </div>
        </div> -->
    <!-- <input id="reupload" class="d-none" type="file" name="reupload" accept=".xlsx,.xls"> -->
    <!-- <div class="text-center card card-body">
            <img class="avatar avatar-xl mb-3 mx-auto" src="https://jobaaj.com/assets/svg/illustrations/empty-state-no-data.svg" alt="Image Description" style="width:200px;">
            <p class="card-text">No data to show</p>
        </div> -->
</div>

<script>
    document.getElementById('fileuploadform').addEventListener('submit', uploadFile);
    async function uploadFile(event) {
        event.preventDefault();
        const btn = document.getElementById('upload-button');
        btn.disabled = true;
        btn.textContent = 'Uploading...';
        try {
            let formData = new FormData(event.target);
            formData.append("reportId",reportId);
            const response = await fetch('../fun/upload', {
                method: "POST",
                body: formData
            });
            const data = await response.json();
            console.log(data);
            if (data.status == '1') {
                console.log(data);
                alert('Assignment has been uploaded successfully.');
                document.getElementById('assignment-tab').classList.remove('show', 'active');
                document.getElementById('mcq-tab').classList.add('show', 'active');
            } else {
                alert('Unable to upload assignment. Please check your file');
                console.log('errr');
            }
        } catch (error) {
            // Error handling
            console.log(error);
            alert('An error occurred during file upload.');
        }
        btn.disabled = false;
        btn.textContent = 'Upload';
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
</script>