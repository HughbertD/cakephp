<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.3.6
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\Helper\BreadcrumbsHelper;
use Cake\View\View;

class BreadcrumbsHelperTest extends TestCase
{

    /**
     * Instance of the BreadcrumbsHelper
     *
     * @var BreadcrumbsHelper
     */
    public $breadcrumbs;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->breadcrumbs = new BreadcrumbsHelper($view);
    }

    /**
     * Test adding crumbs to the trail using add()
     * @return void
     */
    public function testAdd()
    {
        $this->breadcrumbs
            ->add('Home', '/', ['class' => 'first'])
            ->add('Some text', ['controller' => 'Some', 'action' => 'text']);

        $result = $this->breadcrumbs->getCrumbs();
        $expected = [
            [
                'title' => 'Home',
                'link' => '/',
                'options' => [
                    'class' => 'first'
                ]
            ],
            [
                'title' => 'Some text',
                'link' => [
                    'controller' => 'Some',
                    'action' => 'text'
                ],
                'options' => []
            ]
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test adding crumbs to the trail using prepend()
     * @return void
     */
    public function testPrepend()
    {
        $this->breadcrumbs
            ->add('Home', '/', ['class' => 'first'])
            ->prepend('Some text', ['controller' => 'Some', 'action' => 'text'])
            ->prepend('The root', '/root', ['data-name' => 'some-name']);

        $result = $this->breadcrumbs->getCrumbs();
        $expected = [
            [
                'title' => 'The root',
                'link' => '/root',
                'options' => ['data-name' => 'some-name']
            ],
            [
                'title' => 'Some text',
                'link' => [
                    'controller' => 'Some',
                    'action' => 'text'
                ],
                'options' => []
            ],
            [
                'title' => 'Home',
                'link' => '/',
                'options' => [
                    'class' => 'first'
                ]
            ]
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test adding crumbs to a specific index
     * @return void
     */
    public function testInsertAt()
    {
        $this->breadcrumbs
            ->add('Home', '/', ['class' => 'first'])
            ->prepend('Some text', ['controller' => 'Some', 'action' => 'text'])
            ->insertAt(1, 'Insert At', ['controller' => 'Insert', 'action' => 'at'])
            ->insertAt(1, 'Insert At Again', ['controller' => 'Insert', 'action' => 'at_again']);

        $result = $this->breadcrumbs->getCrumbs();
        $expected = [
            [
                'title' => 'Some text',
                'link' => [
                    'controller' => 'Some',
                    'action' => 'text'
                ],
                'options' => []
            ],
            [
                'title' => 'Insert At Again',
                'link' => [
                    'controller' => 'Insert',
                    'action' => 'at_again'
                ],
                'options' => []
            ],
            [
                'title' => 'Insert At',
                'link' => [
                    'controller' => 'Insert',
                    'action' => 'at'
                ],
                'options' => []
            ],
            [
                'title' => 'Home',
                'link' => '/',
                'options' => [
                    'class' => 'first'
                ]
            ]
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test adding crumbs before a specific one
     * @return void
     */
    public function testInsertBefore()
    {
        $this->breadcrumbs
            ->add('Home', '/', ['class' => 'first'])
            ->prepend('Some text', ['controller' => 'Some', 'action' => 'text'])
            ->prepend('The root', '/root', ['data-name' => 'some-name'])
            ->insertBefore('The root', 'The super root');

        $result = $this->breadcrumbs->getCrumbs();
        $expected = [
            [
                'title' => 'The super root',
                'link' => null,
                'options' => []
            ],
            [
                'title' => 'The root',
                'link' => '/root',
                'options' => ['data-name' => 'some-name']
            ],
            [
                'title' => 'Some text',
                'link' => [
                    'controller' => 'Some',
                    'action' => 'text'
                ],
                'options' => []
            ],
            [
                'title' => 'Home',
                'link' => '/',
                'options' => [
                    'class' => 'first'
                ]
            ]
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test adding crumbs after a specific one
     * @return void
     */
    public function testInsertAfter()
    {
        $this->breadcrumbs
            ->add('Home', '/', ['class' => 'first'])
            ->prepend('Some text', ['controller' => 'Some', 'action' => 'text'])
            ->prepend('The root', '/root', ['data-name' => 'some-name'])
            ->insertAfter('The root', 'The less super root');

        $result = $this->breadcrumbs->getCrumbs();
        $expected = [
            [
                'title' => 'The root',
                'link' => '/root',
                'options' => ['data-name' => 'some-name']
            ],
            [
                'title' => 'The less super root',
                'link' => null,
                'options' => []
            ],
            [
                'title' => 'Some text',
                'link' => [
                    'controller' => 'Some',
                    'action' => 'text'
                ],
                'options' => []
            ],
            [
                'title' => 'Home',
                'link' => '/',
                'options' => [
                    'class' => 'first'
                ]
            ]
        ];
        $this->assertEquals($expected, $result);
    }
}