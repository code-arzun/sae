@if (session()->has('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showSuccessAlert("{{ session('success') }}");
        });
    </script>
@elseif (session()->has('created'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showCreatedAlert("{{ session('created') }}");
        });
    </script>
@elseif (session()->has('added'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showAddedAlert("{{ session('added') }}");
        });
    </script>
@elseif (session()->has('danger'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showDangerAlert("{{ session('danger') }}");
        });
    </script>
@endif