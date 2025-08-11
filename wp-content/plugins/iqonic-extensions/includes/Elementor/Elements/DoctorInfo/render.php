<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();

if (function_exists('get_field')) {
$key =  get_field('key_pjros1245', get_the_ID());

$facebook = $key['iqonic_team_facebook'];
$twitter = $key['iqonic_team_twitter'];
$google = $key['iqonic_team_google'];
$github = $key['iqonic_team_github'];
$insta  = $key['iqonic_team_insta'];
$whatsapp  = $key['iqonic_team_whatsapp'];
}

global $post;

$li = '';

if (!empty($facebook)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-facebook-f"></i></a></li>', esc_url($facebook));
}
if (!empty($twitter)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-x-twitter"></i></a></li>', esc_url($twitter));
}
if (!empty($google)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-google"></i></a></li>', esc_url($google));
}
if (!empty($github)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-github"></i></a></li>', esc_url($github));
}
if (!empty($insta)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-instagram"></i></a></li>', esc_url($insta));
}
if (!empty($whatsapp)) {
	$li .= sprintf('<li><a href="%s"><i class="fab fa-whatsapp"></i></a></li>', esc_url($whatsapp));
}
?>
<div class="iq-team-style-1 detail-page iq-doctor-info">
	<div class="iq-team-blog">
		<div class="iq-team-img">
			<?php the_post_thumbnail(); ?>
		</div>
		<div class="share iq-team-social">
			<ul>
				<?php echo $li; ?>
			</ul>
		</div>
		<div class="iq-team-info">
			<div class="iq-team-main-detail">
				<a href="<?php the_permalink(); ?>">
					<h4 class="member-text iq-heading-title">
						<?php echo sprintf("%s", esc_html(get_the_title($post->ID))); ?>
					</h4>
				</a>
				<span class="iq-specialized">
					<?php echo iq_by_team_cat(get_the_ID()); ?>
				</span> 
			</div>
		</div>
	</div>
</div>