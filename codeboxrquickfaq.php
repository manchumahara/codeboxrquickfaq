<?php
/*
  Plugin Name: Codeboxr Quick FAQ
  Plugin URI: http://codeboxr.com/product/quick-faq-manager-for-wordpress
  Description: Flexible FAQ Display for wordpress using shortcode & custom post type
  Version: 1.2.1
  Author: Codeboxr
  Author URI: info@codeboxr.com
 */

// prefix for this plugin
// function name codeboxrquickfaq -var codeboxrquickfaq_
require_once(plugin_dir_path( __FILE__ ). "codeboxrquickfaq_settings.php");
define('CODEBOXR_QUICKFAQ_BASENAME', plugin_basename(__FILE__));
define('CBQUICKFAQ_VERSION', '1.2.1');

if ( !function_exists('codeboxrquickfaq_admin_init')):
    /**
     * codeboxrquickfaq_admin_init function
     * init settings
     */
    function codeboxrquickfaq_admin_init() {
       // var_dump('i am here ');exit;
        $sections = array(
            array(
                'id'    => 'codeboxrquickfaq_global_settings',
                'title' => __( 'Codeboxr Quick Faq', 'codeboxrquickfaq' )
            ),
        );
        $fields = array(  'codeboxrquickfaq_global_settings' => array());

        $settings_api = new codeboxrquickfaq_settings();
        $settings_api->set_sections( $sections );
        $settings_api->set_fields( $fields );
        //initialize them
        $settings_api->admin_init();
    }
endif;// end of function codeboxrquickfaq_admin_init
/**
 * Class codeboxr_quick_faq
 */
class codeboxr_quick_faq {

    /**
     * __construct function
     */
    public function __construct() {

        add_action('admin_init','codeboxrquickfaq_admin_init');
        add_action('init', array($this, 'codeboxrquickfaq_create_custom_type'));
        //add_action('init', array($this, 'cbfaq_taxonomy'));
        add_action('wp_enqueue_scripts', array($this, 'add_codeboxrquickfaq_stylesheet'));
        add_shortcode('codeboxrquickfaq', array($this, 'codeboxrquickfaq_single'));
        add_shortcode('codeboxrquickfaqwrap', array($this, 'codeboxrquickfaq_wrap'));
        add_shortcode('codeboxrquickfaqpost', array($this, 'codeboxrquickfaq_list_custom_posts'));
        add_filter('plugin_action_links_' . CODEBOXR_QUICKFAQ_BASENAME, array($this, 'codeboxrquickfaq_plugin_support'));
        add_action( 'admin_menu', array( $this, 'add_codeboxrquickfaq_admin_menu' ) );
    }

    /**
     * add option page
     */
    function add_codeboxrquickfaq_admin_menu(){
        add_options_page('Quick Faq', 'Quick Faq', 'administrator','codeboxrquickfaq', array($this, 'show_codeboxrquickfaq_page'));
    }
    /**
     * display option page
     *
     */
    function  show_codeboxrquickfaq_page(){

        $sections = array(
            array(
                'id'    => 'codeboxrquickfaq_global_settings',
                'title' => __( 'Global Settings', 'codeboxrquickfaq' )
            )
        );

        $fields = array(
            'codeboxrquickfaq_global_settings' => array(

                array(
                    'name'      => 'codeboxrquickfaq_enableposttype',
                    'label'     => __( 'Enable Custom Post Type ', 'codeboxrquickfaq' ),
                    'desc'      => __( 'Enable custom post type quick faq ','codeboxrquickfaq' ),
                    'type'      => 'checkbox',
                    'default'   => '1',

                ),
            ),
            'wedevs_advanced' => array(

            ),
        );

        $settings_api = new codeboxrquickfaq_settings();

        echo '<div class="wrap columns-2">';

        $output = '<div class="icon32 icon32_cbrp_admin icon32-cbrp-edit" id="icon32-cbrp-edit"><br></div>';
        $output .= '<h2>' . __( 'Codeboxr Quick Faq', 'codeboxrquickfaq' ) . '</h2>';
        $output .= '<div class="codeboxrquickfaq_wrapper metabox-holder has-right-sidebar" id="poststuff">';

        if(isset($_GET['settings-updated'])):
            $output .= '<div class="messages status">' . __( 'Setting has been saved successfully', 'codeboxrquickfaq' ) . '</div>';
        endif;

        echo $output;

        echo '<div id="post-body"><div id="post-body-content">';

        $settings_api->set_sections( $sections );
        $settings_api->set_fields( $fields );

        //initialize them
        $settings_api->admin_init();
        $settings_api->show_navigation();
        $settings_api->show_forms();
        echo '</div></div>';
        ?>
        <div id="side-info-column" class="inner-sidebar">

            <div class="postbox">
                <h3>Plugin Info</h3>

                <div class="inside">
                    <p>Name : Codeboxr Quick Faq <?php echo 'v' . CBQUICKFAQ_VERSION; ?></p>

                    <p>Author : Codeboxr Team</p>

                    <p>Plugin URL :
                        <a href="http://codeboxr.com/product/quick-faq-manager-for-wordpress" target="_blank">Codeboxr.com</a>
                    </p>

                    <p>Email : <a href="mailto:info@codeboxr.com" target="_blank">info@codeboxr.com</a></p>

                    <p>Contact : <a href="http://codeboxr.com/contact-us.html" target="_blank">Contact Us</a></p>
                </div>
            </div>
            <div class="postbox">
                <h3>Help & Supports</h3>
                <div class="inside">
                    <p>Support: <a href="http://codeboxr.com/contact-us.html" target="_blank">Contact Us</a></p>
                    <p><i class="icon-envelope"></i> <a href="mailto:info@codeboxr.com">info@codeboxr.com</a></p>
                    <p><i class="icon-phone"></i> <a href="tel:008801717308615">+8801717308615</a> (CEO: Sabuj Kundu)</p>
                    <!--p><i class="icon-building"></i>  Address: Flat-11B1, 252 Elephant Road (Near Kataban Crossing), Dhaka 1205, Bangladesh.<br-->
                </div>
            </div>
            <div class="postbox">
                <h3>Codeboxr Updates</h3>
                <div class="inside">
                    <?php
                    include_once(ABSPATH . WPINC . '/feed.php');
                    if(function_exists('fetch_feed')) {
                        $feed = fetch_feed('http://codeboxr.com/feed');
                        // $feed = fetch_feed('http://feeds.feedburner.com/codeboxr'); // this is the external website's RSS feed URL
                        if (!is_wp_error($feed)) : $feed->init();
                            $feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                            $feed->handle_content_type(); // this double-checks the encoding type
                            $feed->set_cache_duration(21600); // 21,600 seconds is six hours
                            $limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
                            $items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

                            $blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here
                            echo '<ul>';
                            foreach ($blocks as $block) {
                                $url = $block->get_permalink();
                                echo '<li><a target="_blank" href="'.$url.'">';
                                echo '<strong>'.$block->get_title().'</strong></a>';
                                echo '</li>';

                            }//end foreach
                            echo '</ul>';
                        endif;
                    }
                    ?>
                </div>
            </div>

            <div class="postbox">
                <h3>Codeboxr on facebook</h3>
                <div class="inside">
                    <iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:260px; height:258px;" src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fcodeboxr&amp;width=260&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=558248797526834"></iframe>
                </div>
            </div>
        </div>
        <?php
        echo '</div>'; //end cborderbycouponforwoocommerce metabox-holder has-right-sidebar
        echo '</div>';
        //echo $settings;
    }
    /**
     * this function is for adding a custom post type named CB quick faq
     */
    function codeboxrquickfaq_create_custom_type() {

        $cbqfaq_settings = get_option('codeboxrquickfaq_global_settings');
        //var_dump($cbqfaq_settings);exit;
        if(isset( $cbqfaq_settings["codeboxrquickfaq_enableposttype"]) && $cbqfaq_settings["codeboxrquickfaq_enableposttype"] == "on"){
            // register custom post type
            register_post_type('codeboxrquickfaqs',
                array(
                    'labels' => array(
                        'name' => __('CB Quick Faq'),
                        'singular_name' => __('codeboxrquickfaqs')
                    ),
                    //'taxonomies' => array('category'),
                    'public' => true,
                    'has_archive' => true,
                )
            );
            // register the category
            register_taxonomy(
                'codeboxrquickfaqcategory',
                'codeboxrquickfaqs',
                array(
                    'hierarchical' => true,
                    'label' => 'CB Faq Catagory',
                    'query_var' => true,
                    'rewrite' => array('slug' => 'codeboxrquickfaqcategory')
                )
            );
        }// end of if custom post enabled

    }// end of function



    /**
     *
     * @global  $paged
     * @param
     * @return
     * this function query for all all posts under custom post type cbquickfaqitem
     * apply shortcode to the posts ...
     * take catagory id numbers order and custom data allclose as parameter
     * return shortcoded title and content
     */
    function codeboxrquickfaq_list_custom_posts($atts) {

        $cbquickfaq_list_options = shortcode_atts(array( 'faqborder' =>"#ffffff",'color'=>'#000000','showcredit'  => '1','limit' => -1, 'type' => 'codeboxrquickfaqs', 'allfaqclose' => 1, 'order' => 'DSC', 'orderby' => 'ID', 'category' => '','category_ids' => ''), $atts);

        global $paged;
       // if  cat name given
        if($cbquickfaq_list_options['category'] != ''){

            $faqs = new WP_Query(array(
                'posts_per_page' => (int)$cbquickfaq_list_options['limit'],
                'post_type'      => $cbquickfaq_list_options['type'],
                'order'          => $cbquickfaq_list_options['order'],
                'orderby'        => $cbquickfaq_list_options['orderby'],

                 'tax_query'        => array(
                     array(
                         'taxonomy' => 'codeboxrquickfaqcategory',
                         'field'    => 'name',
                         'terms'    => $cbquickfaq_list_options['category']
                     )
                 ),
                'paged' => $paged));

        }
        // if cat ids given
       else if($cbquickfaq_list_options['category_ids'] != '' ){

           $faqs = new WP_Query(array(

               'posts_per_page' => $cbquickfaq_list_options['limit'],
               'post_type'      => $cbquickfaq_list_options['type'],
               'order'          => $cbquickfaq_list_options['order'],
               'orderby'        => $cbquickfaq_list_options['orderby'],

                'tax_query' => array(
                    array(
                        'taxonomy'  => 'codeboxrquickfaqcategory',
                        'field'     => 'id',
                        'terms'     => explode(",", $cbquickfaq_list_options['category_ids'] )
                    )
                ),
               'paged' => $paged));
       }
       // if all posts
        else{

            $faqs = new WP_Query(array(

                'posts_per_page' => $cbquickfaq_list_options['limit'],
                'post_type'      => $cbquickfaq_list_options['type'],
                'order'          => $cbquickfaq_list_options['order'],
                'orderby'        => $cbquickfaq_list_options['orderby'],
                'paged' => $paged));
        }

        $cbfaqlist = ' ';

        while ($faqs->have_posts()) {

            $faqs->the_post();

            $cbfaqlist .= '<div data-postid = "' .get_the_ID(). '" style = "margin-bottom:5px;padding:5px;border-radius:5px;border:1px solid '.$cbquickfaq_list_options['faqborder'].'" class="cbquickfaqsinglewrapper cbquickfaqsinglewrapper_'.get_the_ID().'" data-reference="1">

                            <h3 class="cbquickfaqheader cbquickfaqheader_'.get_the_ID().'" data-postid = "' .get_the_ID(). '" >' . get_the_title() . '</h3>'

                            .'<div class="cbquickfaqcontent cbquickfaqcontent_'.get_the_ID().'" data-postid = "' .get_the_ID(). '" >' . get_the_content() . '</div>

                          </div>';
        }

        wp_reset_query();

        if($cbquickfaq_list_options[ 'showcredit' ] == '1'){

            $cbquickfaq_creditmsg = '<a href="http://codeboxr.com/product/quick-faq-manager-for-wordpress" target="_blank" >Quick FAQ by Codeboxr</a>';

        }else{

            $cbquickfaq_creditmsg = '';
        }
        return         '<div class="cbquickfaqwrap cbquickfaqwrap_'.get_the_ID().'"  data-postid = "' .get_the_ID(). '"  data-allclose="' . $cbquickfaq_list_options['allfaqclose'] . '" style="color:'.$cbquickfaq_list_options[ 'color' ].'" data-show-credit = "'.$cbquickfaq_list_options[ 'showcredit' ].'" >'

                        . $cbfaqlist

                        .'<span class ="codeboxrquickfaqcredit">'.$cbquickfaq_creditmsg.'</span>

                        </div>';
    }// end of function

    /**
     * this function apply shortcode to any posts which has a format like
     * [codeboxrquickfaqwrap]


      [codeboxrquickfaq title="Here is an example Question4"]Here is the example answer4. [/codeboxrquickfaq]
      [codeboxrquickfaq title="Here is an example Question5"]Here is the example answer5. [/codeboxrquickfaq]
      [codeboxrquickfaq title="Here is an example Question6"]Here is the example answer6. [/codeboxrquickfaq]


      [/codeboxrquickfaqwrap]
     * give title a h3 tag and content a inner div tag and cbfaq wrap is a outer div
     *
     */
    function codeboxrquickfaq_single($atts, $content = null) {

       $cbquickfaq_options =  shortcode_atts(
                        array(
                            'title'         => 'Click To Open',
                            'faqborder'     =>"#ffffff",
                            'titlecolor'     =>""
                        ), $atts);

        if($cbquickfaq_options['titlecolor'] !=''){

            $titlecolor_faq = 'color:'.$cbquickfaq_options['titlecolor'];
        }
        else{

            $titlecolor_faq = '';
        }
        return '<div data-postid = "' .get_the_ID(). '" style = "padding:5px;border-radius:5px;border:1px solid '.$cbquickfaq_options['faqborder'].'" class="cbquickfaqsinglewrapper cbquickfaqsinglewrapper_'.get_the_ID().'" data-reference="1">

                    <h3 style = "'.$titlecolor_faq.'" class="cbquickfaqheader cbquickfaqheader_'.get_the_ID().'" data-postid = "' .get_the_ID(). '" id="cbquickfaqheader_'.get_the_ID().'">' . $cbquickfaq_options['title' ] . '</h3>

                    <div data-postid = "' .get_the_ID(). '" class="cbquickfaqcontent cbquickfaqcontent_'.get_the_ID().'" data-reference="1">' . $content . '</div>

               </div>';
    }

    /**
     *
     * the function below add a wrappeer div to the shortcoded content of previous function
     */
    function codeboxrquickfaq_wrap($atts, $content = null) {

        $cbquickfaq_wrap_options = shortcode_atts(

                        array(
                            'allfaqclose' => '1',
                            'showcredit'  => '1',
                            'color'       => '#000000'

                        ), $atts);
        //credit msg
        if($cbquickfaq_wrap_options[ 'showcredit' ] == '1'){

            $cbquickfaq_creditmsg = '<a href="http://codeboxr.com/product/quick-faq-manager-for-wordpress" target="_blank" >Quick FAQ by Codeboxr</a>';

        }else{

            $cbquickfaq_creditmsg = '';
        }
        return '<div style="color:'.$cbquickfaq_wrap_options[ 'color' ].'" data-show-credit = "'.$cbquickfaq_wrap_options[ 'showcredit' ].'" data-allclose = "' . $cbquickfaq_wrap_options[ 'allfaqclose' ] . '" class = "cbquickfaqwrap cbquickfaqwrap_'.get_the_ID().'" data-postid = "' .get_the_ID(). '">'

                    . do_shortcode($content) .

                    '<span class ="codeboxrquickfaqcredit">'.$cbquickfaq_creditmsg.'</span>

                </div>';
    }
/**
 * this function adds js and css filed
 */
    function add_codeboxrquickfaq_stylesheet() {

        wp_register_style('cbquickfaq-style', plugins_url('codeboxrquickfaq.css', __FILE__));
        wp_enqueue_style('cbquickfaq-style');
        wp_register_script('cbquickfaq-custom-js', plugins_url('codeboxrquickfaq.js', __FILE__), array('jquery-ui-accordion'), '', true);
        wp_enqueue_script('cbquickfaq-custom-js');
    }
/**
 *
 * this function adds support link to plugin
 */
    function codeboxrquickfaq_plugin_support($links) {

        array_unshift(
                $links,
                sprintf('<a href="http://codeboxr.com/product/quick-faq-manager-for-wordpress">Tutorial</a>')
        );
        array_unshift(
                $links,
                sprintf('<a href="http://codeboxr.com/contact-us.html/">Support</a>')
        );
        array_unshift(
                $links,
                sprintf('<a href="options-general.php?page=codeboxrquickfaq">Settings</a>')
        );

        return $links;
    }// end of function codeboxrquickfaq_plugin_support

}// end of class
// create an instance of the class
new codeboxr_quick_faq();







