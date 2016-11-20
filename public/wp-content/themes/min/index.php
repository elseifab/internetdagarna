<html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?= bloginfo('charset') ?>" />
        <title>Minimal | <?= the_title() ?></title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"></link>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class() ?>>

        <div class="jumbotron" style="background: url('<?=get_stylesheet_directory_uri()?>/img/bg.jpeg') no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
            <div class="container">
                <h1>WordCamp<br/>Internetdagarna</h1>
                <p>Automatiserad hantering för WordPress-projekt</p>
                <p><a class="btn btn-primary btn-lg" href="https://github.com/elseifab/internetdagarna" role="button">Github &raquo;</a></p>
            </div>
        </div>

        <div class="container">

            <div class="col-xs-12">

                <p><a class="btn btn-default" href="/"><i class="glyphicon glyphicon-home"></i> STARTSIDAN</a></p>

                <?php

                if(is_single()){
                    the_post();
                    ?>
                    <div class="well">
                        <h2><?=the_title()?></h2>
                        <p><?=the_content()?></p>
                    </div>
                    <?php
                }

                $posts = get_posts(['posts_per_page'=>-1]);
                if($posts) {
                    echo "<h3>Inlägg</h3>";
                    echo "<ul class=\"list-group\">";
                    foreach ($posts as $post) {
                        ?>
                            <li class="list-group-item">
                                <a href="<?=get_the_permalink($post->ID)?>"><?=get_the_title($post->ID)?></a>
                            </li>
                        <?php
                    }
                    echo "</ul>";
                }
                ?>

            </div>
        </div>

        <?php wp_footer() ?>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" />
    </body>
</html>
<?php
