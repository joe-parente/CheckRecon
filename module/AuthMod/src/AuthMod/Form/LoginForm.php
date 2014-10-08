<?php

/*
 * Copyright (C) 2014 Joe
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace AuthMod\Form;

use Zend\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null) {
// we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        /*
          $this->add(array(
          'name' => 'usr_id',
          'attributes' => array(
          'type' => 'hidden',
          ),
          ));
         */
        $this->add(array(
            'name' => 'username', // 'usr_name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password', // 'usr_password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',
// 'attributes' => array(
// 'type' => '\Zend\Form\Element\Checkbox',
// ),
            'options' => array(
                'label' => 'Remember Me?',
// 'checked_value' => 'true', without value here will be 1
// 'unchecked_value' => 'false', // witll be 1
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }

}
