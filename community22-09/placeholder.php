 <div class="placeholder" style="background:transparent">
       
          <?php
          
          $i = 0;
          
          while ($i <= 5) { ?>
          
            <div class="card" style="padding:20px;">
              <div class="boxes" style="display:flex;height:15rem">
                <div class="shine" style="    border-radius: 10px;min-width: 69px;
                        height: 61px;
                        margin-right: 27px"></div>
                <div>
                  <lines class="shine" style="width:51%;height:12px;"></lines>
                  <lines class="shine" style="height:11px;width:224px;margin-top:15px;"></lines>
                  
                    
                </div>
                
              </div>
              
              
              <div style="display:flex;justify-content: space-around;margin-top: 10px;">
                <lines class="shine" style="height:10px;width:100px;"></lines>
                <lines class="shine" style="height:10px;width:100px;margin-left:10px;"></lines>
                <lines class="shine" style="height:10px;width:100px;margin-left:10px;"></lines>
              </div>

            </div>
            <br>
          <?php $i++;
          } ?>
        </div>
        
 <style>
 
          .placeholder {
            display: none;
          }
            .colm .card {
                    border: 1px solid rgb(193 193 193 / 0%);
            }
          .boxes {
            width: 600px;
          }

          .shine {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            
            background-size: 800px 104px;
            display: inline-block;
            position: relative;

            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-name: placeholderShimmer;
            -webkit-animation-timing-function: linear;
          }

          .box {
            height: 76px;
            width: 82px;
          }

          .pro {
            border-radius: 10px;
            width: 80px;
            margin-left: 25px;
            margin-top: 15px;
            vertical-align: top;
          }

          lines {
            width: 100%;
            height: 15px;
            border-radius: 5px;
            margin-top: 10px;
          }


          @-webkit-keyframes placeholderShimmer {
            0% {
              background-position: -468px 0;
            }

            100% {
              background-position: 468px 0;
            }
          }
        </style>