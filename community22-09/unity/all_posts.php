<?php
require('inc/head.php');
require('inc/sidenav.php');
?>

<style>
    .btn {
        cursor:pointer;
    } 
</style>


<div class="content-page">
    <div class="content">

        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0" id="Htitle">All Posts</h4>
            </div>
        </div>
        
        <div class="row mb-3" id="filter_block">

            <div class="col-md-3">
                <div class="mb-3">
                    <label for="created_at">Category</label>
                     <select class="form-control" name="cat_id" id="cat_id">
                                <option selected value="0">Select Category</option>
                                <?php
                                $data = mysqli_query($db,"select * from com_category");
                                $i = 0;
                                while($d = mysqli_fetch_array($data)) {
                                    $i++;
                                    ?>  
                                    <option <?php echo $i == 1 ? 'selected' : '';?>   value="<?php echo $d['id'];?>"><?php echo $d['name'];?></option>
                                <?php } ?>                                
                    </select>
                </div>
            </div>
            
             <div class="col-md-3">
                <div class="mb-3">
                    <label for="created_at">Created At</label>
                    <input type="text" name="date_posted" id="date_posted" data-isDate='true' class="form-control flatpickr_date">
                </div>
            </div>
            
             <div class="col-md-3">
                <div class="mb-3">
                    <label for="created_at">User Id</label>
                    <input type="text" placeholder="Search Email" name="user_id" id="user_id"  class="form-control">
                </div>
            </div>

            <div class="col-md-2">
                <div class="d-flex flex-column">
                <button type="button" class="btn btn-danger btn-padding mb-1" name="clear_filter" id="clear_filter">Clear</button>
                    <button class="btn btn-success btn-padding" type="button" name="search_filter" id="search_filter">Search</button>
                </div>
            </div>

            <div class="col-sm-12">
                <div id="filter_options" class="d-flex align-items-center flex-wrap" style="gap:0.25rem"></div>
            </div>

        </div>
                     <h6 class="mb-1 mt-0" id="Htitle">Update Posts</h6>

         <div class="row pb-5">
                                    <div class="col-sm-3">
                                        <select class="form-control" id="postStatus" name="status">
                                            <option selected value="0">Select Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Active</option>
                                        </select>
                                             <button type="button" onclick="updatePosts()" class="btn btn-success mt-3" style="float:right" name="updateCheck">Update</button>
                                           


                                    </div>
                                    <div class="col-sm-3 offset-6">
                                     <button type="button" onclick="deletePosts()"  style="float:right"  class="btn btn-danger mt-5" name="deleteCheck">Delete Checked Posts</button>

                                    </div>

                             </div>
                                
                                
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding: 30px;">


                        <div class="table-responsive">
                            <table id="basic-datatable" class="table">
                                <thead>
                                     <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col"><input type="checkbox" name='selectAll' id="select-all-posts"> Select all</th>
                                        <th scope="col">Post</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Posted On</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Notification</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>

                    </div> 
                    
                         <!-- End Pagination -->

                               




<!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end col-12-->
        </div>
        <!-- end row-->
    </div>
    <!-- container-fluid -->
</div>
<!-- content -->


<?php require('inc/foot.php'); ?>

<script src="get_data_from_server/custom.js"></script>




<script defer>

    function deleteJob(id) {
        if (confirm("Do you want to delete Job !")) {
            location.href = "?delete=" + id;
        }
    }
    
    let post_ids = [];
    
    
    $(document).ready(function() {
        $("#search_filter").click(function() {
            $("#filter_options").html('');
            
            form_fields.each(function() {
                search_filter(this);
            });
            
            if (setArray.length > 0) {
                loadTable('#basic-datatable', 'get_data_from_server/get_all_posts', 0, setArray);
            } else {
                loadTable('#basic-datatable', 'get_data_from_server/get_all_posts', 0);
            }
            
            setArray = [];
           // console.log(setArray);
        });
        $("#search_filter").click();
        
      

       
      const mainBox = document.querySelector('.table-responsive');
      
      mainBox.addEventListener('click',(e)=>{
                
                if(e.target.closest('.id_check')){
                    
                    let post = e.target.closest('.id_check');
                    
                    if(post.checked) { 
                    post_ids.push(post.dataset.id) }
                    else 
                    post_ids = post_ids.filter(v => v !== post.dataset.id)

                }
                
               if(e.target.closest('.status-change')){
                    
                    let post = e.target.closest('.status-change');
                    console.log(post)
                    post_id = post.dataset.id;
                    status = post.dataset.st;
                    statusChange(post_id,status)
                    if(status == '1') { 
                   
                         post.classList.remove("btn-danger");
                    post.classList.add("btn-success");
                    post.textContent = 'Active!';
                    }
                    else { 
                         post.classList.remove("btn-success");
                    post.classList.add("btn-danger");
                    post.textContent = 'Pending!';
                    }
                }
                
                
                
                return false;
                
                
        });
        
        
        
    });
    
    const selectAll = document.getElementById('select-all-posts');
        
        selectAll.addEventListener('click',(e)=>{
            
            const checkbox = e.target;
            const checkboxes_child = document.getElementsByName('checkboxPost'); 
            
            if(checkbox.checked) {
                
                post_ids = []
                Array.from(checkboxes_child).map(child => {
                     child.checked=true
                     
                     post_ids.push(child.dataset.id);
                });
                
                
            }
            else {
                Array.from(checkboxes_child).map(child=> child.checked=false);
                post_ids = []

            }
            console.log(post_ids)

        });
        
        
        function deletePosts(){
            
        if (confirm("😱 Do you want to delete Posts !")) {
           
             $.ajax({
                
              url: "fun/postFunctions",
              type: "POST",
              data: {
                  delPosts: true,
                  postIds: post_ids,
              },
              cache: false,
              success: function(result) {
                 post_ids = []
                 $("#search_filter").click();
              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });
          
        }
          
        }
        
        
        function statusChange(postId,status){
            
             $.ajax({
                
              url: "fun/postFunctions",
              type: "POST",
              data: {
                  statusUpdate: true,
                  post: postId,
                  status: status
              },
              cache: false,
              success: function(result) {
              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });
          
        }
        
        
        function updatePosts(){
           let status =  $("#postStatus").val();
           
            $.ajax({
                
              url: "fun/postFunctions",
              type: "POST",
              data: {
                  updatePostStatus: true,
                  postIds: post_ids,
                  status: status,
              },
              cache: false,
              success: function(result) {
                 console.log(result)
                 post_ids = []
                 $("#search_filter").click();
              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });
          
          
          

        }
        
        
        
        
</script>


<?php




?>