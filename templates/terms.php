<?php $a = function ($terms) use (&$a) { ?>
    <ul>
        <?php foreach ($terms as $term): ?>
            <li><?php echo $term->name; ?>
                <?php if ($term->children): ?>
                    <?php $a($term->children); ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php } ?>
<?php $a($terms); ?>

