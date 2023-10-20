           <style>
               .nav-body{
                    list-style: none;
                    line-height: 2.5rem;
                    font-size: 1rem;
                    margin-top: 1rem;
                    margin-left: -2rem;
               }
               .nav-body i{
                    
                    margin-right: 1rem;
               }
           </style>
            <div class="right-sidebar-area right-size" data-simplebar>
                  <aside class="" style="padding: 1rem;">
                        
                       <div class="others-options d-flex align-items-center">
                         <div class="option-item">
                            <?php if($user['id']!='') { ?>
                                           
                                            <div class="profile-header">
                                                <h3><?php echo $user['full_name']; ?></h3>
                                                <a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a>
                                            </div>
                                            <ul class="profile-body nav-body">
                                                <li><i class="flaticon-comment"></i> <a onclick="myPosts()"  href="javascript:;">My Posts</a></li>
                                                <li><i class="flaticon-user"></i> <a  target="_blank" href="<?php echo $l_url;?>/dashboard/?edit">Edit Profile</a></li>
                                                <li><i class="flaticon-menu"></i> <a onclick="changeCat()"  href="javascript:;">Update Category</a></li>
                                                <li><i class="flaticon-logout"></i> <a href="logout">Logout</a></li>
                                            </ul>
                                            
                            <?php }else { ?>
                             <ul class="profile-body nav-body">
                                    <li>
                                        <div>
                                        <i class="flaticon-logout"></i> <a href="javascript:;" onclick=" loginNow();">Login</a>
                                        </div>
                                    </li>
                                </ul>
                            <?php } ?>
                            </div>
                            
                            
                            
                        </div>
                        
                        <div class="py-2 px-3 tranding">
                      <h5 class="py-3">#Trending Now</h5>
                      
                     <?php 
                     $fetch = mysqli_query($db,"select * from com_hashtags order by id desc");
                     while($row = mysqli_fetch_assoc($fetch)) { 
                         $tag = ucfirst($row['hashtag']);
                         echo '
                              <div class="d-flex mb-3 flex-column">
                              <span class="cat">'.$row['category'].'</span>
                              <a href="https://stories.jobaaj.com/search/'.$tag.'" target="_blank">#'.$tag.'</a>
                              <span class="view">'.rand(10,50).'.'.rand(1,5).'K views</span>
                              </div>';
                       } ?>
                  
                  
                  </div>
                  
                  
                  </aside>
            </div>
