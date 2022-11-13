<?php

/* Plugin Name: Plugin-Dofus
Plugin URI: http://localhost/wordpress/wp-content/plugins/Dofus/
Description: Formulaire Dofus
Author: Charlélie
Version: 1.0.0 */

function theme_options_panel()
{

    add_menu_page('Theme page title', 'ADMIN_CRUD', 'manage_options', 'theme-options', 'wps_theme_func');
    add_submenu_page('theme-options', 'Settings create', 'Create', 'manage_options', 'theme-op-settings-create', 'wps_theme_func_create');
    add_submenu_page('theme-options', 'Settings read', 'Read', 'manage_options', 'theme-op-settings-read', 'wps_theme_func_read');
    add_submenu_page('theme-options', 'Settings update', 'Update', 'manage_options', 'theme-op-settings-update', 'wps_theme_func_update');
    add_submenu_page('theme-options', 'Settings delete', 'Delete', 'manage_options', 'theme-op-settings-delete', 'wps_theme_func_delete');
}
add_action('admin_menu', 'theme_options_panel');

function wps_theme_func()
{
    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
          <h2>Hello World</h2></div>';
}
function wps_theme_func_create()
{
    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
          <h2>Create</h2></div>
          <form method="POST">
          <input type="text" name="name" placeholder="name">
          <input type="email" name="email" placeholder="Email">
          <button type="submit">Envoyer</button>';

    if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['email']) && $_POST['email'] != "") {
        $name = $_POST['name'];
        $email = $_POST['email'];

        global $wpdb;
        $wpdb->insert("user", array("id" => "", "email" => $email, "name" => $name));
    }
}
function wps_theme_func_read()
{
    add_query_arg("id", "0", "http://localhost/wordpress/wordpress/wp-admin/admin.php?page=theme-op-settings-update");
    add_query_arg("id", "0", "http://localhost/wordpress/wordpress/wp-admin/admin.php?page=theme-op-settings-delete");


    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
          <h2>Read</h2></div>';

    global $wpdb;
    $users = $wpdb->get_results("SELECT * FROM user", ARRAY_A);
    echo '<table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">id</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Update</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>';
    foreach ($users as $user) {
        echo '<tr>
            <th scope="row">' . $user["id"] . '</th>
            <td>' . $user["name"] . '</td>
            <td>' . $user["email"] . '</td>
            <td><a href="http://localhost/wordpress/wordpress/wp-admin/admin.php?page=theme-op-settings-update&id=' . $user["id"] . '"><button>Update</button></a></td>
            <td><a href="http://localhost/wordpress/wordpress/wp-admin/admin.php?page=theme-op-settings-delete&id=' . $user["id"] . '"><button>Delete</button></a></td>
          </tr>';
    }
    echo ' </tbody>
          </table>';
}
function wps_theme_func_update()
{
    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
    <h2>Update</h2></div>';
    if (isset($_GET["id"]) && $_GET['id'] != "") {
        global $wpdb;
        $users = $wpdb->get_results("SELECT * FROM user WHERE id = " . $_GET['id'] . "", ARRAY_A);
        echo '
    <form method="POST">
          <p>id : ' . $_GET["id"] . '</p>
          <input type="text" name="name" value="' . $users[0]["name"] . '">
          <input type="email" name="email" value="' . $users[0]["email"] . '">
          <button type="submit">Envoyer</button>';

        if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['email']) && $_POST['email'] != "") {
            $name = $_POST['name'];
            $email = $_POST['email'];

            global $wpdb;
            $wpdb->update("user", array("email" => $email, "name" => $name), array("id" => $_GET["id"]));
            header("Location : http://localhost/wordpress/wordpress/wp-admin/admin.php?page=theme-op-settings-read");
            exit();
        }
    }
}
function wps_theme_func_delete()
{
    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
    <h2>Delete</h2></div>';

    if (isset($_GET["id"]) && $_GET['id'] != "") {
        echo '
        <fieldset>
    <legend>Etes vous sur de vouloir supprimer l\'utilisateur '.$_GET["id"].' ?</legend>
        <form method="POST">
    <div>
      <input type="radio" id="oui" name="delete" value="oui"
             checked>
      <label for="huey">Oui</label>
    </div>

    <div>
      <input type="radio" id="non" name="delete" value="non">
      <label for="dewey">Non</label>
    </div>
    <button type="submit">Valider</button>
    </form>
        ';

    if(isset($_POST["delete"]) && $_POST["delete"] != ""){
        if($_POST["delete"] == "oui"){
            global $wpdb;
            $wpdb->delete("user",array("id"=> $_GET["id"]));
        }
    }
    }

}

// Creating the widget
class wpb_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'wpb_widget',

            // Widget name will appear in UI
            __('WPBeginner Widget', 'wpb_widget_domain'),

            // Widget description
            array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        echo __('Choisis frero', 'wpb_widget_domain');
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
        // Widget admin form
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    // Class wpb_widget ends here
}

// Register and load the widget

function wpb_load_widget()
{
    register_widget('wpb_widget');
}
add_action('widgets_init', 'wpb_load_widget');

function delete()
{

    global $wpdb;
    $sql = "DROP TABLE `questionnaire`";
    $wpdb->query($sql);
    delete_option('my_plugin_db_version');

    global $wpdb;
    $sql = "DROP TABLE `question`";
    $wpdb->query($sql);
    delete_option('my_plugin_db_version');

    global $wpdb;
    $sql = "DROP TABLE `reponse`";
    $wpdb->query($sql);
    delete_option('my_plugin_db_version');

    global $wpdb;
    $sql = "DROP TABLE `reponse_check`";
    $wpdb->query($sql);
    delete_option('my_plugin_db_version');

    global $wpdb;
    $sql = "DROP TABLE `question_check`";
    $wpdb->query($sql);
    delete_option('my_plugin_db_version');
}

register_uninstall_hook(__FILE__, "delete");

function create()
{
    global $wpdb;
    $sql = "CREATE TABLE `user` (   
       id MEDIUMINT NOT NULL AUTO_INCREMENT,   
         email CHAR(255) NOT NULL,   
         name CHAR(255) NOT NULL,   
         PRIMARY KEY (id)   
    );";
    $wpdb->query($sql);

    global $wpdb;
    $sql = "CREATE TABLE `questionnaire` (   
       id MEDIUMINT NOT NULL AUTO_INCREMENT,   
         name CHAR(255) NOT NULL,   
         PRIMARY KEY (id)   
    );";
    $wpdb->query($sql);

    global $wpdb;
    $sql = "CREATE TABLE `question` (
       id MEDIUMINT NOT NULL AUTO_INCREMENT,
        question CHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );";
    $wpdb->query($sql);

    global $wpdb;
    $sql = "CREATE TABLE `reponse` (   
       id MEDIUMINT NOT NULL AUTO_INCREMENT,   
       id_question int(30) NOT NULL,   
        reponse CHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );";
    $wpdb->query($sql);

    global $wpdb;
    $sql = "CREATE TABLE `question_check` (
   id MEDIUMINT NOT NULL AUTO_INCREMENT,
    date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);";

    $wpdb->query($sql);
    global $wpdb;
    $sql = "CREATE TABLE `reponse_check` (
        id MEDIUMINT NOT NULL AUTO_INCREMENT,
        date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
);";
    $wpdb->query($sql);
}

register_activation_hook(__FILE__, "create");


add_action('wp_loaded', 'number_click');

function number_click()
{

    if (isset($_POST['reponse'])) {
        global $wpdb;
        $wpdb->insert("reponse_check", array("id" => ""));
    }

    if (isset($_POST['question'])) {
        global $wpdb;
        $wpdb->insert("question_check", array("id" => ""));
    }
}
