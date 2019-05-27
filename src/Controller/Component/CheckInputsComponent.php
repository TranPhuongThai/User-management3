<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\Log;

class CheckInputsComponent extends Component
{
    public $message;

    public function getMessage() 
    {
        return $this->message;
    }

    public function execute($inputs, $requires)
    {
        if (empty($inputs)) {
            $this->message = __('Input empty');

            return false;
        }
        $shortages = [];
        foreach ($requires as $require) {
            
            if (empty($inputs[$require])) {
                $shortages[] = $require;
            }
        }

        if (!empty($shortages)) {
            foreach ($shortages as $shortage) {
                $this->message = $this->message. "Lack of $shortage.\n" ;
            }

            return false;
        }

        return true;
    }
}