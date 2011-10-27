<?php
// ------------------------------------------------------------
// home.php.
// a demo home page.  not meant to be a top-level file;
// should be included by top-level files like index.php.
// ------------------------------------------------------------
?>

<div id="page">
  <div class="content">
    <h1>Janrain Capture Demo Site</h1>

    <div id='message' style="color: blue; padding: 20px; display: none"></div>

    <?php
      if (isset($_SESSION['user_friendly_message'])) {
          ?>

              <script type="text/javascript">
                  $('#message').show();
                  $('#message').text("<?php echo $_SESSION['user_friendly_message']; ?>");
              </script>

          <?php

          $_SESSION['user_friendly_message'] = null;
      }
    ?>


      <ul class="lipsum">
      <li>
        <span>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ipsum nec nunc vulputate porttitor eu in sapien. Nullam et metus eu diam dignissim sollicitudin. Donec metus dui, dictum non posuere quis, lacinia et magna. asdf asdf asdf.
        </span>
      </li>
      <li>
        <span>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ipsum nec nunc vulputate porttitor eu in sapien. Nullam et metus eu diam dignissim sollicitudin. Donec metus dui, dictum non posuere quis, lacinia et magna. asdf asdf asdf.
        </span>
      </li>
      <li>
        <span>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ipsum nec nunc vulputate porttitor eu in sapien. Nullam et metus eu diam dignissim sollicitudin. Donec metus dui, dictum non posuere quis, lacinia et magna. asdf asdf asdf.
        </span>
      </li>
      <li class="last">
        <span>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ipsum nec nunc vulputate porttitor eu in sapien. Nullam et metus eu diam dignissim sollicitudin. Donec metus dui, dictum non posuere quis, lacinia et magna. asdf asdf asdf.
        </span>
      </li>
    </ul>
    <div class="clear"></div>

    <h2>Lorem Ipsum</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut a turpis ligula, ac suscipit ipsum. Proin euismod aliquet nulla consequat mattis. Proin posuere vestibulum ipsum non volutpat. Phasellus faucibus vehicula vehicula. Sed ultrices sem sed est porttitor non blandit lorem laoreet. Suspendisse tempor tristique enim non pretium. Nulla facilisi. Vivamus eleifend, ipsum non tincidunt scelerisque, odio lacus molestie tortor, at aliquet felis est id erat. Morbi ipsum tellus, feugiat ac egestas quis, blandit ut lorem. Aenean porta aliquam tellus iaculis imperdiet. Aliquam ut nunc sapien, vel porta nunc. Nunc tincidunt posuere dictum. Pellentesque vel lacus eros, pellentesque accumsan tellus. Suspendisse nec adipiscing odio. Cras aliquet, felis ac accumsan condimentum, velit eros vulputate tellus, non vestibulum mauris nulla ut eros. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
    <p>Praesent laoreet elit eu orci aliquam vel pharetra justo vehicula. Ut mattis viverra nunc vel euismod. Nam pellentesque iaculis ante vel hendrerit. Cras et lectus ligula, et venenatis ipsum. Fusce venenatis porta enim, aliquet condimentum dolor gravida in. Curabitur luctus neque convallis sapien mattis in eleifend leo tempus. Morbi volutpat laoreet augue, sit amet venenatis velit porta id. Sed arcu risus, suscipit blandit posuere id, ullamcorper sit amet ligula. Donec eleifend vehicula pulvinar. Mauris ante ipsum, feugiat id molestie eu, cursus eget quam. Sed justo leo, fringilla non interdum et, hendrerit et orci. Aenean euismod urna eget urna egestas quis ultricies lacus facilisis. Cras ut risus justo. Donec quis massa ligula.</p>
  </div>
</div>

