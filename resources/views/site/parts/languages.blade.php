<div id="languages" class="languages">
    @foreach($locales as $locale => $properties)
        <a href="{{ LaravelLocalization::localizeURL(route($currentRoute), $locale) }}" class="languages__item languages__item_{{ $locale == $currentLocale ? 'selected' : '' }}">
            {{ ucfirst($locale) }}
        </a>
    @endforeach
</div>

<script>
    $( "#languages" ).change(function(e) {
        window.location.href = $('#languages option:selected').attr('value');
    });
</script>