<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/<?= $route_path; ?>">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <li>
        <a href="/admin/<?= $route_path; ?>/update/<?= $num_get; ?>">
            <button class="btn btn-default">Одобрить</button>
        </a>
    </li>
    <li>
        <a href="/admin/<?= $route_path; ?>/delete/<?= $num_get; ?>">
            <button class="btn btn-default">Удалить</button>
        </a>
    </li>
</ul>