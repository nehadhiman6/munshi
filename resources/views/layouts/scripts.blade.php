<!-- scripts in script page -->
<script>
const lh_no = "DocumentGeneratorLetterHead";
</script>

<script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
<script type="text/javascript" src="{{ asset(mix('js/session_out_login.js')) }}"></script>
<script type="text/javascript" src="{{ asset(mix('js/custom.js')) }}"></script>

<script src="{{ asset('assets/js/vendorjs.js') }}" type="text/javascript"></script>
{{-- datatable --}}
{{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-html5-1.5.6/fc-3.2.5/fh-3.1.4/r-2.2.2/rr-1.2.4/datatables.min.js"></script> --}}
{{-- select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.min.js"></script> --}}
{{-- <script src="{{ asset('assets/js/customjs.js') }}"  type="text/javascript"></script>
<script src="{{ asset('plugins/sidebar/sidebar.js') }}"  type="text/javascript"></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lg-video/1.2.2/lg-video.js"></script> --}}
{{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript"
src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/datatables.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var loginToken = '';
    // replace project name;
    var appname = "{{ config('app.name') }}";
    var table_scroll = "{{ config('app.table_scroll') }}";
    window[appname] = {
        base_url: "{{ url('/') }}",
        block_loading: true,
        table_scroll: table_scroll,
        permissions: {!! json_encode(getPermissions()) !!},
        payment_key: "{{ config('services.stripe.key') }}",
        today: "{{ getToday('m-d-Y') }}",
        yesterday: "{{ yesterday('m-d-Y') }}",
        ac_no: "{{ get_acno() }}",
    };
</script>

<script>
    $(document).ready(function() {
        $(".filter-btn").click(function() {
            $(".filter-content").slideToggle();
        });
    });
</script>


{{-- <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    </script> --}}

<script>
    $(function() {
        // $('[data-toggle="tooltip"]').tooltip();

        //   editable content blur on enter
        $('body').on('keydown', '.editable', function(event) {
            var target = $(event.target);
            c = event.keyCode;

            if (c === 13 || c === 27) {
                $(".editable").blur();
                // Workaround for webkit's bug
                window.getSelection().removeAllRanges();
            }
        })
    });


    $(document).on('click', '.iwj-sidebar-toggle-btn', function(e) {
        var closed = $("body").hasClass("sidebar-mini") ? 'closed' : 'open';
        axios.post(Munshi.base_url + '/preferences', {
                'sidebar': closed
            })
            .then(function(response) {})
            .catch(function(error) {});
    });


    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });;
</script>
