<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
    var $components = array('Email');
    
    

    function home()
    {
        $this->set('home',$this->Page->findBySlug('home'));
        $this->set('events',$this->Page->findBySlug('corporate-events'));
        $this->set('full',$this->Page->findBySlug('full-ship-charters'));
        $this->set('csi',$this->Page->findBySlug('csi'));
        
        
           
    }
    function index($slug="")
    {
        $q = $this->Page->findBySlug($slug);
        $this->set('model',$q);
        $this->loadModel('Image');
        $this->set('images', $this->Image->find('all',array('conditions'=>array('type'=>'pages','type_id'=>$q['Page']['id']),'limit'=>3,'order'=>'rand()')));
        $this->set('seoTitle',$q['Page']['seo_title']);
        $this->set('seoDesc',$q['Page']['seo_desc']);
    }
    
    
    function why_cruise()
    {
        $q = $this->Page->findBySlug('why-cruises');
        $this->set('model',$q);
        $this->loadModel('Image');
        $this->set('images', $this->Image->find('all',array('conditions'=>array('type'=>'pages','type_id'=>$q['Page']['id']),'limit'=>3,'order'=>'rand()')));
        $this->set('seoTitle',$q['Page']['seo_title']);
        $this->set('seoDesc',$q['Page']['seo_desc']);
    }
    
    function cruise_search()
    {
        $q = $this->Page->findBySlug('cruise-search');
        $this->set('model',$q);
        $this->loadModel('Image');
        $this->set('images', $this->Image->find('all',array('conditions'=>array('type'=>'pages','type_id'=>$q['Page']['id']),'limit'=>3,'order'=>'rand()')));
        $this->set('seoTitle',$q['Page']['seo_title']);
        $this->set('seoDesc',$q['Page']['seo_desc']);
    }
    function csi($slug)
    {
        $this->loadModel('Csi');
        $q = $this->Csi->findBySlug($slug);
        $this->set('model',$q);
        $this->set('seoTitle',$q['Csi']['title']);
        $this->set('seoDesc',substr($q['Csi']['desc'],0,250));
    }
    function contact()
    {
        if(isset($_POST) && $_POST)
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            //$message = $_POST['message'];
            $emails = new CakeEmail();
                    $emails->from(array('noreply@islamisanghnepal.org'=>'Islami Sangh Nepal'));
                
                    $emails->emailFormat('html');
                    
                    $emails->subject('New contact Message');
                    
                    
                    $message="
                    Assalam Alaikum,<br/><br/>
                    You have received a new message from islamisanghnepal.org<br/><br/> 
    
    <b>From</b> : ".$name."<br/>
    <b>Email</b> : ".$email."<br/>
    <b>Message</b> : ".$_POST['message'];
                    $emails->to('admin@web-nepal.com');
                    $emails->send($message);
                    $this->Session->setFlash('Message sent successfully');
                    $this->redirect('/');
        }
        
    }
    public function getpages($id)
    {
        return $dc = $this->Page->find('all',array('conditions'=>array('parent'=>$id)));;
    }
    public function detail($slug)
    {
        $q = $this->Page->findBySlug($slug);
        $this->set('pages',$q);
    }
    public function media($slug)
    {
        $this->loadModel('Media');
        $this->set('media',$this->Media->find('all',array('conditions'=>array('media_type'=>$slug))));
        $this->set('slug',$slug);
    }
    public function getParent($slug)
    {
        $q = $this->Page->findBySlug($slug);
        if($q['Page']['parent']!=0){
        $page = $this->Page->findById($q['Page']['parent']);
        return $page['Page']['title']. ' > ';
        }
        else
        return '';
    }
    public function getLinks()
    {
        $this->loadModel('Link');
        return $this->Link->find('all');
    }
    
   
}
