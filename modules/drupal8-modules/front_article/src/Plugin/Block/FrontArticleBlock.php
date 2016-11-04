<?php

/**
 * @file
 * Contains \Drupal\article\Plugin\Block\XaiBlock.
 */

namespace Drupal\front_article\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "article_block",
 *   admin_label = @Translation("Article on the block"),
 *   category = @Translation("Custom article block example")
 * )
 */
class FrontArticleBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
     
    public function build() {
        
        $query = \Drupal::entityQuery('node');
        $ids = $query->execute();

        $nodes = Node::loadMultiple($ids);
        //kint($nodes);
        return array(
            '#theme' => 'front_info_block',
            '#nodes' =>  $nodes
        );
    }
}
