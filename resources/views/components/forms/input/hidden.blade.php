<div class="field @isset($class){{ $class }}@endisset">
    <input type="hidden"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ $value }}"
    />
</div>
<span class="error-post error-{{ $name }}">{{ $error }}</span>
