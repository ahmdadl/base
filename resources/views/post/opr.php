<div class="bg-dark text-center py-1">
    <a href='/blog/posts/<?= $p->slug ?>/edit' class="btn btn-info mx-1">Edit</a>
    <button type="button" class="btn btn-danger mx-1" @click.stop.prevent="h.d.deletePost('<?=$p->id?>', <?=$red ?? false?>)">
    <span ref='delLoad<?=$p->id?>' class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    Delete
</button>
</div>