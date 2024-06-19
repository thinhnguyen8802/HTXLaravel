<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
      overflow-x:hidden;
      height: auto;
    }
    #container{position:fixed; z-index:9999999999999999999!important; top:0px!important;}
    .dot{
      width:30px;
      height:30px;
      position:absolute;
      background: url(/../frontend/img/effect/hoa_dao.png);
      background-size: 100% 100%;
    }
    .dot2{
      width:30px;
      height:30px;
      position:absolute;
      background: url(/../frontend/img/effect/Hoa_mai_moi.png);
      background-size: 100% 100%;
    }
 
    #left-2022 {
    width: 130px;
    left: 0;
    z-index: 99999;
    position: fixed;
    top: 0;
  }
  #right-2022 {
    width: 130px;
    /* height: 182px; */
    right: -0px;
    z-index: 99999;
    position: fixed;
    top: 0;
  }
  @media only screen and (max-width: 1023px) {
  .tet-2012{
    display: none;
  }
}
  </style>
</head>
<body>
  <div id="container">
    
  </div>
  <div class="tet-2012">
    <img  id="left-2022" src="/../frontend/img/effect/banner_tet_left.png">
    <img  id="right-2022" src="/../frontend/img/effect/banner_tet.png">
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
  <script>
    var falling = true;

    TweenLite.set("#container",{perspective:600})
    //TweenLite.set("img",{xPercent:"-50%",yPercent:"-50%"})

    var total = 4;
    var container = document.getElementById("container"),	w = window.innerWidth , h = window.innerHeight;
    
    for (i=0; i<total; i++){ 
      var Div = document.createElement('div');
      var Div2 = document.createElement('div');
      TweenLite.set(Div,{attr:{class:'dot'},x:R(0,w),y:R(-200,-150),z:R(-200,200),xPercent:"-50%",yPercent:"-50%"});
      TweenLite.set(Div2,{attr:{class:'dot2'},x:R(0,w),y:R(-200,-150),z:R(-200,200),xPercent:"-50%",yPercent:"-50%"});
      container.appendChild(Div);
      container.appendChild(Div2);
      animm(Div);
      animm2(Div2);
    }
    
    function animm(elm){   
      TweenMax.to(elm,R(6,15),{y:h+100,ease:Linear.easeNone,repeat:-1,delay:-15});
      TweenMax.to(elm,R(4,8),{x:'+=100',rotationZ:R(0,180),repeat:-1,yoyo:true,ease:Sine.easeInOut});
      TweenMax.to(elm,R(2,8),{repeat:-1,yoyo:true,ease:Sine.easeInOut,delay:-5});
    };
      function animm2(elm){   
      TweenMax.to(elm,R(6,15),{y:h+100,ease:Linear.easeNone,repeat:-1,delay:-25});
      TweenMax.to(elm,R(4,8),{x:'+=100',rotationZ:R(0,180),repeat:-1,yoyo:true,ease:Sine.easeInOut});
      TweenMax.to(elm,R(2,8),{repeat:-1,yoyo:true,ease:Sine.easeInOut,delay:-5});
    };
      function animm3(elm){   
      TweenMax.to(elm,R(6,15),{y:h+100,ease:Linear.easeNone,repeat:-1,delay:-5});
      TweenMax.to(elm,R(4,8),{x:'+=100',rotationZ:R(0,180),repeat:-1,yoyo:true,ease:Sine.easeInOut});
      TweenMax.to(elm,R(2,8),{repeat:-1,yoyo:true,ease:Sine.easeInOut,delay:-5});
    };

    function R(min,max) {return min+Math.random()*(max-min)};
  </script>
</body>
</html>