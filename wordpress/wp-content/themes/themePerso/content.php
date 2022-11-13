<p>je suis le content</p>
<?php

print_r($_SESSION);

if (!isset($_SESSION['email'])) {
    echo '<form method="POST">

  <input placeholder="Nom.." type="text" name="nom">

  <input placeholder="Email.." type="email" name="email">

  <button type="submit">Envoyer</button>
  </form>';
  

    if (isset($_POST['nom']) && isset($_POST['email'])) {
        $nomm = $_POST['nom'];
        $emaill = $_POST['email'];

        $rio = array("id" => "", "email" => "$emaill", "name" => "$nomm");
        global $wpdb;
        $wpdb->insert("user", $rio);

        session_start();
        $_SESSION['email'] = $emaill;
    }
}

?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="blog-post">
            <h2 class="blog-post-title"><?php the_title(); ?></h2>
            <p class="blog-post-meta"><?php the_time('d/m/Y'); ?> par <?php the_author(); ?></p>
            <?php (is_singular()) ? the_content() : the_excerpt(); ?>
            <?php if (!is_singular()) : ?>
                <p><a href="<?php the_permalink(); ?>" class="btn btn-primary">Lire la suite</a></p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
    <div id="pagination">
        <?php echo paginate_links(); ?>
    </div>
<?php endif; ?>

<?php

if(isset($_POST["question"]) && $_POST["question"] != ""){
        global $wpdb;
        $wpdb->insert("question", array("id" => "","question" => $_POST["question"]));
}