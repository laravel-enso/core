<ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
        <li>
            <a class="{{ $breadcrumb['link'] ? null : 'greyed'}}"
            	{{ $breadcrumb['link'] ? ('href=/' . $breadcrumb['link']) : null }}>
                {{ $breadcrumb['label'] }}
            </a>
        </li>
    @endforeach
</ol>