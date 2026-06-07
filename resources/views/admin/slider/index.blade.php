@extends('layouts/contentNavbarLayout')

@section('title', __('slider.title'))

@section('content')

<style>
/* ===== Slider Page ===== */
.slider-card {
    border-radius: 22px;
    border: none;
    box-shadow: 0 10px 35px rgba(0,0,0,0.07);
    background: #fff;
}

/* عنوان مع شريط ملوّن */
.slider-header h4 {
    font-size: 24px;
    font-weight: 800;
}

/* ===== Dropzone (منطقة الرفع) ===== */
.upload-box {
    background: linear-gradient(135deg, #f7f7ff 0%, #eef0ff 100%);
    border-radius: 18px;
    padding: 26px;
}
.dropzone {
    border: 2px dashed #b9b9e8;
    border-radius: 16px;
    background: #fff;
    padding: 34px 18px;
    text-align: center;
    cursor: pointer;
    transition: .25s ease;
}
.dropzone:hover,
.dropzone.dragover {
    border-color: #6c5ce7;
    background: #f5f4ff;
    transform: translateY(-2px);
}
.dropzone i {
    font-size: 46px;
    color: #6c5ce7;
}
.dropzone .dz-title {
    font-weight: 700;
    margin-top: 10px;
    color: #444;
}
.dropzone .dz-hint {
    font-size: 13px;
    color: #999;
    margin-top: 4px;
}
.dropzone .dz-filename {
    font-size: 14px;
    color: #6c5ce7;
    font-weight: 600;
    margin-top: 8px;
    word-break: break-all;
}

/* معاينة الصورة */
.preview-wrap {
    margin-top: 16px;
    display: none;
}
.preview-wrap img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,.12);
}

.btn-upload {
    background: #6c5ce7;
    border: none;
    color: #fff;
    border-radius: 14px;
    padding: 13px;
    font-weight: 700;
    width: 100%;
    transition: .25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108,92,231,.3);
    color: #fff;
}

/* ===== Images Grid ===== */
.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}
.slider-item {
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #eee;
    box-shadow: 0 4px 14px rgba(0,0,0,.05);
    transition: .25s ease;
}
.slider-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 26px rgba(0,0,0,.12);
}
.slider-item .img-top {
    position: relative;
    height: 140px;
}
.slider-item .img-top img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.slider-item .status-badge {
    position: absolute;
    top: 10px;
    inset-inline-start: 10px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
}
.status-badge.active   { background: #1db954; }
.status-badge.expired  { background: #e63946; }
.expired-image { filter: grayscale(100%) brightness(60%); opacity: .65; }
.slider-item .item-body {
    padding: 12px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.slider-item .item-date {
    font-size: 12px;
    color: #999;
}
.btn-del {
    border: none;
    background: #ffe5e5;
    color: #e63946;
    border-radius: 10px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: .2s ease;
    flex: 0 0 auto;
}
.btn-del:hover { background: #ffd0d0; }

.empty-state {
    text-align: center;
    padding: 50px 20px;
    color: #aaa;
}
.empty-state i { font-size: 54px; display: block; margin-bottom: 12px; opacity: .5; }
</style>

<div class="container-fluid">

    <div class="card slider-card p-4">

        {{-- عنوان الصفحة --}}
        <div class="slider-header mb-4">
            <h4 class="fw-bold mb-1">{{ __('slider.title') }}</h4>
            <p class="text-muted mb-0">{{ __('slider.subtitle') }}</p>
        </div>

        <div class="row g-4">

            {{-- ===== رفع صورة جديدة ===== --}}
            <div class="col-lg-4">
                <div class="upload-box h-100">

                    <h6 class="mb-3 d-flex align-items-center gap-2">
                        <i class="bx bx-upload text-primary fs-5"></i>
                        {{ __('slider.upload_new') }}
                    </h6>

                    <form action="{{ route('admin.slider.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        {{-- input مخفي --}}
                        <input type="file" name="image" id="imageInput" accept="image/*" hidden>

                        {{-- منطقة السحب/النقر --}}
                        <div class="dropzone" id="dropzone">
                            <i class="bx bx-cloud-upload"></i>
                            <div class="dz-title">{{ __('slider.choose_file') }}</div>
                            <div class="dz-hint">{{ __('slider.drag_hint') }}</div>
                            <div class="dz-filename" id="fileName"></div>
                        </div>

                        {{-- معاينة الصورة --}}
                        <div class="preview-wrap" id="previewWrap">
                            <img id="previewImg" src="" alt="preview">
                        </div>

                        <button type="submit" class="btn-upload mt-3">
                            <i class="bx bx-cloud-upload"></i>
                            {{ __('slider.upload_button') }}
                        </button>
                    </form>

                </div>
            </div>

            {{-- ===== عرض الصور ===== --}}
            <div class="col-lg-8">

                <h6 class="mb-3 d-flex align-items-center gap-2">
                    <i class="bx bx-images text-primary fs-5"></i>
                    {{ __('slider.current_images') }}
                </h6>

                @if(count($images) > 0)
                    <div class="images-grid">
                        @foreach ($images as $img)
                            <div class="slider-item">
                                <div class="img-top">
                                    <img src="{{ asset('storage/sliders/' . $img['path']) }}"
                                         class="{{ $img['expired'] ? 'expired-image' : '' }}">
                                    <span class="status-badge {{ $img['expired'] ? 'expired' : 'active' }}">
                                        {{ $img['expired'] ? __('slider.expired') : __('slider.active') }}
                                    </span>
                                </div>
                                <div class="item-body">
                                    <span class="item-date">
                                        {{ __('slider.uploaded') }}:
                                        {{ \Carbon\Carbon::parse($img['created_at'])->diffForHumans() }}
                                    </span>
                                    <form action="{{ route('admin.slider.delete', $img['id']) }}" method="POST"
                                          onsubmit="return confirm('{{ __('slider.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-del" title="{{ __('slider.delete') }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bx bx-image"></i>
                        {{ __('slider.no_images') }}
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropzone   = document.getElementById('dropzone');
    const input      = document.getElementById('imageInput');
    const fileName   = document.getElementById('fileName');
    const previewWrap= document.getElementById('previewWrap');
    const previewImg = document.getElementById('previewImg');

    // فتح نافذة اختيار الملف عند النقر
    dropzone.addEventListener('click', () => input.click());

    // عند اختيار ملف
    input.addEventListener('change', () => showFile(input.files[0]));

    // السحب والإفلات
    ['dragenter', 'dragover'].forEach(ev =>
        dropzone.addEventListener(ev, e => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        })
    );
    ['dragleave', 'drop'].forEach(ev =>
        dropzone.addEventListener(ev, e => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
        })
    );
    dropzone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file) {
            input.files = e.dataTransfer.files;
            showFile(file);
        }
    });

    function showFile(file) {
        if (!file) return;
        fileName.textContent = file.name;
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewWrap.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
});
</script>

@endsection
