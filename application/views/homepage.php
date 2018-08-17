<!DOCTYPE html>
<html>
  <head>
    <title>Nukus 360 Project - Observe Nukus city virtually</title>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/style.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/circle.css" rel="stylesheet" type="text/css">
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <style>
      
    </style>
  </head>
  <body>

    <nav id="top-navbar" class="navbar navbar-dark bg-dark sticky-top">
      
      <ul class="nav ">
        <li class="nav-item">
          <a class="nav-link" href="#panoramas">Panoramas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contacts">Contacts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#feedback">Feedback</a>
        </li>
      </ul>
    </nav>
    <div data-spy="scroll" data-target="#top-navbar" data-offset="0" id="main-content">
      
      <!-- ========== добавляем панораму ========== -->
      <h4 id="panoramas" align="center">Panoramas</h4>
      
      <div id="vrview"></div>

      <ul class="carousel">
      <?php foreach($panoramas as $pano):?>
      <?php
      $thumbnail_name = str_replace(".jpg","_thumbnail.jpg",$pano->path);
      $preview_name = str_replace(".jpg","_thumbnail.jpg",$pano->path);
      ?>
        
        <li>
          <a href="#image<?php echo $pano->id;?>">
            <img src="/assets/panoramas/<?php echo $thumbnail_name;?>">
            <small><?php echo $pano->title;?></small>
          </a>
        </li>
      <?php endforeach;?>
        
      </ul>
      
<div class="container">
      <!-- ========== информация ========== -->
      <div class="row">
        <h4 id="about">About project</h4>
        <div class="media">
          <img class="mr-3" src="/images/nukus.jpg" alt="Generic placeholder image" width="300" />
          <div class="media-body">
            <h5 class="mt-0">About Nukus</h5>
            <p>Nukus 360 Project is about our home city - Nukus, which is located in the Republic of Uzbekistan. Nukus is widely known by its State Museum called after I.V.Savitsky, which is also known as &laquo;The Louvre of the Desert&raquo;</p>
          </div>
        </div>
        <br/>
        <div class="media">
          <img class="mr-3" src="/images/360-vr.jpg" alt="Generic placeholder image" width="300">
          <div class="media-body">
            <h5 class="mt-0">360 degree images</h5>
            <p>A 360-degree photo is a controllable panoramic image that surrounds the original point from which the shot was taken.</p>
            <p>360-degree photos simulate being in the shoes of a photographer and looking around to the left, right, up and down as desired as well as sometimes zooming. The viewer clicks any point on the image to drag it in the desired direction.</p>
          </div>
        </div>
      </div>
      <!-- ========== разработчики ========== -->
      <h4 id="contacts">Contacts</h4>
      
      <ul>
        <li>Azizbek Kadirov, team leader</li>
        <li>Alibek Embergenov, designer</li>
        <li>Alima Orinbaeva, photographer</li>
        <li>Allaniyaz Nurahimov, coder</li>
        <li>Baxit Turumbetov, project manager, coder</li>
      </ul>
        <div class="circle-example">
          <div class="text">Our Team</div>
          <div class="image-wrapper"><img class="image" src="/images/allaniyaz.jpg" /></div>
          <div class="image-wrapper"><img class="image" src="/images/alibek.jpg"/></div>
          <div class="image-wrapper"><img class="image" src="/images/azizbek.jpg" title="Azizbek Kadirov, lecturer, Nukus branch of TUIT. Likes &laquo;Game of Thrones&raquo;" /></div>
          <div class="image-wrapper"><img class="image" src="/images/bahit.jpg"/></div>
          <div class="image-wrapper"><img class="image" src="/images/alima.jpg"/></div>
        </div>

    <!-- ========== обратная связь ========== -->
      <h4 id="feedback">Feedback</h4>
      <form action="/feedback" method="post">
        <div class="form-group">
          <input type="text" name="from" id="name" placeholder="Bill Gates" class="form-control col-md-4 col-sm-12" />
        </div>
        <div class="form-group">
          <input type="email" name="email" id="email" placeholder="palensheev@mail.ru" class="form-control col-md-4 col-sm-12" />
        </div>
        <input type="hidden" name="title" value="message" />
        <div class="form-group">
          <textarea name="text" id="message" placeholder="Your message" rows="6" class="form-control col-md-6 col-sm-12"></textarea>
        </div>
        <div class="form-group">
          <img src="/captcha/?<?php echo time();?>" />
          <input type="text" name="captcha" id="captcha" class="form-control col-md-4" placeholder="Security code" />
        </div>
        <div class="form-group">
        <input type="submit" name="send" class="btn btn-primary" value="Send" />
        </div>
      </form>


    </div>
</div>


    
    <script src="/assets/build/vrview.js"></script>
    <!--<script src="/assets/photos.js"></script>-->
    <script>
    var vrView;

    // All the scenes for the experience
    var scenes = {
      <?php foreach($panoramas as $pano):
      $thumbnail_name = str_replace(".jpg","_thumbnail.jpg",$pano->path);
      $preview_name = str_replace(".jpg","_thumbnail.jpg",$pano->path);
      printf("image%s: {
          image: '/assets/panoramas/%s',
          preview: '/assets/panoramas/%s',
      },
      ", $pano->id, $pano->path, $preview_name);
      endforeach;?>
    };

    function onLoad() {
      vrView = new VRView.Player('#vrview', {
        width: '100%',
        height: 480,
        image: '/images/blank.png',
        is_stereo: false,
        is_autopan_off: true
      });

      vrView.on('ready', onVRViewReady);
      vrView.on('modechange', onModeChange);
      vrView.on('error', onVRViewError);
    }

    function loadScene(id) {
      console.log('loadScene', id);

      // Set the image
      vrView.setContent({
        image: scenes[id].image,
        preview: scenes[id].preview,
        is_autopan_off: true
      });

      // Unhighlight carousel items
      var carouselLinks = document.querySelectorAll('ul.carousel li a');
      for (var i = 0; i < carouselLinks.length; i++) {
        carouselLinks[i].classList.remove('current');
      }

      // Highlight current carousel item
      document.querySelector('ul.carousel li a[href="#' + id + '"]')
          .classList.add('current');
    }

    function onVRViewReady(e) {
      console.log('onVRViewReady');

      // Create the carousel links
      var carouselItems = document.querySelectorAll('ul.carousel li a');
      for (var i = 0; i < carouselItems.length; i++) {
        var item = carouselItems[i];
        item.disabled = false;

        item.addEventListener('click', function(event) {
          event.preventDefault();
          loadScene(event.target.parentNode.getAttribute('href').substring(1));
        });
      }

      loadScene('image<?php echo $panoramas[0]->id;?>');
    }

    function onModeChange(e) {
      console.log('onModeChange', e.mode);
    }

    function onVRViewError(e) {
      console.log('Error! %s', e.message);
    }

    window.addEventListener('load', onLoad);
    </script>
    <script>
      $(document).ready(function(){
        // Add scrollspy to <body>
        $('body').scrollspy({target: ".navbar", offset: 50});

        // Add smooth scrolling on all links inside the navbar
        $("#top-navbar a").on('click', function(event) {

          // Make sure this.hash has a value before overriding default behavior
          if (this.hash !== "") {

            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
              scrollTop: $(hash).offset().top
            }, 800, function(){

            // Add hash (#) to URL when done scrolling (default click behavior)
              window.location.hash = hash;
            });

          } // End if

        });
      });
    </script>
  </body>
</html>
