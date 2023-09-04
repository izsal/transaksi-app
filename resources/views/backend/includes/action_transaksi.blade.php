<div class="">
    <a href="{{ route('backend.detail_transaksi', $data) }}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip"
        title="Edit">
        <i class="bi bi-pencil"></i>
    </a>
    <a href="#" class="btn btn-danger btn-sm mt-1"
        onclick="event.preventDefault();
    $('#transaksi-{{ $data }}').submit();" title="Delete"
        data-toggle="tooltip">
        <i class="bi bi-trash"></i>
    </a>
    <form id="transaksi-{{ $data }}" action="{{ route('backend.delete_transaksi', $data) }}" method="DELETE"
        class="d-none">
    </form>
</div>
