<?php

/**
 * @file
 * Contains Drupal\menicko\Controller.
 */

namespace Drupal\menicko\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\Serializer\SerializerInterface;
use \Symfony\Component\HttpFoundation\Response;

/**
 * Controller routines for page example routes.
 */
class TestModuleController extends ControllerBase {

    public function arguments() {
        $vip = 'vip'; //14
        $misc = 'misc'; //15
        $deserts = 'deserts'; //16
        $drinks = 'drinks'; //17
        $perm_menu = 'permanent menu'; //13
        
        

        $date = \Drupal::service('date.formatter')->format(REQUEST_TIME, 'html_date');

        $query_denne_menu = \Drupal::entityQuery('node')
                ->condition('type', 'denne_menu', '=')
                ->condition('field_platne_od.value', $date, '<=')
                ->condition('field_platne_do.value', $date, '>=');

        $nids = $query_denne_menu->execute();
        
        $query_jedalny_listok  = \Drupal::entityQuery('node')
                ->condition('type', 'jedalny_listok', '=');
        
        
        $nids_menu = $query_jedalny_listok->execute();
        
        
        
        
        
        $jedalne_listky = Node::loadMultiple($nids_menu);
        //dpm($jedalne_listky[13]->body->value);
       
        $vip = $jedalne_listky[14]->body->value; //14
        $misc = $jedalne_listky[15]->body->value; //15
        $deserts = $jedalne_listky[16]->body->value; //16
        $drinks = $jedalne_listky[17]->body->value; //17
        $perm_menu = $jedalne_listky[13]->body->value; //13

        //if no menu for the give request time inform the user
        if (!count($nids)) {
            $menu  = 'V tomto momente nie je vypisané žiadne menu';
            //return['#markup' => 'V tomto momente nie je vypisané žiadne menu', '#title' => 'Týždenné menu sa nenašlo'];
        }

        //if $nid found load the node and display it to the user;
        foreach ($nids as $nid) {
            $node = Node::load($nid);
            //dpm($node);
            $menu = $node->body->value;
        }
        
        
        $output = [];
        $output[] = ['#theme' => 'menicko_menu', 
            '#denne_menu' => $menu, 
            '#vip' => $vip,
            '#misc' => $misc,
            '#deserts' => $deserts,
            '#drinks' => $drinks,
            '#perm_menu' => $perm_menu
            ];
        return $output;
    }

    public function json_response() {
        
        $ids = \Drupal::entityQuery('node')
                ->condition('type', 'denne_menu', '=')
                ->execute();
        $nodes = Node::loadMultiple($ids);
        $output = [];
        foreach ($nodes as $node) {
            $output[] = array('title' => $node->title->value, 'body' => $node->body->value);
        }
        return new JsonResponse($output);
    }
    public function template(){
        return [
            '#theme'=> 'test_module_template',
            '#test' => 'test'
            ];
        
    }

}
