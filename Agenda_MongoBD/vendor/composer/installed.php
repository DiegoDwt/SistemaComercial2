<?php return array(
    'root' => array(
        'name' => 'seu_nome_projeto/seu_projeto',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => null,
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'mongodb/mongodb' => array(
            'pretty_version' => '1.19.0',
            'version' => '1.19.0.0',
            'reference' => 'cbc8104c0b2c32b7cf572ff759324c872e8dc63a',
            'type' => 'library',
            'install_path' => __DIR__ . '/../mongodb/mongodb',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'monolog/monolog' => array(
            'pretty_version' => '2.9.3',
            'version' => '2.9.3.0',
            'reference' => 'a30bfe2e142720dfa990d0a7e573997f5d884215',
            'type' => 'library',
            'install_path' => __DIR__ . '/../monolog/monolog',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'psr/log' => array(
            'pretty_version' => '3.0.0',
            'version' => '3.0.0.0',
            'reference' => 'fe5ea303b0887d5caefd3d431c3e61ad47037001',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/log',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'psr/log-implementation' => array(
            'dev_requirement' => false,
            'provided' => array(
                0 => '1.0.0 || 2.0.0 || 3.0.0',
            ),
        ),
        'seu_nome_projeto/seu_projeto' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => null,
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'symfony/polyfill-php80' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => '87b68208d5c1188808dd7839ee1e6c8ec3b02f1b',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-php80',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'symfony/polyfill-php81' => array(
            'pretty_version' => 'v1.29.0',
            'version' => '1.29.0.0',
            'reference' => 'c565ad1e63f30e7477fc40738343c62b40bc672d',
            'type' => 'library',
            'install_path' => __DIR__ . '/../symfony/polyfill-php81',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);