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
                <th>Opts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data->fetchAll() as $row): ?>
               <tr>
                   <td><?=$this->e($row->id)?></td>
                   <td><?=$this->es($row->userName)?></td>
                   <td><?=$this->e($row->text)?></td>
                   <td>
                        <button type="button" class="pure-button pure-button-primary">
                                <a href='/frame/public/edit?id=1'>Edit</a>
                            </button>
                            <button type="button" class="pure-button button-error">
                                <a href='/frame/public/delete?id=1'>Delete</a>
                            </button>
                   </td>
               </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
