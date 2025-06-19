<?php
get_header();

// Obtener el orden de las secciones
$secciones_orden = carbon_get_the_post_meta('inicio_secciones');

// Orden por defecto si no hay configuración
if (empty($secciones_orden)) {
    $secciones_orden = [
        ['seccion' => 'hero'],
        ['seccion' => 'info'],
        ['seccion' => 'beneficios'],
        ['seccion' => 'video'],
        ['seccion' => 'expositor'],
        ['seccion' => 'webinars'],
        ['seccion' => 'carreras']
    ];
}
?>

<div class="main-wrapper">
            <?php
                // Renderizar cada sección en el orden especificado
                foreach ($secciones_orden as $seccion) {
                    switch ($seccion['seccion']) {
                        case 'Cabecera':
                            get_template_part('public/pages/inicio/inicio', 'hero', []);
                            break;
                            
                        case 'Información del evento':
                            if (elCampo('in-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'info', []);
                                echo '<div class="padding-bottom padding-xxlarge"></div>';
                            }
                            break;
                            
                        case 'Beneficios':
                            if (elCampo('be-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'beneficio', []);
                                echo '<div class="padding-bottom padding-xxlarge"></div>';
                            }
                            break;
                            
                        case 'Video':
                            if (elCampo('vi-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'video', []);
                                echo '<div class="padding-bottom padding-xxlarge"></div>';
                            }
                            break;
                            
                        case 'Expositor':
                            if (elCampo('ex-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'expositor', []);
                                echo '<div class="padding-bottom padding-xxlarge"></div>';
                            }
                            break;
                            
                        case 'Webinars':
                            if (elCampo('we-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'webinar', []);
                            }
                            break;
                            
                        case 'Carreras':
                            if (elCampo('ca-show') == false) {
                                get_template_part('public/pages/inicio/inicio', 'carreras', []);
                            }
                            break;
                    }
                }
                ?>
        <div class="padding-bottom padding-xxlarge">
        </div>
</div>

<?php
get_footer();
