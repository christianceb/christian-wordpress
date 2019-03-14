<?php
  global $team_member;
  $image_size = apply_filters( 'cit_shortcode_image_size', 'thumbnail' );
?>
<div class="team-member col-xs-12 col-sm-6 col-md-4">
  <a href='<?php echo $team_member['images']['full']['src']; ?>' title='<?php echo $team_member['name']; ?>' class='fancybox'><img src='<?php echo $team_member['images'][$image_size]['src'] ?> ?>' alt='<?php echo $team_member['name']; ?>' /></a>
  <h3><?php echo $team_member['name']; ?></h3>
</div>