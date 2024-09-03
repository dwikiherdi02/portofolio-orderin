<ul class="list-group list-group-horizontal list-action">
    <li class="list-group-item p-0 bg-transparent border-0">
        <a href="{{ route('customer.edit', ['customer' => $data->id]) }}" class="btn btn-link text-decoration-none text-secondary fs-6 px-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    </li>
    <li class="list-group-item p-0 bg-transparent border-0">
        <button class="btn btn-link text-decoration-none text-secondary fs-6 px-1" data-href="{{ route('customer.destroy', ['customer' => $data->id]) }}" onclick="deleteData(this, 'reloadTable(\'tbl-list\')')">
            <i class="fa-regular fa-trash-can"></i>
        </button>
    </li>
</ul>
