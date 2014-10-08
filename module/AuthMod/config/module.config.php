<?php

namespace AuthMod; // SUPER important for Doctrine othervise can not find the Entities

return array(
    'controllers' => array(

        'invokables' => array(
            'AuthMod\Controller\Index' => 'AuthMod\Controller\IndexController',
            'AuthMod\Controller\Registration' => 'AuthMod\Controller\RegistrationController',
        ),
    ),
    'static_salt' => 'aabbcc',
    'router' => array(
        'routes' => array(
            'authmod' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/authmod',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AuthMod\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'auth-mod' => __DIR__ . '/../view'
        ),
        'display_exceptions' => true,
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'AuthMod\Entity\User',
                'identity_property' => 'usrName',
                'credential_property' => 'usrPassword',
                'credential_callable' => function($user, $passwordGiven) { 
                    if ($user->getUsrPassword() == md5('aFGQ674k8fdfsaf2342' . $passwordGiven . $user->getUsrPasswordSalt()) &&
                            $user->getUsrActive() == 1) {
                        return true;
                    } else {
                        return false;
                    }
                },
            ),
        ),
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    'omfg' => __DIR__,
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                )
            ),
        )
    )
);
