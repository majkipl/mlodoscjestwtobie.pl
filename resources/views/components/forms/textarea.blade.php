<div class="field">
    <textarea class="textarea"
              name="{{ $name }}"
              id="{{ $name }}"
              {{ $required ? 'required' : '' }}
              @if($max)
                  maxlength="{{ $max }}"
              @endif
              autocomplete="off"
              placeholder="{{ $placeholder }}"
              aria-label="{{ $placeholder }}">{{ $slot }}</textarea>
    <div class="error-post error-{{ $name }}">{{ $error }}</div>
</div>
