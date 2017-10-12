<div class="field">
    <input type="email"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ $value }}"
           placeholder="{{ $placeholder }}"
           aria-label="{{ $placeholder }}"
           {{ $required ? 'required' : '' }}
           @if($max)
               maxlength="{{ $max }}"
           @endif
               class="input"
           autocomplete="off"/>
</div>
<span class="error-post error-{{ $name }}">{{ $error }}</span>
