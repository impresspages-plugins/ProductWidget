<?php if ($image) { ?>
<div class="_images">
    <a class="_image" rel="lightbox" href="<?php echo escAttr($imageBig) ?>" title="<?php echo escAttr($title) ?>" data-description="">
        <img src="<?php echo escAttr($image) ?>" alt="<?php echo escAttr($title) ?>" />
    </a>
    <?php if (!empty($images)) { ?>
        <div class="_thumbs">
            <?php foreach ($images as $key => $image) { ?>
                <a class="_thumb" rel="lightbox" href="<?php echo escAttr($imagesBig[$key]) ?>" title="<?php echo escAttr($title) ?>" data-description="">
                    <img src="<?php echo escAttr($image) ?>" alt="<?php echo escAttr($title) ?>" />
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php } ?>
<div class="_info">
    <h3 class="_title"><?php echo esc($title) ?></h3>
    <div class="_description">
        <?php echo $description ?>
        <p><span class="button"><?php _e('Buy', 'SimpleProduct') ?></span></p>
    </div>
</div>
