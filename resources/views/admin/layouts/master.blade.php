@include('admin.partials.header-essentials')

<div class="admin container page-container">
	@include('admin.partials.navigation')
	<br>
	<div class='row'>
        @yield('content')
    </div>
</div>

@include('admin.partials.footer-essentials')