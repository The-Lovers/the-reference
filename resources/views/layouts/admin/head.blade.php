 <div class="page-header">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10"><a href="{{ route('dashboard') }}">{{ __('dashboard.sidebar.dashboard') }}</a></h5>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('dashboard.header.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.sidebar.dashboard') }}</a></li>
        </ul>
    </div>
    <div class="page-header-right ms-auto">
        <div class="page-header-right-items">
            <div class="d-flex d-md-none">
                <a href="javascript:void(0)" class="page-header-right-close-toggle">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    <span>{{ __('dashboard.header.back') }}</span>
                </a>
            </div>
            <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                <div id="reportranges" class="d-flex align-items-center">
                    <span id="show-date"></span>
                </div>
            </div>
        </div>
        <div class="d-md-none d-flex align-items-center">
            <a href="javascript:void(0)" class="page-header-right-open-toggle">
                <i class="fa-solid fa-align-right fs-20"></i>
            </a>
        </div>
    </div>
</div>
<script>
  const today = new Date();
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const formattedDate = today.toLocaleDateString('fr-FR', options);
  document.getElementById('show-date').textContent = formattedDate;
</script>
