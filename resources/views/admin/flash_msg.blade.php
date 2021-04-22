@if(session('success'))
	<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-9 text-white">
		<div style="font-size: 26px;">
			<i class="fal fa-exclamation-circle w-6 h-6 mr-4 fa-lg"></i>
		</div>
		{!! session('success') !!}
	</div>
@endif

@if(session('error'))
	<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-6 text-white">
		<div style="font-size: 26px;">
			<i class="fal fa-exclamation-circle w-6 h-6 mr-4 fa-lg"></i>
		</div>
		{!! session('error') !!}
	</div>
@endif