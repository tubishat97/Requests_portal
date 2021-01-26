<script src="{{ asset('src/js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('plugins/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/screenfull/dist/screenfull.js') }}"></script>
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>

<!-- Stack array for including inline js or scripts -->
@stack('script')

<script src="{{ asset('dist/js/theme.js') }}"></script>
<script src="{{ asset('js/chat.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#removePhoto").on("submit", function(event){
            event.preventDefault();

            var formValues= $(this).serialize();
            var url    =   $(this).attr('action');

            $.post(url, formValues, function(data){
                $("#exampleModalCenter").modal('hide');
                var photo = $('#photo_name').val();
                $("."+photo).remove();
            });
        });
    });

    function setRoute($id, $route) {
        $('#item_id').val($id);
        $('#frm_confirm_delete').attr('action', $route);
    }
    function setSubRoute($id, $route) {
        $('#item_id').val($id);
        //$('#frm_confirm_delete').attr('action', $route);
    }
    function removePhoto(photo) {
        $('#photo_link').val(photo.dataset.role);
        $('#photo_name ').val(photo.dataset.name);
    }
</script>
