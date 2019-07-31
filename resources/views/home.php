<?php $this->layout('layout', ['title' => 'Home Page']);?>

<h1><?=$this->es($name)?></h1>
<button class="pure-button pure-button-primary">
    <a href='addNew'>Add New</a>
</button>
<h1>
    <hr>
</h1>

<table class="pure-table pure-table-striped pure-table-horizontal">
        <thead>
            <tr>
                <th>#</th>
                <th>Author</th>
                <th>Content</th>
                <th>LastUpdate</th>
                <th>Opts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data->fetchAll() as $row): ?>
               <tr>
                   <td><?=$this->e($row->id)?></td>
                   <td><?=$this->es($row->userName)?></td>
                   <td><?=$this->e($row->text)?></td>
                   <td><?=$row->lastUpdate?></td>
                   <td>
                        <button type="button" class="pure-button pure-button-primary">
                                <a href='edit/j/<?=$hashid->encode($row->id)?>'>Edit</a>
                            </button>
                            <form action="delete/j/<?=$hashid->encode($row->id)?>" method='post'>
                                <input type="hidden" name="_method" value="DELETE">
                                <input type='hidden' name="CSRF_TOKEN" value="<?=bin2hex(random_bytes(25))?>" />
                                <button type="submit" class="pure-button button-error">
                                    Delete
                                </button>
                            </form>
                   </td>
               </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
