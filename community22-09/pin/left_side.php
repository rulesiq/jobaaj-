
<style>
.sidenav {
  height: 100%;
      box-shadow: 1px 1px 4px #00000040;
  width: 0;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #ffffff;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 10px;
z-index: 11111111111;
    
}

.sidenav a {
  padding: 8px 8px 8px 2px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}
.open-class{
    width:250px;
}
.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}

.menu_sidebar li img{
    max-width:26px;
}

.menu_sidebar {
    list-style:none;
    margin-top:1rem;
    padding-left: 1rem !important;

} 
.menu_sidebar li .menu-title{
   font-weight: 600;
    font-size: .8rem;
    color: #222;
        
}
.menu_sidebar li a {
    margin-bottom: 0.5rem;
}
.nav-link-active .menu-title {
    color:#4251ec !important;
}

</style>

<div id="mySidenav" class="sidenav">
  <div class="" style="width: 15rem;">
                    <p style="padding-top:.5rem;margin:0 .5rem;font-weight:600;font-size:.8rem">Categories</p>
                    <ul class="menu_sidebar metisMenu h-100" >
                        <?php
                        //
                        $q = mysqli_query($db, "select * from com_category order by position");
                        $i = 0;
                        while ($c = mysqli_fetch_array($q)) {
                          ++$i; ?>
                        <li class="nav-item">
                            <a  onclick="getPosts('<?php echo $c['id'];?>')" href="#<?php echo str_replace(" ","",str_replace("&","",$c['name']));?>"  class="nav-link cat<?php echo $c['id']; ?>">
                                 <span class="icon">
                                      <i style="color:<?php echo $c['color_code'];?>" class="<?php echo $c['thumb']; ?>"></i>
                                  </span>
                                   
                                <span class="menu-title"><?php echo $c['name'];?></span>
                            </a>
                        </li>
                        
                        <?php } ?>
                                        <img style="margin-top: 22px;cursor:pointer;" onclick="location.href='https://www.jobaajlearnings.com/workshop'"  src="<?php echo $url;?>assets/offer-banner-workshop.jpg"/>

                    </ul>
                </div>
                </div>


<script>
function openNav() {
    
  $("#mySidenav").toggleClass('open-class');
  
}
</script>
                
