<?php

/**
 * @file
 * Default theme implementation for a single node in a printer-friendly outline.
 *
 * @see book-node-export-html.tpl.php
 * Where it is collected and printed out.
 *
 * Available variables:
 * - $depth: Depth of the current node inside the outline.
 * - $title: Node title.
 * - $content: Node content.
 * - $children: All the child nodes recursively rendered through this file.
 *
 * @see template_preprocess_book_node_export_html()
 *
 * @ingroup themeable
 */
 // set heading tags according to book depth to help structure pdf/toc
 $hdepth = ($depth > 1)? $depth - 1: $depth;
 $hdepth = ($hdepth > 5)? 5: $hdepth;
?>
<div id="node-<?php print $node->nid; ?>" class="section-<?php print $depth; ?>">
  <h<?php echo $hdepth; ?> class="book-heading"><?php print $title; ?></h<?php echo $hdepth; ?>>
  <?php print _ask_plus_header_depth_context($content, $hdepth); ?>
  <?php print $children; ?>
</div>
