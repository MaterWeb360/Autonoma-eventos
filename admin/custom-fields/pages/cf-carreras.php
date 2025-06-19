<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Información de la Carrera')
    ->where('post_type', '=', 'carreras')
    ->add_fields([
        Field::make('text', 'codigo_programa', 'Código del Programa (obligatorio)')
            ->set_width(50)
            ->set_required(true),
        Field::make('text', 'codigo_externo', 'Código Externo del formulario (opcional)')
            ->set_width(50),
        Field::make('rich_text', 'texto_front', 'Nombre de la carrera (opcional)')
            ->help_text('Al completar este campo, su contenido sustituirá al título en los selectores del formulario.')
            ->set_width(100),
    ]);
