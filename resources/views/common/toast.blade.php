@if (session()->has('success'))
    <div class="toastms active success">
        <div class="toast-icon"><i class="fas fa-check"></i></div>
        <div class="toast-content">
            <div class="toast-title">Thành công</div>
            <div class="toast-message">{{ session()->get('success') }}</div>
        </div>
        <div class="close-toast"><i class="fas fa-times"></i></div>
        <div class="progress active"></div>
    </div>
@endif
@if (session()->has('failed'))
    <div class="toastms active failed">
        <div class="toast-icon"><i class="fas fa-times"></i></div>
        <div class="toast-content">
            <div class="toast-title">Thất bại</div>
            <div class="toast-message">{{ session()->get('failed') }}</div>
        </div>
        <div class="close-toast"><i class="fas fa-times"></i></div>
        <div class="progress active"></div>
    </div>
@endif
@if (session()->has('warning'))
    <div class="toastms active warning">
        <div class="toast-icon"><i class="fas fa-info"></i></div>
        <div class="toast-content">
            <div class="toast-title">Cảnh báo</div>
            <div class="toast-message">{{ session()->get('warning') }}</div>
        </div>
        <div class="close-toast"><i class="fas fa-times"></i></div>
        <div class="progress active"></div>
    </div>
@endif
