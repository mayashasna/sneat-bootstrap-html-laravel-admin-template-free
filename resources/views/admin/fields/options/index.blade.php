@extends('layouts/contentNavbarLayout')

@section('title', __('field_options.index_title'))

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">{{ __('field_options.index_title') }}</h4>
            <p class="text-muted">{{ __('field_options.subtitle') }}</p>
        </div>

        <a href="{{ route('admin.fields.options.create', $field->id) }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i>
            {{ __('field_options.buttons.add_new') }}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>{{ __('field_options.table.id') }}</th>
                        <th>{{ __('field_options.table.value_ar') }}</th>
                        <th>{{ __('field_options.table.value_en') }}</th>
                        <th>{{ __('field_options.table.status') }}</th>
                        <th>{{ __('field_options.table.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($options as $option)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $option->value_ar }}</td>
                            <td>{{ $option->value_en }}</td>

                            <td>
                                <span class="badge {{ $option->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $option->is_active ? __('field_options.table.active') : __('field_options.table.inactive') }}
                                </span>
                            </td>

                            <td class="d-flex justify-content-center gap-1">
                                <!-- زر تعديل -->
                                <a href="{{ route('admin.fields.options.edit', [$field->id, $option->id]) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <!-- زر حذف -->
                                <form action="{{ route('admin.fields.options.destroy', [$field->id, $option->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('{{ __('field_options.buttons.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">
                                {{ __('field_options.table.no_data') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
