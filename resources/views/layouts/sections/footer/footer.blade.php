@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer app-footer">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                {{ __('admin.footer.made_by') }} ❤️ {{ __('admin.footer.author_name') }}
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
