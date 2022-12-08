<?php
  echo '<h4 class="cwa-section-header" data-target="faq-'.$post->ID.'">'.get_the_title().'</h4>';
  echo '<div id="faq-'.$post->ID.'" class="cwa-section-content"><div class="inner">';
  the_content();
  echo '</div></div>';
