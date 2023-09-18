<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute solo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de :attribute no coincide.',
    'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
    'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos :attribute y :other deben ser diferentes.',
    'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute debe ser una dirección de correo válida.',
    'ends_with'            => 'El campo :attribute debe finalizar con alguno de los siguientes valores: :values',
    'exists'               => 'El campo :attribute seleccionado no existe.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'gt'                   => [
        'numeric' => 'El campo :attribute debe ser mayor a :value.',
        'file'    => 'El archivo :attribute debe pesar más de :value kilobytes.',
        'string'  => 'El campo :attribute debe contener más de :value caracteres.',
        'array'   => 'El campo :attribute debe contener más de :value elementos.',
    ],
    'gte'                  => [
        'numeric' => 'El campo :attribute debe ser mayor o igual a :value.',
        'file'    => 'El archivo :attribute debe pesar :value o más kilobytes.',
        'string'  => 'El campo :attribute debe contener :value o más caracteres.',
        'array'   => 'El campo :attribute debe contener :value o más elementos.',
    ],
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute es inválido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'lt'                   => [
        'numeric' => 'El campo :attribute debe ser menor a :value.',
        'file'    => 'El archivo :attribute debe pesar menos de :value kilobytes.',
        'string'  => 'El campo :attribute debe contener menos de :value caracteres.',
        'array'   => 'El campo :attribute debe contener menos de :value elementos.',
    ],
    'lte'                  => [
        'numeric' => 'El campo :attribute debe ser menor o igual a :value.',
        'file'    => 'El archivo :attribute debe pesar :value o menos kilobytes.',
        'string'  => 'El campo :attribute debe contener :value o menos caracteres.',
        'array'   => 'El campo :attribute debe contener :value o menos elementos.',
    ],
    'max'                  => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'file'    => 'El archivo :attribute no debe pesar más de :max kilobytes.',
        'string'  => 'El campo :attribute no debe contener más de :max caracteres.',
        'array'   => 'El campo :attribute no debe contener más de :max elementos.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
        'array'   => 'El campo :attribute debe contener al menos :min elementos.',
    ],
    'not_in'               => 'El campo :attribute seleccionado es inválido.',
    'not_regex'            => 'El formato del campo :attribute es inválido.',
    'numeric'              => 'El campo :attribute debe ser un número.',
    'password'             => 'La contraseña es incorrecta.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato del campo :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los campos :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El campo :attribute debe contener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values',
    'string'               => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone'             => 'El campo :attribute debe ser una zona horaria válida.',
    'unique'               => 'El valor del campo :attribute ya está en uso.',
    'uploaded'             => 'El campo :attribute no se pudo subir.',
    'url'                  => 'El formato del campo :attribute es inválido.',
    'uuid'                 => 'El campo :attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'createArray.category_id' => [
            'required' => 'Debes elegir una categoría'
        ],
        'createArray.type' => [
            'required' => 'Debes elegir dónde será tu evento'
        ],
        'createArray.event_type' => [
            'required' => 'Debes elegir una opción'
        ],
        'createArray.qualification' => [
            'required' => 'Debes elegir una opción'
        ],
        'addOptionArray.label' => [
            'required' => 'Debes crear opciones para tu pregunta',
            'array' => 'Debes cargar mas de una opción'
        ],
        'editOptionArray.label' => [
            'required' => 'Debes crear opciones para tu pregunta',
            'array' => 'Debes cargar mas de una opción'
        ],
        'buyer.accept' => [
            'accepted' => 'Debes aceptar los Términos de servicio y Política de privacidad'
        ],
        'organizer.slug' => [
            'unique' => 'La url ya está tomada por otro usuario. Elige otro nombre o bien modifica la url.'
        ],
        'ticketOwn' => [
            'accepted' => 'El ticket que intentas regalar no te pertence.'
        ],
        'sameMail' => [
            'accepted' => 'No puedes autoregalarte tickets'
        ],
        'photo' => [
            'required' => 'Debes cargar una foto'
        ],
        'cover' => [
            'required' => 'Debes cargar una foto'
        ],
        'videoArray' => [
            'required' => 'Debes cargar al menos un video'
        ],
        'createArray.payment_mode' => [
            'required' => 'Debes elegir una forma de pago'
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'createArray.name' => 'Nombre',
        'createArray.address' => 'Dirección',
        'createArray.city' => 'Ciudad/Localidad',
        'createArray.province' => 'Provincia',
        'createArray.start_date' => 'Fecha y hora de comienzo',
        'createArray.end_date' => 'Fecha y hora de finalización',
        'createArray.description' => 'Descripción',
        'createArray.quantity' => 'Cantidad',
        'createArray.price' => 'Precio',
        'createArray.datetime_start' => 'Día y hora',
        'createArray.datetime_end' => 'Día y hora',
        'createArray.condition_date' => 'Día y hora',
        'createArray.slug' => 'Slug',
        'createArray.birthdate' => 'F. de Nacimiento',
        'createArray.country' => 'País',
        'createArray.phone' => 'Teléfono',
        'createArray.email' => 'Email',
        'createArray.work' => 'Profesión / ocupacón / oficio',
        'createArray.church' => 'Congregación',
        'createArray.pastor' => '¿Es pastor?',
        'createArray.ceap' => '¿Culminó el CEAP inicial?',
        'createArray.subtitle' => 'Congregación',
        'createArray.duration' => 'Duración',
        'createArray.quantity_installments' => 'Cuotas',
        'createArray.total_price_ars' => 'Precio total AR$',
        'createArray.total_price_usd' => 'Precio total u$d',
        'createArray.total_price_ves' => 'Precio total VES',
        'createArray.installment_price_ars' => 'Precio cuota AR$',
        'createArray.installment_price_usd' => 'Precio cuota u$d',
        'createArray.installment_price_ves' => 'Precio cuota VES',
        'createArray.title' => 'Título',
        'createArray.number' => 'Orden',

        'addQuestionArray.label' => 'Pregunta',
        'addQuestionArray.type' => 'Tipo',
        'editQuestionArray.label' => 'Pregunta',
        'editQuestionArray.type' => 'Tipo',

        'addAnswerArray.answer' => 'Respuesta',
        'addAnswerArray.correct' => 'Correcta',

        'editArray.name' => 'Nombre',
        'editArray.address' => 'Dirección',
        'editArray.city' => 'Ciudad/Localidad',
        'editArray.province' => 'Provincia',
        'editArray.start_date' => 'Fecha y hora de comienzo',
        'editArray.end_date' => 'Fecha y hora de finalización',
        'editArray.minimum_age' => 'Mayores de',
        'editArray.description' => 'Descripción',
        'editArray.quantity' => 'Cantidad',
        'editArray.price' => 'Precio',
        'editArray.datetime_start' => 'Día y hora',
        'editArray.datetime_end' => 'Día y hora',
        'editArray.condition_date' => 'Día y hora',
        'editArray.slug' => 'Slug',
        'editArray.subtitle' => 'Congregación',
        'editArray.duration' => 'Duración',
        'editArray.quantity_installments' => 'Cuotas',
        'editArray.total_price_ars' => 'Precio total AR$',
        'editArray.total_price_usd' => 'Precio total u$d',
        'editArray.total_price_ves' => 'Precio total VES',
        'editArray.installment_price_ars' => 'Precio cuota AR$',
        'editArray.installment_price_usd' => 'Precio cuota u$d',
        'editArray.installment_price_ves' => 'Precio cuota VES',
        'editArray.title' => 'Título',
        'editArray.number' => 'Orden',

        'editQuestionArray.question' => 'Pregunta',
        'editQuestionArray.number' => 'Orden',

        'editAnswerArray.answer' => 'Respuesta',
        'editAnswerArray.correct' => 'Correcta',

        'addPaymentArray.payer_email' => 'Email',
        'addPaymentArray.gateway' => 'Pasarela',
        'addPaymentArray.payment_id' => 'ID de pago',
        'addPaymentArray.amount' => 'Monto',
        'addPaymentArray.installment' => 'N° de cuota',
        'addPaymentArray.course_id' => 'Curso',

        'addModuleArray.name' => 'Nombre',
        'addModuleArray.slug' => 'Slug',
        'addModuleArray.number' => 'Orden',
        'addModuleArray.posted_at' => 'F. de Publicación',

        'buyer.name' => 'Nombres',
        'buyer.lastname' => 'Apellido',
        'buyer.email' => 'Email',
        'buyer.card_number' => 'Número de tarjeta',
        'buyer.expiration' => 'Vencimiento',
        'buyer.cvv' => 'Cod. de seguridad',
        'buyer.zip' => 'Cod. Postal',
        'buyer.card_name' => 'Nombre en la tarjeta',
        'buyer.id' => 'Identificación',
        'buyer.id_number' => 'Nro. Documento',

        'cover' => 'Imagen',
        'name' => 'Nombre',
        'lastname' => 'Apellido',
        'email' => 'Email',
        'quantity' => 'Cantidad',
        'image' => 'imagen',
        'ico' => 'icono',
        'start_date' => 'Fecha y hora de comienzo',
        'end_date' => 'Fecha y hora de finalización',
        'img_profile' => 'Logo/Foto',
        'datetime_start' => 'Incio de venta',
        'datetime_end' => 'Fin de venta',
        'datetime_startEdit' => 'Incio de venta',
        'datetime_endEdit' => 'Fin de venta',
        'photo' => 'Foto',
        'photoEdit' => 'Foto',
        'add_course_id' => 'Curso',
        'current_password' => 'Contraseña actual',
        'password' => 'Nueva Contraseña',
        'password_confirmation' => 'Confirmar contraseña',

        'organizer.name' => 'Nombre de organizador/empresa',
        'organizer.email' => 'Email',
    ],

];
