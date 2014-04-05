<?php
//Author : Jasmin

    class UsersController extends AppController {
        
        public $uses = array('User');

         public function beforeFilter() {
            parent::beforeFilter(); 
            $this->Auth->allow(array("logout","myinfo","activate","password","signup"));
        }

        public function admin_index() {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
        }

        public function admin_view($id = null) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('User invalide'));
            }
            $this->set('user', $this->User->read(null, $id));
        }

        public function admin_edit($id = null) {

            if ($this->request->is(array('post', 'put'))) {
                if($this->request->data['User']['password'] != $this->request->data['User']['repassword'] ){
                    $this->User->validationErrors['repassword'] = array('The passwords have to be equals.');
                }
                else{
                    if ($this->User->save($this->request->data)) { 
                        $passwordHasher = new SimplePasswordHasher();
                        $link = array('controller'=>'users','action'=>'activate',$this->User->id.'-'.$passwordHasher->hash($this->request->data['User']['repassword']));
                        App::uses('CakeEmail', 'Network/Email');
                        $mail = new CakeEmail();
                        $mail
                             ->to($this->request->data['User']['username'])
                             ->subject('Test :: Your account have been created')
                             ->template('signup')
                             ->emailFormat('html')
                             ->config('smtp')
                             ->viewVars(array("link"=>$link,"lastname"=>$this->request->data['User']['lastname']))
                             ->send();

                            $this->Session->setFlash('Please inform the user that his account have been created.'); 

                        return $this->redirect(array('action' => 'index'));
                    }
                }

            }

            if ($id){ 
                 $user = $this->User->findById($id);
                 if (!$user) {
                     throw new NotFoundException(__('Oups! User not found.'));
                 }


                 if (!$this->request->data) {                 
                     $this->request->data = $user;
                     $this->request->data['User']['password'] = $this->request->data['User']['repassword'] = null;
                 }
            }

            $this->set('groups', $this->Group->find("list"));

         }

        public function admin_delete($id = null) {
            $this->request->onlyAllow('get');

            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('User invalide'));
            }
            if ($this->User->delete()) {
                $this->Session->setFlash(__('User supprimé'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('L\'user n\'a pas été supprimé'));
            return $this->redirect(array('action' => 'index'));
        }

        public function admin_member_account(){

        }

        public function password(){        

            if(!empty($this->request->params['pass'])){
                 $token  = explode('-', $this->request->params['pass'][0]);

                 $user = $this->User->find('first',array(
                    'conditions'=> array(
                    'User.id'=>$token[0],
                    'User.password'=> $token[1],
                    'User.active'=> 1
                )));

                if($user){
                    $this->User->id = $user['User']['id'];
                    $password = substr(md5(uniqid(rand(),true)),0,8);
                    $this->User->saveField('password',$password);
                    $this->Session->setFlash("Your password have been well reseted, there is your new password : $password");
                }
                else{
                    $this->Session->setFlash('The link is not valid.');
                }

            }

            if($this->request->is('post')){
                $v = current($this->request->data);
                $user = $this->User->find('first',array('conditions'=>array(
                'username'=>$v['username'],'active'=>1
            )));

                if(empty($user)){
                    $this->Session->setFlach('No user found with this login');
                }else{

                    $link = array('controller'=>'users','action'=>'password',$user['User']['id'].'-'.$user['User']['password']);
                    App::uses('CakeEmail', 'Network/Email');
                    $mail = new CakeEmail();
                    $mail 
                         ->to($user['User']['username'])
                         ->subject('Test :: Password forgotten')
                         ->template('pwd')
                         ->emailFormat('html')
                         ->config('smtp')
                         ->viewVars(array("link"=>$link,"lastname"=>$user['User']['lastname']))
                         ->send();

                        $this->Session->setFlash('Please click on the link in the mail that you just received.'); 
                }
            }

        }

        public function myinfo() {
            $user_id = $this->Auth->user('id');
            if(!$user_id){
                $this->redirect("/");die;
            }

            $this->User->id = $user_id;
            $passError = false;
            if ($this->request->is('put') || $this->request->is('post')) {             
                $r = $this->request->data;
                if($r['User']['password1'] == $r['User']['password2']){
                    $r['User']['id'] = $user_id;
                    $r['User']['password'] = $r['User']['password1'];

                    if($this->User->save($r, true, array('firstname','lastname','password'))){                        
                        $this->Session->setFlash('Your profil well have been edited.');                    
                    }
                    else{
                        $this->Session->setFlash('Editing impossible.'); 
                    }
                }
                else{
                    $passError = true;
                }
            }else{            
                $this->request->data = $this->User->read();
            }
            $this->request->data['User']['password1'] = $this->request->data['User']['password2'] = null;

            if($passError)
                $this->User->validationErrors['password2'] = array('The passwords are not equals, please verify them.');
        }

        public function admin_my(){
            
        }
        
        public function manager_my(){
            
        }
        public function login() {
            if ($this->request->is('post')) {
                if ($this->Auth->login()) {
                    $this->User->id = $this->Auth->user('id');
                    $this->User->saveField('last_login',date('Y-m-d H:m:i'));
                    return $this->redirect("/");
                } else {
                    $this->Session->setFlash(__("Login or password incorrect."));
                }
            }
        }

        public function logout() {
            $this->Auth->logout();
            return $this->redirect($this->referer());
        }

        public function activate($token){
            $token  = explode('-', $token);
            $user = $this->User->find('first',array(
                'conditions'=> array(
                    'User.id'=>$token[0],
                    'User.password'=> $token[1],
                    'User.active'=> 0
            )));
            if(!empty($user)){
                $this->User->id = $user['User']['id'];
                $this->User->saveField('active',1);
                $this->Session->setFlash("Your account have been activated");
                $this->Auth->login($user['User']);

                $this->User->saveField('last_login',date('Y-m-d H:m:i'));
            }
            else{
                 $this->Session->setFlash("Active link not valid");
            }
            $this->redirect("/");
        }

        public function signup(){
            if ($this->request->is(array('post'))) {
    //            debug($this->request->data);die;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('Your account have been well created. Please go to your mail box. '));

                 $passwordHasher = new SimplePasswordHasher();
                 $link = array('Controller'=>'users','action'=>'activate',$this->User->id.'-'.$passwordHasher->hash($this->request->data['User']['password']));

                 App::uses('CakeEmail', 'Network/Email');
                 $mail = new CakeEmail();
                 $mail 
                         ->to($this->request->data['User']['username'])
                         ->subject('Test :: Subscribtion')
                         ->template('signup')
                         ->emailFormat('html')
                         ->config('smtp')
                         ->viewVars(array("link"=>$link,"lastname"=>$this->request->data['User']['lastname']))
                         ->send();


                 return $this->redirect('/');
                }
            }
        }

    }