<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Events_Metabox
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('add_meta_boxes', array($this, 'events_add_custom_box'));
        add_action('save_post_events', array($this, 'events_save_postdata'));
    }

    function events_add_custom_box()
    {
        $screens = array('events');
        add_meta_box('events_sectionid', 'Events', array($this, 'events_meta_box_callback'), $screens);
    }

    function events_meta_box_callback($post)
    {
        $post_id = $post->ID;
        wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
        $from_date = get_post_meta($post_id, 'ax_from_date', 1);
        $to_date = get_post_meta($post_id, 'ax_to_date', 1);
        $from_time = get_post_meta($post_id, 'ax_from_time', 1);
        $to_time = get_post_meta($post_id, 'ax_to_time', 1);
        $country = get_post_meta($post_id, 'ax_country', 1);
        $location = get_post_meta($post_id, 'ax_location', 1);
        $max_tickets = get_post_meta($post_id, 'ax_max_tickets', 1);
        $bought_tickets = get_post_meta($post_id, 'ax_bought_tickets', 1);
        $price = get_post_meta($post_id, 'ax_price', 1);



?>
        <div class="_ax_events">
            <h5 class="_ax_events-title">Date</h5>
            <div class="_ax_events-dates _ax_events-wrapper">
                <div class="_ax_events-box">
                    <label for="ax_from_date">Date Start </label>
                    <input type="text" id="ax_from_date" name="ax_from_date" value="<?= $from_date ?>" autocomplete="off">
                </div>
                <div class="_ax_events-box">
                    <label for="to">Date End</label>
                    <input type="text" id="ax_to_date" name="ax_to_date" value="<?= $to_date ?>" autocomplete="off">
                </div>
            </div>
            <h5 class="_ax_events-title">Time</h5>
            <div class="_ax_events-time _ax_events-wrapper">
                <div class="_ax_events-box">
                    <label for="from">Time Start </label>
                    <input type="time" id="ax_from_time" name="ax_from_time" value="<?= $from_time ?>">
                </div>
                <div class="_ax_events-box">
                    <label for="to">Time End</label>
                    <input type="time" id="ax_to_time" name="ax_to_time" value="<?= $to_time ?>">
                </div>
            </div>
            <h5 class="_ax_events-title">Location</h5>
            <div class="_ax_events-location _ax_events-wrapper">
                <div class="_ax_events-box">
                    <label for="from">Country <?= $country ?> </label>
                    <select id="ax_country" name="ax_country" data-value='<?= $country ?>'> <?php require_once 'assets/countrys.php'; ?> </select>

                    <script>
                        const country = document.querySelector('#ax_country')
                        if (country) {
                            const countryValue = country.getAttribute('data-value')
                            country.querySelectorAll('option').forEach(option => {
                                if (countryValue == option.value) {
                                    option.selected = true;
                                }
                            })
                        }
                    </script>

                </div>
                <div class=" _ax_events-box">
                    <label for="to">Location</label>
                    <input type="text" id="ax_location" name="ax_location" value="<?= $location ?>">
                </div>
            </div>
            <h5 class="_ax_events-title">Tickets</h5>
            <div class="_ax_events-tickets _ax_events-wrapper">
                <div class="_ax_events-box">
                    <label>Max tickets </label>
                    <input type="number" id="ax_max_tickets" name="ax_max_tickets" value="<?= $max_tickets ? $max_tickets : 10  ?>">
                </div>
                <div class=" _ax_events-box">
                    <label>Already bought tickets</label>
                    <input type="number" id="ax_bought_tickets" name="bought_tickets" value="<?= $bought_tickets ? $bought_tickets : 0 ?>" readonly>
                </div>
            </div>
            <h5 class="_ax_events-title">Price $</h5>
            <div class="_ax_events-tickets _ax_events-wrapper">
                <div class=" _ax_events-box _ax_events-box-50">
                    <label>Ticket price $</label>
                    <input type="number" id="ax_price" name="ax_price" value="<?= $price ? $price : 100 ?>">
                </div>
            </div>
            <button class="xbutton">btn</button>
        </div>


        <script>
            const submit = document.querySelector('.xbutton')
            submit.addEventListener('click', (e) => {
                e.preventDefault()
                const data = {
                    'action': 'ax_create_pdf',
                }

                jQuery.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    data: data,
                    type: 'POST',
                    success: function(data) {
                        console.log(data);
                    }
                });
            })
        </script>
<?php
    }

    function events_save_postdata($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $from_date = sanitize_text_field($_POST['ax_from_date']);
        $to_date = sanitize_text_field($_POST['ax_to_date']);
        $from_time = sanitize_text_field($_POST['ax_from_time']);
        $to_time = sanitize_text_field($_POST['ax_to_time']);
        $country = sanitize_text_field($_POST['ax_country']);
        $location =  sanitize_text_field($_POST['ax_location']);
        $max_tickets = sanitize_text_field($_POST['ax_max_tickets']);
        $price = sanitize_text_field($_POST['ax_price']);

        update_post_meta($post_id, 'ax_price', $price);
        update_post_meta($post_id, 'ax_max_tickets', $max_tickets);
        update_post_meta($post_id, 'ax_country', $country);
        update_post_meta($post_id, 'ax_location', $location);
        update_post_meta($post_id, 'ax_from_date', $from_date);
        update_post_meta($post_id, 'ax_to_date', $to_date);
        update_post_meta($post_id, 'ax_from_time', $from_time);
        update_post_meta($post_id, 'ax_to_time', $to_time);

        //== start to second ==//
        update_post_meta($post_id, 'ax_time_start', strtotime($from_date));
        //== end to second ==//
    }
}
