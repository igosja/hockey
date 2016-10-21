<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/<?= $route_path; ?>">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <?php if (0 != $num_get) { ?>
        <li>
            <a href="/admin/<?= $route_path; ?>/view/<?= $num_get; ?>">
                <button class="btn btn-default">Просмотр</button>
            </a>
        </li>
    <?php } ?>
</ul>