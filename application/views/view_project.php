<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript">
  globalData = {
    table: <?= json_encode($table) ?>
  }
</script>
<div id="ViewProject" class="App" project_id="<?= $project->id ?>" project_title="<?= $project->title ?>" project_description="<?= $project->description ?>"> </div>