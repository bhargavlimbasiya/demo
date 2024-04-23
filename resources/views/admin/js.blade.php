<!--begin::Javascript-->
<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Vendors Javascript(used by this page)-->
	<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
	<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
	<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
	<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
	 {{-- <script src="{{ asset('assets/js/custom/account/settings/profile-details.js')}}"></script> --}}
	<script src="{{ asset('assets/js/custom/account/settings/signin-methods.js')}}"></script>
	<!--end::Vendors Javascript-->
	<!--begin::Custom Javascript(used by this page)-->
	 <script src="{{ asset('assets/js/widgets.bundle.js')}}"></script>
	<script src="{{ asset('assets/js/custom/widgets.js')}}"></script>
	<script src="{{ asset('assets/js/custom/apps/chat/chat.js')}}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/new-target.js')}}"></script>
	<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
	<script src="{{ asset('assets/js/parsley.js') }}"></script>
	<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        $('form').parsley();
    });
    </script>
    @livewireScripts
	@if(session()->has('success'))
    <script>
        toastr['success']('{{session("success")}}');
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        toastr['error']('{{session("error")}}');
    </script>
    @endif
	<!--end::Custom Javascript-->
