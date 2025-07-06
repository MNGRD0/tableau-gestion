<?php

return [

    'accepted'             => 'Le champ :attribute doit être accepté.',
    'active_url'           => 'Le champ :attribute n\'est pas une URL valide.',
    'after'                => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal'       => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha'                => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash'           => 'Le champ :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'            => 'Le champ :attribute ne peut contenir que des lettres et des chiffres.',
    'array'                => 'Le champ :attribute doit être un tableau.',
    'before'               => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal'      => 'Le champ :attribute doit être une date antérieure ou égale au :date.',
    'between'              => [
        'numeric' => 'Le champ :attribute doit être entre :min et :max.',
        'file'    => 'Le fichier :attribute doit peser entre :min et :max kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'array'   => 'Le champ :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'La confirmation de :attribute ne correspond pas.',
    'date'                 => 'Le champ :attribute n\'est pas une date valide.',
    'date_equals'          => 'Le champ :attribute doit être une date égale à :date.',
    'date_format'          => 'Le champ :attribute ne correspond pas au format :format.',
    'different'            => 'Les champs :attribute et :other doivent être différents.',
    'digits'               => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between'       => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'email'                => 'Le champ :attribute doit être une adresse email valide.',
    'ends_with'            => 'Le champ :attribute doit se terminer par une des valeurs suivantes : :values',
    'exists'               => 'Le champ :attribute est invalide.',
    'file'                 => 'Le champ :attribute doit être un fichier.',
    'filled'               => 'Le champ :attribute est obligatoire.',
    'gt'                   => [
        'numeric' => 'Le champ :attribute doit être supérieur à :value.',
        'file'    => 'Le fichier :attribute doit faire plus de :value kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir plus de :value caractères.',
        'array'   => 'Le champ :attribute doit contenir plus de :value éléments.',
    ],
    'gte'                  => [
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
        'file'    => 'Le fichier :attribute doit faire au moins :value kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir au moins :value caractères.',
        'array'   => 'Le champ :attribute doit contenir au moins :value éléments.',
    ],
    'image'                => 'Le champ :attribute doit être une image.',
    'in'                   => 'Le champ :attribute est invalide.',
    'integer'              => 'Le champ :attribute doit être un entier.',
    'ip'                   => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le champ :attribute doit être une chaîne JSON valide.',
    'lt'                   => [
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'file'    => 'Le fichier :attribute doit faire moins de :value kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir moins de :value caractères.',
        'array'   => 'Le champ :attribute doit contenir moins de :value éléments.',
    ],
    'lte'                  => [
        'numeric' => 'Le champ :attribute doit être inférieur ou égal à :value.',
        'file'    => 'Le fichier :attribute doit faire au plus :value kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir au plus :value caractères.',
        'array'   => 'Le champ :attribute ne doit pas contenir plus de :value éléments.',
    ],
    'max'                  => [
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'file'    => 'Le fichier :attribute ne doit pas dépasser :max kilo-octets.',
        'string'  => 'Le champ :attribute ne doit pas contenir plus de :max caractères.',
        'array'   => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
    ],
    'min'                  => [
        'numeric' => 'Le champ :attribute doit être au moins de :min.',
        'file'    => 'Le fichier :attribute doit faire au moins :min kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le champ :attribute doit contenir au moins :min éléments.',
    ],
    'not_in'               => 'Le champ :attribute sélectionné est invalide.',
    'numeric'              => 'Le champ :attribute doit être un nombre.',
    'password'             => 'Le mot de passe est incorrect.',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_with'        => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without'     => 'Le champ :attribute est obligatoire quand :values n\'est pas présent.',
    'same'                 => 'Les champs :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le champ :attribute doit être :size.',
        'file'    => 'Le fichier :attribute doit faire :size kilo-octets.',
        'string'  => 'Le champ :attribute doit contenir :size caractères.',
        'array'   => 'Le champ :attribute doit contenir :size éléments.',
    ],
    'string'               => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone'             => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique'               => 'Le champ :attribute a déjà été pris.',
    'url'                  => 'Le champ :attribute doit être une URL valide.',
    'email_client.unique'  => 'Cet email est déjà utilisé.',

    /*
    |--------------------------------------------------------------------------
    | Personnalisation des attributs
    |--------------------------------------------------------------------------
    */
    'attributes' => [],

    /*
    |--------------------------------------------------------------------------
    | Personnalisation de certains champs spécifiques
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'mot_de_passe_client' => [
            'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ],
    ],
];
