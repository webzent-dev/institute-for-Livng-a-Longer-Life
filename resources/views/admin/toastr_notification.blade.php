<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}"/>
<link rel="stylesheet" href="{{asset('css/switch.css')}}"/>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
@if(session("success"))
<script type="text/javascript">
    toastr.options = {
        closeButton: true,
        progressBar: true,
        preventDuplicates: true,
        preventOpenDuplicates: true
    };
    toastr.success("{{ session('success') }}");
</script>
@endif

@if(session("error"))
<script type="text/javascript">
    toastr.options = {
        closeButton: true,
        progressBar: true,
        preventDuplicates: true,
        preventOpenDuplicates: true,
    };
    toastr.error("{{ session('error') }}");
</script>
@endif