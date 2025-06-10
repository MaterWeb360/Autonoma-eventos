<?php
$api_envio = carbon_get_post_meta(get_the_ID(), 'url_api');
$campos = carbon_get_post_meta(get_the_ID(), 'complex_form_2');
$boton = carbon_get_post_meta(get_the_ID(), 'boton');
?>

<form id="formularioAutonoma" name="email-form" data-name="Email Form" method="POST"
    class="form_content formWP" data-wf-page-id="67a1021497306af2adfd2a68"
    data-wf-element-id="a1254f40-a5d5-2265-c737-38cb40f3ca3c" action="<?= $api_envio ?>">

    <div class="form__input-wrapper">

    <?php

        //var_dump($campos);
        foreach ($campos as $campo) {
            
            switch ($campo['campos']) {
                case '1': //campo texto
                    $plaholder = $campo['campo_placeholder'];
                    $tipo = $campo['campo_tipo'];
                    $name = $campo['campo_name'];
                    $size = $campo['campo_tamano'];
                    echo '<div style="display: flex;flex-direction: column;width: '.$size.'">';
                    echo '<input name="'.$name.'" placeholder="'. $plaholder.'" type="'.$tipo.'" class="form__input-select-wrapper w-input" >';
                    echo '</div>';
                    break;
                case '2': //checkbox
                    $placeholder = $campo['campo_placeholder'];
                    $resaltado = $campo['check_resaltado'];
                    $enlace = $campo['check_enlace'];
                    $name = $campo['check_name'];
                    $required = $campo['check_required'] ? 'required' : '';
                    $texto_resaltado = '<a class="color_primario" href="' . esc_url($enlace) . '" target="_blank">' . esc_html($resaltado) . '</a>';
                    $placeholder_con_enlace = str_replace($resaltado, $texto_resaltado, $placeholder);
                    echo '<label style="font-size: 14px">';
                    echo '    <input type="checkbox" name="' . esc_attr($name) . '" value="1" ' . $required . ' style="margin-right: 5px">';
                    echo      $placeholder_con_enlace;
                    echo '</label>';                    
                    break;
                case '3': // campo select
                    //var_dump($campo);
                    $size = $campo['campo_tamano'];
                    $s_place = $campo['campo_placeholder'];
                    $bucleOps = $campo['campo_select'];
                    $n_name = $campo['campo_name_option'];
                    $c_name = $campo['campo_name'];

                    //1er nivel
                    echo '<div class="form__input-select-wrapper" style="width: '.$size.'" data-nivel="1" data-tipo="unico">';
                        echo '<select name="" data-name="'.$n_name.'" class="form__input-select w-select">';
                        echo '<option>'.$s_place.'</option>';
                        foreach ($bucleOps as $option) {
                            $value = $option['campo_select_value'];
                            $label = $option['campo_select_placeholder'];
                            echo '<option value="'.$value.'">'.$label.'</option>';
                        }
                        echo '</select>';
                        if($c_name){
                        echo '<input type="hidden" data-name="'.$c_name.'" value="">';
                        }
                    echo '</div>';
                    
                    //2do nivel
                    echo '<div class="form__selects oculto" style="width: 100%">';
                    foreach ($bucleOps as $option) {
                        $codForm = $option['campo_select1_codform'];//codform
                        $parent = $option['campo_select_value'];//parent
                        //campos select carreras
                        $s_check =  $option['campo_select_check'];//check
                        $s_place = $option['campo_select_carreras_placeholder']; //placeholde
                        $bucleSelec = $option['campo_select_carreras'];//bucle de carreras
                        $size = $option['campo_tamano'];

                        //campos select anidados
                        $s_check_anidado =  $option['campo_select_anidado_check'];//check de anidado
                        $bucleSelecAni = $option['campo_select_niveldos'];//bucle
                        $c_name = $campo['campo_name'];
                        $n_name = $campo['campo_name_option'];
                        if($s_check == '1'&& $s_check_anidado == '0'){
                            echo '<div class="form__input-select-wrapper oculto" data-nivel="2" data-tipo="carrera" data-parent="'.$parent.'" style="width: '.$size.'">';
                                echo '<select name="" data-name="nCarrera" class="form__input-select w-select">';
                                    echo '<option disabled selected>'.$s_place.'</option>';
                                    foreach ($bucleSelec as $carrera) {
                                        $post_id = $carrera['id'];
                                        $titulo = get_the_title($post_id);
                                        $slug = get_post_field('post_name', $post_id);
                                        echo '<option value="'.$slug.'">'.$titulo.'</option>';
                                    }
                                echo '</select>';
                                echo '<input type="hidden" data-name="cCarrera" value="">';
                                if($codForm){
                                echo '<input type="hidden" data-name="cCodFormExterno" value="'.$codForm.'">';
                                }
                            echo '</div>';
                        }elseif($s_check == '0' && $s_check_anidado == '1'){
                            echo '<div class="form__input-select-wrapper oculto" data-nivel="2" data-tipo="bucle" data-parent="'.$parent.'" style="width: '.$size.'">';
                                echo '<select name="" data-name="'.$n_name.'" class="form__input-select w-select">';
                                    echo '<option>'.$s_place.'</option>';
                                    foreach ($bucleSelecAni as $option) {
                                        $value = $option['campo_value'];
                                        $label = $option['campo_select_placeholder'];
                                        echo '<option value="'.$value.'">'.$label.'</option>';
                                    }
                                echo '</select>';
                                if($c_name){
                                    echo '<input type="hidden" data-name="'.$c_name.'" value="">';
                                }    
                                if($codForm){
                                echo '<input type="hidden" data-name="cCodFormExterno" value="'.$codForm.'">';
                                }
                            echo '</div>';
                        }
                    }
                    echo '</div>';

                    //3er nivel
                    echo '<div class="form__selects oculto" style="width: 100%">';
                        foreach ($bucleOps as $option) {
                                //var_dump($option);
                                $bucleThree = $option['campo_select_niveldos'];
                                foreach ($bucleThree as $optionThree) {
                                    $parenThree = $optionThree['campo_value'];
                                    
                                    $size = $optionThree['campo_tamano'];
                                    $codFormThree = $optionThree['campo_select2_codform'];
                                    $optionFirst = $optionThree['campo_select_placeholder_tre'];

                                    $checkAnidadoTre = $optionThree['campo_select_anidado_check'];
                                    $bucleAnidadoFour = $optionThree['campo_select_carreras_four'];

                                    $bucleThreeCarrera = $optionThree['campo_carreras'];
                                    $bucleNivelTres = $optionThree['campo_select_niveltres'];
                                    
                                    $n_campo = $optionThree['campo_name'];
                                    $c_name = $optionThree['campo_name_option'];

                                    if($checkAnidadoTre == '0'){
                                        //select de 3er nivel de carreras, con el check anidado desmarcado  
                                        echo '<div class="form__input-select-wrapper oculto" data-nivel="3" data-tipo="carrera" data-parent="'.$parenThree.'" style="width: '.$size.'">';
                                            echo '<select name="" data-name="nCarrera" class="form__input-select w-select">';
                                                echo '<option>'.$optionFirst.'</option>';
                                                foreach ($bucleThreeCarrera as $carreraTree) {
                                                    $post_id = $carreraTree['id'];
                                                    $titulo = get_the_title($post_id);
                                                    $slug = get_post_field('post_name', $post_id);
                                                    echo '<option value="'.$slug.'">'.$titulo.'</option>';
                                                }
                                            echo '</select>';
                                            echo '<input type="hidden" data-name="cCarrera" value="">';
                                            if($codFormThree){
                                                echo '<input type="hidden" data-name="cCodFormExterno" value="'.$codFormThree.'">';
                                            }
                                        echo '</div>';
                                    }elseif($checkAnidadoTre == '1'){
                                        echo '<div class="form__input-select-wrapper oculto" data-nivel="3" data-tipo="bucle" data-parent="'.$parenThree.'" style="width: '.$size.'">';
                                            echo '<select name="" data-name="'.$n_campo.'" class="form__input-select w-select">';
                                                echo '<option>'.$optionFirst.'</option>';
                                                foreach ($bucleNivelTres as $option) {
                                                    $value = $option['campo_select_value'];
                                                    $label = $option['campo_select_nombre_four'];
                                                    echo '<option value="'.$value.'">'.$label.'</option>';
                                                }
                                            echo '</select>';
                                            if($c_name){
                                                echo '<input type="hidden" data-name="'.$c_name.'" value="">';
                                            }
                                            if($codFormThree){
                                                echo '<input type="hidden" data-name="cCodFormExterno" value="'.$codFormThree.'">';
                                            }
                                        echo '</div>';
                                    }
                                }
                        }
                    echo '</div>';

                    //4to nivel
                    echo '<div class="form__selects oculto" style="width: 100%">';
                        foreach ($bucleOps as $option) {
                            $bucle2_check = $option['campo_select_anidado_check'];
                            $bucle2 = $option['campo_select_niveldos'];
                            if($bucle2_check == '1'){
                                foreach ($bucle2 as $option) {
                                    $bucle3_check = $option['campo_select_anidado_check'];
                                    $bucle3 = $option['campo_select_niveltres'];
                                    if($bucle2_check == '1'){
                                        foreach ($bucle3 as $option) { 
                                            $placeholder = $option['campo_select_placeholder_four'];
                                            $bucle4 = $option['campo_carreras_four'];
                                            $parentFour = $option['campo_select_value'];
                                            $codFormFour = $option['campo_select1_codform'];
                                            echo '<div class="form__input-select-wrapper oculto" data-nivel="4" data-tipo="carrera" data-parent="'.$parentFour.'" style="width: '.$size.'">';
                                                echo '<select name="" data-name="nCarrera" class="form__input-select w-select">';
                                                    echo '<option>'.$placeholder.'</option>';
                                                    foreach ($bucle4 as $carreraFour) {
                                                        $post_id = $carreraFour['id'];
                                                        $titulo = get_the_title($post_id);
                                                        $slug = get_post_field('post_name', $post_id);
                                                        echo '<option value="'.$slug.'">'.$titulo.'</option>';
                                                    }
                                                echo '</select>';
                                                echo '<input type="hidden" data-name="cCarrera" value="">';
                                                if($codFormFour){
                                                    echo '<input type="hidden" data-name="cCodFormExterno" value="'.$codFormFour.'">';
                                                }
                                            echo '</div>';
                                            
                                        }
                                    }

                                }

                            }      
                        }    
                    echo '</div>';
                    break;
                case '4': //campo radio
                    //var_dump($campo);
                    $plaholder = $campo['campo_placeholder'];
                    $radios = $campo['campo_radio'];
                    $name = $campo['campo_name'];
                    $name_option = $campo['campo_name_option'];
                        echo '<div class="form__input-radio-group" data-nivel="1" style="width:100%">';
                            echo '   <div class="form__input-radio-label">'.$plaholder.'</div>';
                            echo '   <div class="form__input-radio-wrapper">';
                                foreach ($radios as $radio) {
                                    $value = $radio['radio_grupo_value'];
                                    $label = $radio['radio_grupo_label'];
                                    echo '<label class="form__input-radio-button">';
                                    echo '  <input required type="radio" name="'.$name.'" value="'.$value.'" data-id="'.$value.'">';
                                    echo '  <p>'.$label.'</p>';
                                    echo '<input type="hidden" data-name="'.$name_option .'" value="'.$label.'">';
                                    echo '</label>';
                                }
                            echo '   </div>';
                        echo '</div>';
                break;
                case '5': //campo oculto
                    $value = $campo['campo_value'];
                    $name = $campo['campo_name'];
                    echo '<input name="'.$name.'" type="hidden" value="'.$value.'">';
                break;
                case '6': //campo carreras
                    $no_option = $campo['campo_placeholder'];
                    $size = $campo['campo_tamano'];
                    $carreras = $campo['campo_carreras'];
                    echo '<div class="form__input-select-wrapper" style="width: '.$size.'">';
                    echo '    <select data-name="nCarrera" class="form__input-select w-select">';
                    echo '        <option value="" disabled selected>'.$no_option.'</option>';
                    foreach ($carreras as $carrera) {
                        $post_id = $carrera['id'];
                        $titulo = get_the_title($post_id);
                        $slug = get_post_field('post_name', $post_id);
                        echo '<option value="'.$slug.'">'.$titulo.'</option>';
                    }
                    echo '    </select>';
                    echo '<input type="hidden" data-name="cCarrera" value="">';
                    echo '</div>';
                    break;
                case '7': //text area
                    $placeholder = $campo['campo_placeholder'];
                    $name = $campo['campo_name'];
                    $size = $campo['campo_tamano'];
                    $required = $campo['check_required'] == '1' ? 'required' : '';
                    echo '<div style="display: flex;flex-direction: column;width: '.$size.'">';
                    echo '<textarea data-requerido="'.$required.'" name="'.$name.'" placeholder="'. $placeholder.'" class="form__input-select-wrapper w-input"></textarea>';
                    echo '</div>';
                    break;
            } 
        }
    ?>    

    <button type="submit" class="button is-form w-button fondo_primario" style="width: 100%"><?= $boton ?></button>
</div>
    <!--<div class="form_body">
        <div class="form_campos">
            <div id="boxCodCamp" class="form__input-select-wrapper hide">
            </div>
            <div class="form_campos-col">
                <input class="form__input-select-wrapper w-input" maxlength="256"
                    name="nombre-padre" data-name="nombre-padre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"
                    placeholder="Nombre del padre de familia*" type="text" id="nombre-padre" required="">
                <input
                    class="form__input-select-wrapper w-node-a1254f40-a5d5-2265-c737-38cb40f3ca64-adfd2a68 w-input"
                    maxlength="256" name="apellido-padre" data-name="apellido-padre"
                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Apellido del padre de familia*" type="text"
                    id="apellido-padre" required="">
                <input class="form__input-select-wrapper w-input"
                    maxlength="256" name="cCelular-5" data-name="C Celular 5" pattern="9[0-9]{8}"
                    placeholder="Celular*" type="tel" id="cCelular-5" required="">
                <input
                    class="form__input-select-wrapper w-input" maxlength="256" name="nombre-hijo"
                    data-name="nombre-hijo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Nombre del hijo(a)*"
                    type="text" id="nombre-hijo" required="">
                <div class="form__input-select-wrapper">
                    <select id="field" name="field" data-name="Field"
                        class="form__input-select w-select">
                        <option value="">Nombre del colegio del hijo*</option>
                        <option value="First">First choice</option>
                        <option value="Second">Second choice</option>
                        <option value="Third">Third choice</option>
                    </select>
                </div>
                <div class="form__input-select-wrapper">
                    <select id="field-2" name="field-2"
                        data-name="Field 2" class="form__input-select w-select">
                        <option value="">Distrito del colegio del hijo*</option>
                        <option value="First">First choice</option>
                        <option value="Second">Second choice</option>
                        <option value="Third">Third choice</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form_botons">
            <div class="text-size-small">Grado del hijo(a)*</div>
            <label class="radio-button w-radio">
                <div
                    class="w-form-formradioinput w-form-formradioinput--inputType-custom radio-button-icon w-radio-input">
                </div>
                <input type="radio" name="tipo" id="mpresencial" data-name="tipo" required=""
                    style="opacity:0;position:absolute;z-index:-1" value="mpresencial">
                <span
                    class="radio-button-label w-form-label" for="mpresencial">Grado del hijo(a)*</span>
            </label>
            <label class="radio-button w-radio">
                <div
                    class="w-form-formradioinput w-form-formradioinput--inputType-custom radio-button-icon w-radio-input">
                </div>
                <input type="radio" name="tipo" id="msemipresencial" data-name="tipo" required=""
                    style="opacity:0;position:absolute;z-index:-1" value="msemipresencial">
                <span
                    class="radio-button-label w-form-label" for="msemipresencial">Otro</span>
            </label>
        </div>
        <div class="form_checkbox">
            <div class="text-size-tiny">(*) Campos obligatorios</div>
            <label class="w-checkbox">
                <input
                    type="checkbox" id="checkbox-3" name="checkbox-3" data-name="Checkbox 3" required=""
                    class="w-checkbox-input">
                <span class="w-form-label" for="checkbox-3">Declaro expresamente
                    haber leído las <a href="#">Políticas de Privacidad</a>
                </span>
            </label>
        </div>
        <input type="submit" data-wait="Please wait..." class="button is-form w-button"
            value="Enviar">
    </div>-->
</form>