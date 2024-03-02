<?php if(count($data->projects) > 0): ?>
    <?php foreach($data->projects as $Key=>$project): ?>
    <div class="form-group pick-folder">
        <button class="btn outline-btn m-0 text-left selectFolder r-4" data-project_id="<?= $project->project_id ?>" name="Create_<?= isset($key) + 1?>"><?= $project->name ?></button>
    </div>
    <?php endforeach ?>
<?php endif ?>