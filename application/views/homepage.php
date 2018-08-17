<!DOCTYPE html>
<html>
  <head>
    <title>Nukus 360 Project - Observe Nukus city virtually</title>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link href="/assets/style.css" rel="stylesheet" type="text/css">
    <style>
      ul.carousel {
        display: flex;
        width: 720px;
        margin: 20px auto;
        padding: 0;
        justify-content: center;
        overflow: auto;
      }

      /* MOBILE */
      @media screen and (max-width: 700px) {
        ul.carousel {
          width: 100%;
          justify-content: flex-start;
        }

          ul.carousel li:first-child {
            padding-left: 0;
          }

          ul.carousel li:last-child {
            padding-right: 0;
          }
      }

        ul.carousel li {
          list-style: none;
          margin: 0;
          padding: 0 10px;
          display: inline-block;
        }
          ul.carousel li a {
            display: inline-block;
            text-align: center;
            margin: 0;
            padding: 0;
            color: #999;
            text-decoration: none;
          }
            ul.carousel li a.current {
              color: blue;
              text-decoration: underline;
            }
            ul.carousel li a img {
              width: 124px;
              height: 80px;
            }
            ul.carousel li a small {
              display: block;
            }
    </style>
  </head>
  <body>
    <h1 align="center">Nukus 360&#176; Project</h1>

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
  </body>
</html>
