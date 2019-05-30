<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\Controller\Component\AuthComponent;

/**
 * Permissions Controller
 *
 * @property \App\Model\Table\PermissionsTable $Permissions
 *
 * @method \App\Model\Entity\Permission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermissionsController extends AppController
{

    public $strangerAllowed = [];
    public function initialize() 
    {
        parent::initialize();
        $this->loadComponent('CheckInputs');
        $this->loadModel('Roles');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function view()
    {
        $permissions = $this->paginate($this->Permissions);

        $this->set(compact('permissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewDetail($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => []
        ]);
        $this->set('permission', $permission);
    }

    /**
     * Add method
     *
     * @return mixed.
     */
    public function add()
    {
        $permission = $this->Permissions->newEntity();

        if (!empty($this->request->getData())) {
            $data = $this->request->getData();
            $checkInputs = $this->CheckInputs->execute($data, ['name', 'controller']);

            if (!$checkInputs) {
                $this->Flash->error(__($this->CheckInputs->getMessage()));

                return $this->redirect(['action' => 'add']);
            }

            $permission = $this->Permissions->newEntity($data);

            if (empty($permission->display_name)) {
                $permission->display_name = 'default';
            }
            if (!$this->Permissions->save($permission)) {
                $this->Flash->error(__('Permission could not be created. Please, try again!'));

                return $this->redirect(['action' => 'add']);
            }

            if (!empty($data['role_id'])) {
                $roleIds = $data['role_id'];
                foreach ($roleIds as $roleId) {
                    $role = $this->Roles->findById($roleId)->first();
                    $count = 0;
                    
                    if (!empty($role)) {
                        $role['allow_action_ids'] = $role['allow_action_ids'].','.$permission->id;
                        
                        if (!$this->Roles->save($role)) {
                            $this->Flash->error(__('Role '.$role['name'].' could not updated!'));
                        }
                        else $count++;
                    }
                    else {
                        $this->Flash->error(__("Role $roleId not found!"));
                    }
                }

                if ($count !== 0) {
                    $this->Flash->success(__('Role(s) updated.'));
                }
            }
            $this->Flash->success(__('Permission created.'));

            return $this->redirect(['action' => 'viewDetail', $permission->id]);
        }
        $roles = $this->Roles->find('list',[
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['id !=' => 0, 'id != ' => 1]);
        $this->set(compact('permission','roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));
                
                return $this->redirect(['action' => 'viewDetail', $permission['id']]);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $this->set(compact('permission'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please try again.'));
        }

        return $this->redirect(['action' => 'view']);
    }
}
