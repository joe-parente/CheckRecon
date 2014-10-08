<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author Joe
 * 
 * 
 */// Authentication with Remember Me
// http://samsonasik.wordpress.com/2012/10/23/zend-framework-2-create-login-authentication-using-authenticationservice-with-rememberme/

namespace AuthMod\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\SessionManager;
// use Auth\Model\Auth; we don't need the model here we will use Doctrine em
use AuthMod\Entity\User; // only for the filters
use AuthMod\Form\LoginForm; // <-- Add this import
use AuthMod\Form\LoginFilter;

class IndexController extends AbstractActionController {

    public function indexAction() {

        $em = $this->getEntityManager();

        $users = $em->getRepository('AuthMod\Entity\User')->findAll();

        $message = $this->params()->fromQuery('message', '<h3 style="color: red">Success!</h3>');
        return new ViewModel(array(
            'message' => $message,
            'users' => $users,

        ));
    }

    public function loginAction() {
        $form = new LoginForm();
        $form->get('submit')->setValue('*Click here to log in*');
        $messages = null;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['username']); //$data['usr_name']
                $adapter->setCredentialValue($data['password']); // $data['usr_password']
                $authResult = $authService->authenticate();
                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                    $time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
                    if ($data['rememberme']) {
                        $sessionManager = new SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                }
                foreach ($authResult->getMessages() as $message) {
                    $messages .= "$message\n";
                }
                /*
                  $identity = $authenticationResult->getIdentity();
                  $authService->getStorage()->write($identity);
                  $authenticationService = $this->serviceLocator()->get('Zend\Authentication\AuthenticationService');
                  $loggedUser = $authenticationService->getIdentity();
                 */
            }
        }
        return new ViewModel(array(
            'error' => 'Your authentication credentials are not valid',
            'form' => $form,
            'messages' => $messages,
        ));
    }

    public function logoutAction() {

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
// $view = new ViewModel(array(
// 'message' => 'Hello world',
// ));
// $view->setTemplate('foo/baz-bat/do-something-crazy');
// return $view;
// return $this->redirect()->toRoute('home');
        return $this->redirect()->toRoute('authmod/default', array('controller' => 'index', 'action' => 'login'));
    }

// the use of controller plugin
    public function authTestAction() {
        if ($user = $this->identity()) { // controller plugin
// someone is logged !
        } else {
// not logged in
        }
    }

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

}
