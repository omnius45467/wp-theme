<!-- Start site footer -->
<footer class="site-footer">
<?php
$menu_locations = get_nav_menu_locations();
global $imic_options;
 ?>
       	<div class="container">
    		<div class="site-footer-top">
            <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
            	<div class="row">
                	<?php dynamic_sidebar('footer-sidebar'); ?>
            		</div>
           	<?php endif;
			$social_switch = $imic_options['footer_social_switch'];
			if($social_switch==1) { $foot_class = 9; } else { $foot_class = 12; }
            $infobar_switch = $imic_options['footer_infobar'];
			if($infobar_switch==1) { ?>
        		<!-- Quick Info -->
        		<div class="quick-info">
                    <div class="row">
                    <div class="col-md-<?php echo $foot_class; ?>">
                        <?php echo do_shortcode($imic_options['website_info']); ?>
                        </div>
                        <?php if($social_switch==1) {
							$socialSites = $imic_options['footer_social_links'];
                                                        if(!empty($socialSites)){
                                                        ?>
                        <div class="col-md-3">
                            <h4><i class="fa fa-clock-o"></i><?php _e(' Socialize with us','framework'); ?></h4>
                            <ul class="social-icons-colored inversed">
                                <?php
								foreach ($socialSites as $key => $value) {
									if (filter_var($value, FILTER_VALIDATE_URL)) {
										$string = substr($key, 3);
										echo '<li class="'.$string.'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . $key . '"></i></a></li>';
									}
								} ?>
                            </ul>
                        </div>
                        <?php }} ?>
                    </div>
            	</div>
                <?php } ?>
                </div>
        		<div class="site-footer-bottom">
            		<div class="row">
                    <?php
            if (!empty($imic_options['footer_copyright_text'])) { ?>
                		<div class="col-md-6 col-sm-6 copyrights-coll">
        					<?php echo $imic_options['footer_copyright_text']; ?>
            			</div>
                        <?php } if (!empty($menu_locations['footer-menu'])) { ?>
                		<div class="col-md-6 col-sm-6 copyrights-colr">
        					<nav class="footer-nav" role="navigation">
                        		<?php wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="">%3$s</ul>')); ?>
                        	</nav>
            			</div>
                        <?php } ?>
                   	</div>
               	</div>
           	</div>
        </div>
    </footer>
    <!-- End site footer -->
    <?php if ($imic_options['enable_backtotop'] == 1) { 
echo'<a id="back-to-top"><i class="fa fa-angle-double-up"></i></a> ';
 } ?> 
</div>
<!-- Event Directions Popup -->
<div class="quick-info-overlay">
	<div class="quick-info-overlay-left accent-bg">
        <a href="#" class="btn-close"><i class="icon-delete"></i></a>
    	<div class="event-info">
    		<h3 class="event-title"> </h3>
      		<div class="event-address"></div>
            <a href="" class="btn btn-default btn-transparent btn-permalink"><?php _e('Full details','framework'); ?></a>
            <a href="" class="btn btn-default btn-transparent btn-permalink event-directions-link" target="_blank"><?php _e('Get Directions','framework'); ?></a>
        </div>
    </div>
	<div class="quick-info-overlay-right">
      	<div id="event-directions"></div>
    </div>
</div>
<!-- Event Contact Modal Window -->
<div class="modal fade" id="Econtact" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="Econtact" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php _e('Contact Event Manager','framework'); ?> <span class="accent-color"></span></h4>
      </div>
      <div class="modal-body">
        <form id="contact-manager-form" class="paypal-submit-form" method="post">
            <div class="row">
                <div class="col-md-6">
                    <input id="username1" type="text" name="username1" class="form-control" placeholder="<?php _e('First name (Required)','framework'); ?>">
                </div>
                <div class="col-md-6">
                    <input id="lastname1" type="text" name="lastname1" class="form-control" placeholder="<?php _e('Last name','framework'); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input id="email1" type="text" name="email1" class="form-control" placeholder="<?php _e('Your email (Required)','framework'); ?>">
                </div>
                <div class="col-md-6">
                    <input id="phone1" type="text" name="phone1" class="form-control" placeholder="<?php _e('Your phone','framework'); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <textarea id="notes1" name="notes1" rows="3" cols="5" class="form-control" placeholder="<?php _e('Additional notes','framework'); ?>"></textarea>
                </div>
            </div>
            <input id="contact-manager" type="button" name="donate" class="btn btn-primary btn-lg btn-block" value="<?php _e('Contact Now','framework'); ?>">
            <div class="message"></div>
        </form>
      </div>
      <div class="modal-footer">
        <p class="small short"><?php echo $imic_options['event_contact_msg']; ?></p>
      </div>
    </div>
  </div>
</div>
<!-- Event Register Tickets -->
<div class="ticket-booking-wrapper">
    <a href="#" class="ticket-booking-close label-danger"><i class="icon icon-delete"></i></a>
    <div class="ticket-booking">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 id="ticket-msg"><strong><?php _e('Book your','framework'); ?></strong> <span><?php echo __('tickets','framework'); ?></span></h3>
                    <div id="multi-info-btn"><a style="display:none;" class="btn btn-sm btn-default" href="javascript:void(0);" id="edit-details"><?php _e('Update Personal Details','framework'); ?></a></div>
                </div>
                <div class="col-md-9">
                    <div class="event-ticket ticket-form">
                    <div class="user-details">
                <form id="user-event-info" class="register-info-event" method="post">
            <div class="row">
                <div class="col-md-6">
                    <input id="username" type="text" name="fname" class="form-control" placeholder="<?php _e('First name (Required)','framework'); ?>">
                </div>
                <div class="col-md-6">
                    <input id="lastname" type="text" name="lname" class="form-control" placeholder="<?php _e('Last name','framework'); ?>">
                    <span style="display:none;" class="ticket-col" id="form-event-date"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input id="email" type="text" name="email" class="form-control" placeholder="<?php _e('Your email (Required)','framework'); ?>">
                </div>
                <div class="col-md-6">
                    <input id="phone" type="text" name="phone" class="form-control" placeholder="<?php _e('Your phone','framework'); ?>">
                </div>
            </div>
            <input id="user-info" type="button" name="donate" class="btn btn-primary btn-lg btn-block" value="<?php _e('Next','framework'); ?>">
            <div class="message"></div>
        </form>
        </div>
        <div class="book-ticket" style="display:none;">
                        <div class="event-ticket-left">
                        	<div class="ticket-id"></div>
                            <div class="ticket-handle"></div>
                            <div class="ticket-cuts ticket-cuts-top"></div>
                            <div class="ticket-cuts ticket-cuts-bottom"></div>
                        </div>
                        <div class="event-ticket-right">
                            <div class="event-ticket-right-inner">
                                <div class="row">
                                    <div class="col-md-9 col-sm-9">
                                        <span class="meta-data"><?php _e('Your ticket for','framework'); ?></span>
                                        <h4 id="dy-event-title"> </h4>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <span class="meta-data"><?php _e('Tickets count','framework'); ?></span>
                                        <select name="members" class="form-control input-sm">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="event-ticket-info">
                                    <div class="row">
                                        <div class="col">
                                            <p class="ticket-col" id="dy-event-date"></p>
                                        </div>
                                        <div class="col" id="booking-btn">
                                            <a id="booking-ticket" href="#" class="btn btn-warning btn btn-block ticket-col book-event-reg"><?php _e('Book','framework'); ?></a>
                                        </div>
                                        <div class="col">
                                            <p id="dy-event-time"><?php _e('Starts','framework'); ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="event-location" id="dy-event-location"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
   	</div>
</div>
<!-- End Boxed Body -->
<?php wp_footer(); ?>
</body>
</html>