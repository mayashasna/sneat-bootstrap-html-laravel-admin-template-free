@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">
    <h1>الخدمات المحذوفة (Soft Delete)</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>العنوان (AR)</th>
                <th>العنوان (EN)</th>
                <th>الحالة</th>
                <th>السعر</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->title_ar }}</td>
                    <td>{{ $service->title_en }}</td>
                    <td>{{ $service->status }}</td>
                    <td>{{ $service->price }} {{ $service->currency }}</td>
                    <td>
                        <form action="{{ route('admin.services.restore', $service->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">استرجاع</button>
                        </form>
                        <form action="{{ route('admin.services.forceDelete', $service->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف نهائي</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $services->links() }}
</div>
@endsection
