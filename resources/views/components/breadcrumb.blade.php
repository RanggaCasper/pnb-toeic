@props([
    'title',
    'li_1',
    'li_1_href' => 'javascript:void(0)'
])
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title ?? config('app.name') }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @if ($li_1)
                        <li class="breadcrumb-item"><a href="{{ $li_1_href }}">{{ $li_1 }}</a></li>
                    @endif
                    @if(isset($title))
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div>

        </div>
    </div>
</div>
