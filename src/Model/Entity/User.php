<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $user_code
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $address
 * @property int $role_id
 * @property int $status
 * @property string|null $confirmation
 * @property \Cake\I18n\FrozenTime|null $confirm_expired_time
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Role $role
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'password' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password) {
		
        return $this->hashPassword($password);
    }
    
    /**
     * Hash password before save
     * @param string $password password
     * @return string
     */
    public function hashPassword($password) {
        
        if (strlen($password)) {
            $hash = new DefaultPasswordHasher();

            return $hash->hash($password);
        }
    }
    public function verifyPassword($password) {
        $hash = new DefaultPasswordHasher();

        return $hash->check($password, $this->password);
    }
}
