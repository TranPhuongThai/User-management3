<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class RoleComponent extends Component
{
    public function initialize(array $config)
    {
        $this->model = TableRegistry::get('Roles');
    }

    public function getAllowedActions($roleId) 
    {

        if ($roleId !== 0 ) {
            $role = $this->model->get($roleId);
            
            if ($role->allow_action_ids == "all") {

                return "all";
            }
            return explode(',', $role->allow_action_ids);
        }

        return [];
    }
}