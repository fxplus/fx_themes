<?php dpm($form['fx_searchblock_form']); ?>

  
   
<h1>hello</h1>

<?php // $form['fx_searchblock_form']['#theme'] = 'fx_searchblock_queryfield'; ?>

<?php print render($form['fx_searchblock_form']); ?>
<?php print render($form['#submit']); ?>


<p>world</p>


<?php //print drupal_render_children($form); ?>