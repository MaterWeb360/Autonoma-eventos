<?php
if( is_page() && !is_page('gracias') ) {  
    $botones = carbon_get_post_meta(get_the_ID(), 'bf-lista');
    $textins = carbon_get_post_meta(get_the_ID(), 'bf-ins');
?>
<div class="wp_flotantes">
    <?php 
        foreach ($botones as $key => $boton) { 
            if($boton['bf-imagen']){ 
            $url = isset($boton['bf-url']) ? esc_url($boton['bf-url']) : '#';
            $img_id = isset($boton['bf-imagen']) ? $boton['bf-imagen'] : '';
            $img_url = $img_id ? wp_get_attachment_url($img_id) : '';
    ?>
            <a href="<?= $url ?>" target="_blank" class="wp_flotantes-link">
                <img src="<?= esc_url($img_url) ?>" alt="" class="wp_flotantes-icon">
            </a>
    <?php }} ?>
    <a href="#form-hero" class="btn is-inscription w-button fondo_secundario"><?= $textins; ?></a>
</div>
<?php } ?>