<?php
// Obtiene los campos requeridos de opciones generales y las convierte en un array, y la smuestra en js.
$campos = carbon_get_theme_option('g_campos_requeridos_form');

$camposRequeridos = [];

if ($campos && is_array($campos)) {
    foreach ($campos as $campo) {
        if (!empty($campo['nombre_campo'])) {
            $key = esc_js($campo['nombre_campo']);
            $camposRequeridos[$key] = "";
        }
    }
}
?>

<script>
  var camposRequeridos = <?php echo json_encode($camposRequeridos, JSON_UNESCAPED_UNICODE); ?>;
  console.log("Campos Requeridos cargados dinámicamente:", camposRequeridos);
</script>


<script src="<?php echo get_template_directory_uri(); ?>/public/assets/js/envio.js"></script>