<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Permitir acceso público a registro y login
        $this->Authentication->allowUnauthenticated(['login', 'register']);
    }

    public function login()
    {
        $this->set('title', 'Iniciar Sesión');

        $result = $this->Authentication->getResult();

        // Si el usuario ya está logueado, redirigir
        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Pages',
                'action' => 'home'
            ]);

            return $this->redirect($redirect);
        }

        // Si hay error en el login
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email o contraseña incorrectos');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function register()
    {
        $this->set('title', 'Registro de Usuario');

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Asignar valores por defecto
            $data['role'] = 'user';
            $data['active'] = false;

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('Registro exitoso. Espera a que un administrador active tu cuenta.');
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Error en el registro. Por favor, intenta de nuevo.');
            }
        }

        $this->set(compact('user'));
    }
}
