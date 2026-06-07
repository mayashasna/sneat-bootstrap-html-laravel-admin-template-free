@extends('layouts/contentNavbarLayout')

@section('content')
<div class="container">

    <h4 class="fw-bold mb-4">
        <i class="bx bx-list-check me-2"></i>
        Dynamic Fields for {{ $category->name_en ?? $subcategory->name_en }}
    </h4>

    <div class="card shadow-sm p-4">

        {{-- Add New Field --}}
        <a href="{{ route('admin.fields.create', ['category_id' => $category->id ?? null, 'subcategory_id' => $subcategory->id ?? null]) }}"
           class="btn btn-primary mb-3">
            <i class="bx bx-plus"></i> Add New Field
        </a>

        {{-- Fields Table --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name (EN)</th>
                        <th>Name (AR)</th>
                        <th>Type</th>
                        <th>Required</th>
                        <th>Active</th>
                        <th>Sort Order</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($fields as $field)
                        <tr>
                            <td>{{ $field->name_en }}</td>
                            <td>{{ $field->name_ar }}</td>
                            <td>{{ ucfirst($field->type) }}</td>

                            <td>
                                @if($field->is_required)
                                    <span class="badge bg-info">Required</span>
                                @else
                                    <span class="badge bg-secondary">Optional</span>
                                @endif
                            </td>

                            <td>
                                @if($field->active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td>{{ $field->sort_order }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.fields.edit', $field->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <form action="{{ route('admin.fields.destroy', $field->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this field?')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No dynamic fields found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>
@endsection
