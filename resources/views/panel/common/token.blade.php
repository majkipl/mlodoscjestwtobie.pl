<script>
    const token = '{{ isset(Auth::user()->api_token) ? Auth::user()->api_token : '' }}';
</script>
