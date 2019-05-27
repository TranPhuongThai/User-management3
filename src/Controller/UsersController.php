<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Controller\Component\AuthComponent;
use Cake\Log\Log;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Role');
        // log::info($this->Auth->user());
        if (!empty($this->Auth->user()) && $this->request->action == 'login') {
            $this->Flash->error(__('You have logged in, logout first please!'));
            
            return $this->redirect(['action' => 'viewDetail', $this->Auth->user('id')]);
        }
    
        
    }

    public function view()
    {   
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);
        foreach ($users as $user) {
            unset($user['password']);
        }
        $this->set(compact('users','currentUser'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewDetail($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);
        unset($user->password);
        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'viewDetail', $user['id']]);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to view.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $user = $this->Users->get($id);
        
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view']);
    }

    public function login() {

        if (!empty($this->request->getData())) {
            $user = $this->Auth->identify();

            if ($user) {
                $user['allowedActions'] = $this->Role->getAllowedActions($user['role_id']);
                $this->Auth->setUser($user);

                return $this->redirect(['action' => 'viewDetail', $user['id']]);
            } else {
                $this->Flash->error(__('Wrong username or password'));

                return $this->redirect(['action' => 'login']);
            }
        }
    }

    public function logout()
    {
        if (empty($this->Auth->user())) {
            $this->Flash->success('You have not logged in, login first please!');

            return $this->redirect(['action' => 'login']);
        }
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
}
