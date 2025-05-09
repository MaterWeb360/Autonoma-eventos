<?php
$logo = globalCampo('g-logotipo-blanco');
$fondo = fileCampo('he-img');
$fondo_mb = fileCampo('he-img-mobile');

$tag = elCampo('he-etiqueta');
$titulo = resaltarTexto(nl2br(elCampo('he-titulo')), 'color_primario');
$subtitulo = elCampo('he-subtitulo');

//hero imagenes
$img_tipo_evento = fileCampo('he-play-img');
$img_titular = fileCampo('he-titulo-img');
$img_subtitular = fileCampo('he-subtitulo-img');

?>

<div class="hero fondo_primario hero_wordpress">
    <div class="nav">
        <div class="padding-global">
            <div class="container-large">
                <div class="padding-section-xsmall">
                    <img src="<?= $logo ?>" loading="lazy" alt=""
                        class="logo-img">
                </div>
            </div>
        </div>
    </div>
    <div class="padding-global">
        <div class="container-large">
            <div id="form-hero" class="hero_wrapper">
                <img src="<?= $fondo ?>" loading="lazy"
                    alt="" class="hero_bg-img">
                <img src="<?= $fondo_mb ?>" loading="lazy" alt=""
                    class="hero_bg-img is-mobile">
                <div class="hero_content-wrp text-color-white color_terciario">
                <?php if (!empty($img_tipo_evento)) : ?>
                    <div class="hero_tag text-color-black">
                        <img src="<?= $img_tipo_evento; ?>" loading="lazy" alt=""
                            class="icon-1x1-medium">
                        <div class="hero_tag-title"><?= $tag ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($img_titular)) : ?>
                    <div class="hero_quote ">
                        <img src="<?= $img_titular; ?>" loading="lazy" alt="" class="quote-img">
                        <h1 class="heading-2"><?= $titulo ?></h1>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($img_subtitular)) : ?>
                    <div class="hero_details">
                        <img src="<?= $img_subtitular; ?>" loading="lazy" alt=""
                            class="icon-1x1-medium">
                        <div><?= $subtitulo ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="hero_form">
                    <div class="form w-form ">
                        <div class="form_header fondo_secundario">
                            <div>¡INSCRÍBETE AHORA!</div>
                        </div>
                        <?php get_template_part('public/pages/inicio/inicio', 'formulario', []); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>