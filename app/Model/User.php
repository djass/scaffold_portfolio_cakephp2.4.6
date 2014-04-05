<?php 
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel { 
    public $name = 'User';
     
    
    public $validate = array(
//        'username' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'message' => 'Un nom d\'user est requis'
//            )
//        ),
        'username'=>array(
            array(
                'rule'=>'email',
                'required'=>true,
                'allowEmpty'=>false,
                'message'=>'Your login is not accepted.'
            ),
            array(
                'rule'=>'isUnique',
                'message'=>'This login is already taken.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'repassword' => array(
            'required' => array(
            'rule'    => array('compareFields' ),
                'type'=> 'password',
                'message' => 'The passwords are not equals'
            )
        ) 
    );
    
    public function compareFields(){  
        
        if($this->data['User']['password'] === $this->data['User']['repassword'])
        return true;
        else return false;
    }

    public function beforeSave($options = array()) {    
        $passwordHasher = new SimplePasswordHasher();
        if (isset($this->data[$this->alias]['password']))
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        return true;
    }
}