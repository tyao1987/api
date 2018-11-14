<?php

return array(
    'Application' => array(
            'type'  => 'segment', 
            'options' => array(
                    'route' => '[/:controller[/:action]]', 
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*', 
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*', ), 
                        'defaults' => array(
                            '__NAMESPACE__' => 'Application\Controller', 
                        ), 
            ), 
    ),
    
);