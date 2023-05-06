<?php function card($title) { ?>
    <div class="card mb-2">
        <div class="card-body">
            <h3 class="text-center"><?= $title ?></h3>
        </div>
    </div>
<?php } ?>

<?php function header($res) { ?>
    <head>
        <?php
            foreach ($item as $res) {
                echo $res;
            }
        ?>
    </head>
<?php } ?>


<!-- header([
    '<link />',
    '<link />',
    '<link />',
    '<link />',
    '<link />',
]) -->