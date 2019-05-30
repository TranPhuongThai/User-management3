<?php
namespace App\Controller;
use Cake\Controller\Component\AuthComponent;
use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    public $strangerAllowed = [];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('CheckInputs');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function view()
    {
        $roles = $this->paginate($this->Roles);
        
        $this->set(compact('roles'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewDetail($id = null)
    {
        $role = $this->Roles->get($id);
        $permissions = null;

        if ($role->id != 0 && $role->id != 1) {
            $permissionIds = explode(',', $role->allow_action_ids);
            $permissionModel = $this->loadModel('Permissions');
            foreach ($permissionIds as $permissionId) {
                $permission = $permissionModel->findById($permissionId)->select(['display_name'])->first();
                $permissions[] = $permission['display_name'];
            }
        }

        $this->set(compact('role', 'permissions'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (!empty($this->request->getData())) {
            $data = $this->request->getData();
            $check = $this->CheckInputs->execute($data, ['name']);

            if (!$check) {
                $this->Flash->error(__($this->CheckInputs->getMessage()));

                return $this->redirect(['action' => 'add']);
            }
            $role = $this->Roles->newEntity();
            $role = $this->Roles->patchEntity($role, $data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'viewDetail', $role['id']]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $permissionModel = $this->loadModel('Permissions');
        $permissions = $permissionModel->find('list', [
            'keyField' => 'id',
            'valueField' => 'display_name'
        ]);
        $this->set(compact('permissions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        if (!empty($this->request->getData())) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'viewDetail', $role['id']]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $this->set(compact('role'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view']);
    }
}
