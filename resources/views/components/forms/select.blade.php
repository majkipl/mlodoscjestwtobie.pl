<div class="field">
    <select class="input select"
            name="{{ $name }}"
            id="{{ $name }}"
            aria-label="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
    >
        <option value="0" selected>{{ $placeholder }}</option>
        @foreach($items as $item)
            <option value="{{ $item->id }}" {{ isset($selected) && $selected === $item->id ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
</div>
<span class="error-post error-{{ $name }}">{{ $error }}</span>
